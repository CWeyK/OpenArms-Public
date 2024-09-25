<?php 
require_once "conn.php";
session_start();



//once register button is clicked (register.php)
if (isset($_POST['register'])){
    $firstName = $_POST["firstName"];
    $lastName= $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if(isset($_POST["referrer"])){
        $referrer=$_POST["referrer"];
    }else{
        $referrer=null;
    }

    //error if email already in use
    $emailquery="SELECT * FROM user WHERE email='$email'";
    $emailresult=mysqli_query($conn,$emailquery);
    $emailcount=mysqli_num_rows($emailresult);
    if($emailcount>0){
        $_SESSION['registerstatus']= "<div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0' style='width: fit-content;'>
        Email already in use!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: register.php");
        return 0;
    }

    //error if referral code does not exist
    $referrerquery="SELECT * FROM user WHERE referralCode='$referrer'";
    $referrerresult=mysqli_query($conn,$referrerquery);
    $referrercount=mysqli_num_rows($referrerresult);
    if($referrercount==0 && $referrer!=null){
        $_SESSION['registerstatus']= "<div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0' style='width: fit-content;'>
        Referral code does not exist!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: register.php");
        return 0;
    }

    //if no errors, register user
    $epassword=md5($password);
    //generate random token
    $token = md5(rand());
    //generate referral code
    $referralCode = md5(rand());

    $query="INSERT INTO user
            (email,firstName,lastName,password,token,profilepicture,points,rank,referralCode,referrer)
            VALUES
            ('$email','$firstName','$lastName','$epassword','$token','profileicon.png',0,'User','$referralCode','$referrer')";
    $query_run=mysqli_query($conn,$query);

    $userid=mysqli_insert_id($conn);    
    
    if($query_run){
        $_SESSION['registerstatus']= "
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0' style='width: fit-content;'>
        Registration Succesful!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: register.php");
    }
    else{
        $_SESSION['registerstatus']= "<div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0' style='width: fit-content;'>
        Registration Failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: register.php");
    }

}

//------------------------------------------------------------------------------------------------

//once signin button is clicked (login.php)
if (isset($_POST['login'])){
    $email = (!empty($_POST["email"]))?$_POST["email"]:"";
    $password = (!empty($_POST["password"]))?$_POST["password"]:"";
    //encrypt password
    $epassword=md5($password);


    //check for account in database
    $query="select * from user where '$email'=email AND '$epassword'=password";
    $query_run=mysqli_query($conn, $query);

    //log in part
    if(mysqli_num_rows($query_run)==1){
        //save data for use across sessions
        $udata=mysqli_fetch_array($query_run);
        $userid=$udata['userid'];
        $name=$udata['firstName']." ".$udata['lastName'];
        $profilepicture=$udata['profilepicture'];
        $_SESSION['name']=$name;
        $_SESSION['userid']=$userid;
        $_SESSION['profilepicture']=$profilepicture;
        $_SESSION['rank']=$udata['rank'];
        //debug part
        //$_SESSION['loginstatus']= "Log in successful";
        //header('location: login2.php');
        //redirect to home page
        //remember me part
        if (isset($_POST["rememberMe"])) {
            $expiry_time = time() + (30 * 24 * 60 * 60); // 30 days from now
            setcookie("email", $email, $expiry_time, "/");
            setcookie("password", $epassword, $expiry_time, "/");
        }
        header('location: index.php');
    }else{
        $_SESSION['loginstatus']= "
        <div class='loginAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Invalid Email or Password!
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
        </div>";
    header('location: login.php');
    }
}



//auto log in user
if (isset($_COOKIE["email"]) && isset($_COOKIE["password"])) {
    // Perform auto-login based on the token stored in the cookie
    $email=$_COOKIE["email"];
    $password=$_COOKIE["password"];
    $query="select * from user where '$email'=email AND '$password'=password";
    $query_run=mysqli_query($conn, $query);
    if(mysqli_num_rows($query_run)==1){
        //save data for use across sessions
        $udata=mysqli_fetch_array($query_run);
        $userid=$udata['userid'];
        $name=$udata['firstName']." ".$udata['lastName'];
        $profilepicture=$udata['profilepicture'];
        $_SESSION['name']=$name;
        $_SESSION['userid']=$userid;
        $_SESSION['profilepicture']=$profilepicture;
        $_SESSION['rank']=$udata['rank'];
        
    }
}



//------------------------------------------------------------------------------------------------

//ajax for campaign donors (campaignDetails.php) 
if(isset($_POST['sort'])){
    $sort = $_POST['sort'];
    $campaignid = $_POST['campaignid'];
    if($sort == "recentDonation"){
        $sort = "date";
    }else{
        $sort = "amount";
    }

    //fetch donors
    $donorquery="SELECT * FROM donation where campaignid=$campaignid ORDER BY $sort DESC LIMIT 5";
    $donorresult=mysqli_query($conn,$donorquery);
    $donors=mysqli_fetch_all($donorresult,MYSQLI_ASSOC);
    foreach($donors as $donor){
        //fetch donor details
        $donordetailsquery="SELECT * FROM user where userid=".$donor['donorid'];
        $donordetailsresult=mysqli_query($conn,$donordetailsquery);
        $donordetails=mysqli_fetch_assoc($donordetailsresult);

        //calculate how long ago
        $today=date("Y-m-d H:i:s");
        $date=date_create($donor['date']);
        $date=date_format($date,"Y-m-d H:i:s");
        $diff=date_diff(date_create($date),date_create($today));
        //if less than 1 day ago
        if($diff->format("%a")<1){
            //if less than 1 hour ago
            if($diff->format("%h")<1){
                //if less than 1 minute ago
                if($diff->format("%i")<1){
                    $diff=$diff->format("%s seconds");
                }else{
                    $diff=$diff->format("%i minutes");
                }
            }else{
                $diff=$diff->format("%h hours");
            }
        }else{
            $diff=$diff->format("%a days");
        }
        //if anonymous
        if($donor['anonymous']==1){
            $donordetails['firstName']="Anonymous";
            $donordetails['lastName']="";
            $donordetails['profilepicture']="profileicon.png";
        }

?>

<div class="userDonations d-flex">
    <img src="./images/<?=$donordetails['profilepicture']?>" style="width: 2.25rem; height: 2.25rem; object-fit:fill;" class="me-3 rounded-circle" />
    <div>
        <p class="m-0" style="font-size: 0.75rem;"><?=$donordetails['firstName']?> <?=$donordetails['lastName']?></p>
        <div class="d-flex align-items-center">
            <p class="m-0 fw-bold me-2" style="font-size: 0.75rem; color: #4C4C4C;">RM<?=$donor['amount']?></p>
            <span style="font-size: 4px; color: #D9D9D9;" class="me-2"><i class="fa-solid fa-circle"></i></span>
            <p class="m-0" style="font-size: 0.75rem;"><?=$diff?> ago</p>
        </div>
    </div>
</div>
<?php 
    }
}

//------------------------------------------------------------------------------------------------

//edit user profile (userProfile.php)
if (isset($_POST['profileSave'])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $contact=$_POST["contact"];
    $address=$_POST["address"];
    $birthday=$_POST["birthday"];
    
    
    //update user details
        $query="UPDATE user SET firstName='$firstName',lastName='$lastName',contact='$contact',address='$address', birthday='$birthday' WHERE userid=".$_SESSION['userid'];
        $query_run=mysqli_query($conn,$query);
        if($query_run){
            $_SESSION['name']=$firstName." ".$lastName;
            $_SESSION['profilestatus']= "
            <div class='successAlert'>
            <div class='alert alert-success alert-dismissible m-0'>
            Profile updated!
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
            </div>";
        header("Location: userProfile.php?userid=".$_SESSION['userid']);
    }
    else{
        $_SESSION['profilestatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Profile update failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
        </div>";
        header("Location: userProfile.php?userid=".$_SESSION['userid']);
    }
    
}

//------------------------------------------------------------------------------------------------

//donation payment (donateCampaign.php)
if (isset($_POST['donate'])){
    $amount = $_POST["amount"];
    $campaignid=$_POST["campaignid"];
    $date=date("Y-m-d H:i:s");
    //check anonymous 
    if(isset($_POST['anonymous'])){
        $anonymous=1;
    }else{
        $anonymous=0;
    }
    //insert into donation
    $query="INSERT INTO donation
            (campaignid,donorid,amount,date,anonymous)
            VALUES
            ('$campaignid','".$_SESSION['userid']."','$amount','$date','$anonymous')";
            
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        //give user points
        $query="UPDATE user SET points=points+$amount WHERE userid=".$_SESSION['userid'];
        $query_run1=mysqli_query($conn,$query);
        //give referrer points
        $query="SELECT * FROM user WHERE userid=".$_SESSION['userid'];
        $query_run=mysqli_query($conn,$query);
        $user=mysqli_fetch_assoc($query_run);
        $referrer=$user['referrer'];
        if($referrer!=null){
            $referamount=$amount*0.1;
            $query="UPDATE user SET points=points+$referamount WHERE referralCode='$referrer'";
            $query_run=mysqli_query($conn,$query);
        }
        if($query_run1){
            $_SESSION['donateStatus']= "
            <div class='successAlert'>
            <div class='alert alert-success alert-dismissible m-0' style='width: fit-content;'>
            Donation Received Succesfully! You have earned $amount points!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            </div>";

            header("Location: campaignDetails.php?cid=".$campaignid);
        }

        
    }
    else{
        $_SESSION['donateStatus']= "
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        header("Location: campaignDetails.php?cid=".$campaignid);
    }
}

//------------------------------------------------------------------------------------------------

//start campaign (startCampign.php)
if (isset($_POST['startCampaign'])){
    $category=$_POST["category"];
    $state=$_POST["state"];
    $country=$_POST["country"];
    $campaignName=$_POST["campaignName"];
    
    $description=$_POST["description"];
    $goal=$_POST["goal"];

    echo "<pre>";
    print_r($_FILES['campaignPicture']);
    echo "</pre>";

    $img_name = $_FILES['campaignPicture']['name'];
    $img_size = $_FILES['campaignPicture']['size'];
    $tmp_name = $_FILES['campaignPicture']['tmp_name'];
    $error = $_FILES['campaignPicture']['error'];

    if ($error === 0) {
        if ($img_size < 12500000) {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png"); 

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'images/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                // Insert into Database
                $sql = "INSERT INTO campaign
                (campaignName,campaignDetails,goal,picture,organizer,dateRequested,approvalStatus,category,state,country)
                VALUES
                ('$campaignName','$description','$goal','$new_img_name','".$_SESSION['userid']."',NOW(),'Pending','$category','$state','$country')";
                $query_run=mysqli_query($conn, $sql);
                if($query_run){
                header("Location: campaignDetails.php?cid=".mysqli_insert_id($conn));
                }
                else{
                    echo "Error: " . $query . "<br>" . mysqli_error($conn);
                }

            }
        
        }
    }
    
}

//------------------------------------------------------------------------------------------------

//user upload profile picture (userProfile.php)
if (isset($_POST['editProfilePicture']) && isset($_FILES['profilePicture'])) {
	

	echo "<pre>";
	print_r($_FILES['profilePicture']);
	echo "</pre>";

	$img_name = $_FILES['profilePicture']['name'];
	$img_size = $_FILES['profilePicture']['size'];
	$tmp_name = $_FILES['profilePicture']['tmp_name'];
	$error = $_FILES['profilePicture']['error'];

	if ($error === 0) {
		if ($img_size > 12500000) {
			$_SESSION['passwordStatus']="<div class='successAlert'>
            <div class='alert alert-danger alert-dismissible m-0'>
            File too large!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            </div>";
		    header ("Location: userProfile.php?userid=".$_SESSION['userid']);
		}else {
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$allowed_exs = array("jpg", "jpeg", "png"); 

			if (in_array($img_ex_lc, $allowed_exs)) {
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$img_upload_path = 'images/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);
                $uid=$_SESSION['userid'];
                //Insert into Database
                $sql = "UPDATE user SET profilepicture='$new_img_name' WHERE userid='$uid'";
                mysqli_query($conn, $sql);
                $_SESSION['passwordStatus']="<div class='successAlert'>
                <div class='alert alert-success alert-dismissible m-0'>
                Profile picture updated!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                </div>";
                $_SESSION['profilepicture']=$new_img_name;
                header ("Location: userProfile.php?userid=".$_SESSION['userid']);
			}else {
				$_SESSION['passwordStatus']="<div class='successAlert'>
                <div class='alert alert-danger alert-dismissible m-0'>
                Invalid file type!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                </div>";
                header ("Location: userProfile.php?userid=".$_SESSION['userid']);
			}
		}
	}else {
		$_SESSION['passwordStatus']="<div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation Failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
		header ("Location: userProfile.php?userid=".$_SESSION['userid']);
	}
}

//------------------------------------------------------------------------------------------------

//point shop add to cart (pointShop.php)
if(isset($_POST['addCart'])){
    $productid=$_POST['productid'];
    $quantity=$_POST['quantity'];
    //check if product already in cart
    $cartquery="SELECT * FROM cart WHERE userid=".$_SESSION['userid']." AND productid=$productid";
    $cartresult=mysqli_query($conn,$cartquery);
    $cart=mysqli_fetch_assoc($cartresult);
    //if product already in cart, update quantity
    if($cart){
        $quantity+=$cart['quantity'];
        $query="UPDATE cart SET quantity=$quantity WHERE userid=".$_SESSION['userid']." AND productid=$productid";
    }else{
        //if product not in cart, insert into cart
        $query="INSERT INTO cart
            (userid,productid,quantity)
            VALUES
            (".$_SESSION['userid'].",$productid,$quantity)";
    }
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['addStatus']= "
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Added to cart!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        
        header("Location: pointShop.php");
    }
    else{
        $_SESSION['addStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Failed to add to cart!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: pointShop.php");
    }
}

//------------------------------------------------------------------------------------------------

//approve/reject campaign (adminApproveCampaign.php)
if(isset($_POST['approveCampaign'])){
    $campaignid=$_POST['campaignid'];
    $campaignName=$_POST['campaignName'];
    $query="UPDATE campaign SET approvalStatus='Approved' WHERE campaignid=$campaignid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['approveStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0' style='width: fit-content;'>
        Campaign ".$campaignName." Approved!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminApproveCampaign.php");
    }
    else{
        $_SESSION['approveStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminApproveCampaign.php");
    }
}
if(isset($_POST['denyCampaign'])){
    $campaignid=$_POST['campaignid'];
    $campaignName=$_POST['campaignName'];
    $query="UPDATE campaign SET approvalStatus='Denied' WHERE campaignid=$campaignid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['approveStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Campaign ".$campaignName." Denied!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminApproveCampaign.php");
    }
    else{
        $_SESSION['approveStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminApproveCampaign.php");
    }
}



//------------------------------------------------------------------------------------------------

//close campaign(adminManageCampaign.php)
if(isset($_POST['closeCampaign'])){
    $campaignid=$_POST['campaignid'];
    $campaignName=$_POST['campaignName'];
    $query="UPDATE campaign SET approvalStatus='Closed' WHERE campaignid=$campaignid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['closeStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Campaign ".$campaignName." Closed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminManageCampaign.php");
    }
    else{
        $_SESSION['closeStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminManageCampaign.php");
    }
}

//------------------------------------------------------------------------------------------------

//change user rank (adminManageUser.php)
if(isset($_POST['changeRank'])){
    $userid=$_POST['userid'];
    $rank=$_POST['userRank'];
    $query="UPDATE user SET rank='$rank' WHERE userid=$userid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['rankStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        User rank changed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminManageUser.php");
    }
    else{
        $_SESSION['rankStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminManageUser.php");
    }
}

//------------------------------------------------------------------------------------------------

//delete user (adminManageUser.php)
if(isset($_POST['deleteUser'])){
    $userid=$_POST['userid'];
    //close all of user's campaigns
    $query="UPDATE campaign SET approvalStatus='Closed' WHERE organizer=$userid";
    $query_run=mysqli_query($conn,$query);

    //set user's donation record
    $query="UPDATE donation SET donorid=0 WHERE donorid=$userid";
    $query_run=mysqli_query($conn,$query);



    $query="DELETE FROM user WHERE userid=$userid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['deleteStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        User deleted!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminManageUser.php");
    }
    else{
        $_SESSION['deleteStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: adminManageUser.php");
    }
}



//------------------------------------------------------------------------------------------------

//dynamic change quantity in database (cart.php)
if(isset($_POST['changeQuantity'])){
    $productId = $_POST["productId"];
    $newQuantity = $_POST["newQuantity"];
    $cartId = $_POST["cartId"];

    // Perform the database update
    $updateQuery = "UPDATE cart SET quantity = '$newQuantity' WHERE productid = '$productId' and cartid='$cartId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    // Get the updated cart count and total
    $cartQuery = "SELECT SUM(quantity) AS cartCount, SUM(quantity * price) AS cartTotal FROM cart INNER JOIN product ON cart.productid = product.productid WHERE userid = '".$_SESSION['userid']."'";
    $cartResult = mysqli_query($conn, $cartQuery);
    $cart = mysqli_fetch_assoc($cartResult);
    $updatedCartCount = $cart['cartCount'];
    $updatedCartTotal = $cart['cartTotal'];

    if ($updateResult) {
        $response = array(
            'updatedCartCount' => $updatedCartCount,
            'updatedCartTotal' => $updatedCartTotal
        );

        echo json_encode($response);
    } else {
        echo "Error updating quantity: " . mysqli_error($conn);
    }
}

//------------------------------------------------------------------------------------------------

//checkout (checkout.php)
if(isset($_POST['checkout'])){
    $userid=$_POST['userid'];
    $total=$_POST['total'];
    $orderData=$_POST['orderData'];
    $shippingAddress=$_POST['shippingAddress'];
    $date=date("Y-m-d H:i:s");

    //insert into purchase table
    $query="INSERT INTO purchase
            (userid,total,items,shippingAddress,date)
            VALUES
            ('$userid','$total','$orderData','$shippingAddress','$date')";
    $query_run=mysqli_query($conn,$query);

    //empty cart
    $query="DELETE FROM cart WHERE userid=$userid";
    $query_run=mysqli_query($conn,$query);

    //update user points
    $query="UPDATE user SET points=points-$total WHERE userid=$userid";
    $query_run=mysqli_query($conn,$query);

    header("Location: orderHistory.php");
}

//------------------------------------------------------------------------------------------------

//edit product (adminPointShop.php)
if(isset($_POST['editProduct'])){
    $productName=$_POST['productName'];
    $price=$_POST['price'];
    $productDetails=$_POST['productDetails'];
    $productid=$_POST['productid'];



    $query="UPDATE product SET productName='$productName',price='$price',productDetails='$productDetails' WHERE productid=$productid";    
    $query_run=mysqli_query($conn,$query);
    $querycheck=0;
    

    if ($_FILES['productPicture']['error'] !== UPLOAD_ERR_NO_FILE) {
        $querycheck=1;
        echo "<pre>";
        print_r($_FILES['productPicture']);
        echo "</pre>";

        $img_name = $_FILES['productPicture']['name'];
        $img_size = $_FILES['productPicture']['size'];
        $tmp_name = $_FILES['productPicture']['tmp_name'];
        $error = $_FILES['productPicture']['error'];

        if ($error === 0) {
            if ($img_size < 12500000) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png"); 

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'images/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                    $productid=$_POST['productid'];
                    // Insert into Database
                    $sql = "UPDATE product SET productPicture='$new_img_name' WHERE productid='$productid'";
                    $query_run2=mysqli_query($conn, $sql);
                }
            
            }
        }
    }

    if(($query_run && $querycheck==0) || ($query_run && $query_run2 && $querycheck==1)){
        $_SESSION['editProductStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Product edited!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: adminPointShop.php");
    }
    else{
        $_SESSION['editProductStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed! $querycheck
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: adminPointShop.php");
    }
}

//------------------------------------------------------------------------------------------------

//delete product (adminPointShop.php)
if(isset($_POST['deleteProduct'])){
    $productid=$_POST['productid'];
    $query="DELETE FROM product WHERE productid=$productid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['deleteProductStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Product deleted!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: adminPointShop.php");
    }
    else{
        $_SESSION['deleteProductStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: adminPointShop.php");
    }
}

//------------------------------------------------------------------------------------------------

//clear cart (cart.php)
if(isset($_POST['clearCart'])){
    $userid=$_SESSION['userid'];
    $query="DELETE FROM cart WHERE userid=$userid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['cartStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Cart cleared!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: cart.php");
    }
    else{
        $_SESSION['cartStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: cart.php");
    }
}

//------------------------------------------------------------------------------------------------

//remove item from cart (cart.php)
if(isset($_POST['removeCart'])){
    $productid=$_POST['productid'];
    $userid=$_SESSION['userid'];
    $query="DELETE FROM cart WHERE userid=$userid AND productid=$productid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['cartStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Item removed from cart!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: cart.php");
    }
    else{
        $_SESSION['cartStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: cart.php");
    }
}

//------------------------------------------------------------------------------------------------

//add product (adminPointShop.php)
if(isset($_POST['addProduct'])){
    $productName=$_POST['productName'];
    $price=$_POST['price'];
    $productDetails=$_POST['productDetails'];

    echo "<pre>";
    print_r($_FILES['productPicture']);
    echo "</pre>";

    $img_name = $_FILES['productPicture']['name'];
    $img_size = $_FILES['productPicture']['size'];
    $tmp_name = $_FILES['productPicture']['tmp_name'];
    $error = $_FILES['productPicture']['error'];

    if ($error === 0) {
        if ($img_size < 12500000) {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png"); 

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'images/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $productid=$_POST['productid'];
                // Insert into Database
                $sql = "INSERT INTO product (productName,price,productDetails,productPicture) VALUES ('$productName','$price','$productDetails','$new_img_name')";
                $query_run=mysqli_query($conn, $sql);
            }
        
        }
    }
    if($query_run){
        $_SESSION['addProductStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Product Added!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: adminPointShop.php");
    }
    else{
        $_SESSION['addProductStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: adminPointShop.php");
    }
    
}

//------------------------------------------------------------------------------------------------

//send password reset (forgotPassword.php)
//password reset function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function send_password_reset($get_name,$get_email,$token,$gmail_password,$gmail){
        
    $mail = new PHPMailer(true);
    $mail->isSMTP();                                         //Send using SMTP
    $mail->SMTPAuth   = true;    
    
    
    $mail->Host       = 'smtp.gmail.com';                    //Set the SMTP server to send through                               //Enable SMTP authentication
    $mail->Username   = $gmail;              //SMTP username
    $mail->Password   = $gmail_password;                  //SMTP password
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;     //Enable implicit TLS encryption
    $mail->Port       = 587;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($gmail, $get_name);
    $mail->addAddress($get_email);                             //Add a recipient  
    
    $mail->isHTML(true);                                    //Set email format to HTML
    $mail->Subject = 'Reset Password Notification';

    //Email format;
    $email_template= "<h2>Hello</h2>
    <h3>This is the password reset link for your OpenArms account.</h3>
    <br>
    <a href='http://localhost/openarms/resetPassword.php?token=$token&email=$get_email'>Click here to be redirected</a>";

    
    $mail->Body    = $email_template;
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->send();

}

if(isset($_POST['forgotPassword'])){
    //obtain email
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $token=md5(rand());
    $check_email="SELECT * FROM user WHERE email='$email'";
    $check_email_run=mysqli_query($conn,$check_email);
    if(mysqli_num_rows($check_email_run)>0){
        $row=mysqli_fetch_array($check_email_run);
        $get_name="OpenArms";
        $get_email=$row['email'];

        $update_token="UPDATE user SET token='$token' WHERE email='$get_email'";
        $update_token_run=mysqli_query($conn,$update_token);
        //obtain gmail password from database
        $gmail_password_query="SELECT * FROM mailer";
        $gmail_password_query_run=mysqli_query($conn,$gmail_password_query);
        $gmail_password_row=mysqli_fetch_array($gmail_password_query_run);
        $gmail_password=$gmail_password_row['password'];
        $gmail=$gmail_password_row['email'];
        
        if($update_token_run){
            send_password_reset($get_name,$get_email,$token,$gmail_password,$gmail);
            $_SESSION['forgotStatus']="
            <div class='loginAlert'>
            <div class='alert alert-success alert-dismissible m-0'>
            A password reset link has been sent to your email!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            </div>";
            header("Location: forgotPassword.php");
            return 0;
        }else{
            $_SESSION['forgotStatus']=  "
            <div class='loginAlert'>
            <div class='alert alert-danger alert-dismissible m-0'>
            Operation failed!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            </div>";
            header("Location: forgotPassword.php");
            return 0;
        }
    }else{
        $_SESSION['forgotStatus']=  "
        <div class='loginAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        No account registered with this email!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: forgotPassword.php");
        return 0;
    }

}

//reset password (resetPassword.php)
if(isset($_POST['resetPassword'])){
    $email=$_POST['email'];
    $token=$_POST['token'];
    $password=$_POST['password'];
    $repeatPassword=$_POST['repeatPassword'];
    $epassword=md5($password);
    
    if($repeatPassword==$password){
        //checktoken
        if(!empty($token)){
            if(!empty($email)){
                //checking token validity
                $check_token="SELECT token FROM user WHERE token='$token' AND email='$email'";
                $check_token_run=mysqli_query($conn,$check_token);
                if(mysqli_num_rows($check_token_run)){
                    //encrypt password
                    $epassword=md5($password);
                    $update_password="UPDATE user SET password='$epassword' WHERE email='$email'";
                    $update_password_run=mysqli_query($conn,$update_password);
                    if($update_password_run){
                        //generate and update token
                        $new_token=md5(rand());
                        $update_token="UPDATE user SET token='$new_token' WHERE email='$email'";
                        $update_token_run=mysqli_query($conn,$update_token);
                        $_SESSION['resetStatus']=  "
                        <div class='loginAlert'>
                        <div class='alert alert-success alert-dismissible m-0'>
                        Passwords reset successfully!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        </div>";
                        header("Location: resetPassword.php?token=$token&email=$email");
                        return 0;
                    }else{
                        $_SESSION['resetStatus']=  "
                        <div class='loginAlert'>
                        <div class='alert alert-danger alert-dismissible m-0'>
                        Operation Failed!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        </div>";
                        header("Location: resetPassword.php?token=$token&email=$email");
                        return 0;
                    }
                }else{
                    $_SESSION['resetStatus']=  "
                    <div class='loginAlert'>
                    <div class='alert alert-danger alert-dismissible m-0'>
                    Invalid Token!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    </div>";
                    header("Location: resetPassword.php?token=$token&email=$email");
                    return 0;
                }

            }else{
                $_SESSION['resetStatus']=  "
                <div class='loginAlert'>
                <div class='alert alert-danger alert-dismissible m-0'>
                Invalid Email!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                </div>";
                header("Location: resetPassword.php?token=$token&email=$email");
                return 0;
            }
        }else{
            $_SESSION['resetStatus']=  "
            <div class='loginAlert'>
            <div class='alert alert-danger alert-dismissible m-0'>
            Invalid Token!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            </div>";
            header("Location: resetPassword.php?token=$token&email=$email");
            return 0;
        }
        
    }else{
        $_SESSION['resetStatus']=  "
        <div class='loginAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Passwords do not match!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header("Location: resetPassword.php?token=$token&email=$email");
        return 0;
    }
    
}

//------------------------------------------------------------------------------------------------

//close campaign (campaignDetails.php)
if(isset($_POST['closeCampaign'])){
    $campaignid=$_POST['campaignid'];
    $query="UPDATE campaign SET approvalStatus='Closed' WHERE campaignid=$campaignid";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $_SESSION['closeStatus']="
        <div class='successAlert'>
        <div class='alert alert-success alert-dismissible m-0'>
        Campaign Closed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: campaignDetails.php?cid=$campaignid");
    }
    else{
        $_SESSION['closeStatus']= "
        <div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Operation failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";

        header("Location: campaignDetails.php?cid=$campaignid");
    }
}

//------------------------------------------------------------------------------------------------

//pagination
function buildQueryString() {
    $queryString = '';

    foreach ($_GET as $key => $value) {
        if ($key !== 'page-nr') {
            $queryString .= "&$key=$value";
        }
    }

    return $queryString;
}

//------------------------------------------------------------------------------------------------

//change password (userProfile.php)
if(isset($_POST['changePassword'])){
    $oldPassword=$_POST['oldPassword'];
    $newPassword=$_POST['newPassword'];
    $ePassword=md5($newPassword);
    $eOldPassword=md5($oldPassword);

    //check old password match
    $query="SELECT * FROM user WHERE userid=".$_SESSION['userid'];
    $query_run=mysqli_query($conn,$query);
    $user=mysqli_fetch_assoc($query_run);
    $password=$user['password'];

    if($password==$eOldPassword){
        //update password
        $query="UPDATE user SET password='$ePassword' WHERE userid=".$_SESSION['userid'];
        $query_run=mysqli_query($conn,$query);
        if($query_run){
            $_SESSION['passwordStatus']="<div class='successAlert'>
            <div class='alert alert-success alert-dismissible m-0'>
            Password updated!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            </div>";
            header ("Location: userProfile.php");
        }
        else{
            $_SESSION['passwordStatus']="<div class='successAlert'>
            <div class='alert alert-danger alert-dismissible m-0'>
            Password update failed!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            </div>";
            header ("Location: userProfile.php?");
        }
    }else{
        $_SESSION['passwordStatus']="<div class='successAlert'>
        <div class='alert alert-danger alert-dismissible m-0'>
        Old password does not match!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        </div>";
        header ("Location: userProfile.php?");
    }
}
?>


