<?php
include "header.php";
//obtain cart details
$cartquery = "SELECT * FROM cart JOIN product ON cart.productid = product.productid WHERE cart.userid = " . $_SESSION['userid'];
$cartresult = mysqli_query($conn, $cartquery);
$cart = mysqli_fetch_all($cartresult, MYSQLI_ASSOC);

//obtain total number of items in cart
$countquery= "SELECT SUM(quantity) AS count FROM cart WHERE userid = ".$_SESSION['userid']. ";";
$countresult = mysqli_query($conn, $countquery);
$count = mysqli_fetch_assoc($countresult);
$cartCount = $count['count'];

//obtain total points
$totalquery= "SELECT SUM(quantity*price) AS total FROM cart INNER JOIN product ON cart.productid=product.productid WHERE userid = ".$_SESSION['userid']. ";";
$totalresult = mysqli_query($conn, $totalquery);
$total = mysqli_fetch_assoc($totalresult);
$cartTotal = $total['total'];

//obtain user points
$userquery= "SELECT points FROM user WHERE userid = ".$_SESSION['userid']. ";";
$userresult = mysqli_query($conn, $userquery);
$user = mysqli_fetch_assoc($userresult);
$userPoints = $user['points'];

$balance=$userPoints-$cartTotal;

$productData=[];
?>

<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OpenArms</title>
    <link rel="stylesheet" href="css/styleJ.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/366cfb40a4.js" crossorigin="anonymous"></script>
    
    <?php if($balance<0){ ?>
    <script src="./js/checkoutButton.js"></script>
    <?php } ?>
</head>

<body>
    <div class="mainContent" style="font-size: 0.875rem;">
        <div class="card mx-auto p-3 mt-4" style="border-radius: 15px; width: 40%;">
            <a href="cart.php" class="text-decoration-none fw-semibold mb-2" style="color: black; max-width: fit-content;">
                <i class="fa-solid fa-chevron-left me-2"></i>Back
            </a>
            <h6 class="my-2">Your purchase of 
                <!-- quantity of items -->
                <span class="fw-bold"><?=$cartCount?></span> 
                items</h6>
            <!-- items -->
            <br>
            <?php 
            foreach($cart as $cartItem){ 
                $orderData[] = ['productName' => $cartItem['productName'], 'quantity' => $cartItem['quantity'], 'pricePP' => $cartItem['price']];
            ?>    
            <div class="d-flex justify-content-between">
                <p class="m-0"><?=$cartItem['productName']?> x<?=$cartItem['quantity']?> (<?=$cartItem['price']?> points)</p>
                <p class="m-0"><?=$cartItem['price']*$cartItem['quantity']?> points</p>
            </div>
            <?php } ?>

            <hr>
            <!-- total points required -->
            <div class="d-flex justify-content-between">
                <p class="m-0">Total</p>
                <p class="m-0"><?=$cartTotal?> points</p>
            </div>
            <!-- your points -->
            <div class="d-flex justify-content-between">
                <p class="m-0">Your Points</p>
                <p class="m-0"><?=$userPoints?> points</p>
            </div>
            <hr>
            <!-- balance after deduct -->
            <div class="d-flex justify-content-between mb-4">
                <p class="m-0">Balance</p>
                <p class="m-0"><?=$balance?> Points</p>
            </div>

            <!--If not enough points-->
            <?php if($balance<0){ ?>
            <p class="m-0 fw-bold" style="color: red;">You do not have enough points to make this purchase.</p>
            <?php } ?>
            <?php 
                $jsonEncodedData = json_encode($orderData);
            ?>
            <form action="server.php" method="POST">
            <div class="my-3">
                <label class="form-label">Enter your shipping address</label>
                <!-- shipping address -->
                <textarea class="form-control" name="shippingAddress" rows="3" style="resize: none;" required></textarea>
                <!-- hidden input for order data -->
                <input type="hidden" name="orderData" value='<?php echo htmlspecialchars($jsonEncodedData, ENT_QUOTES, 'UTF-8'); ?>'>
                <input type="hidden" name="userid" value='<?=$_SESSION['userid']?>'>
                <input type="hidden" name="total" value='<?=$cartTotal?>'>
            </div>
            <!-- confirm button -->
            <button class="signInBtn mt-4 w-100" type="submit" name="checkout" id="confirmButton" style="border-radius: 15px;" >Confirm</button>
            <p class="m-0 fw-medium" style="font-size: 0.75rem;">
                By continuing, you agree with <a href="#" style="color: black;" data-bs-toggle="modal" data-bs-target="#termsModal">OpenArms terms</a> and <a href="#" style="color: black;" data-bs-toggle="modal" data-bs-target="#privacyModal">privacy note</a>.
                <br>Learn more about <a href="#" style="color: black;" data-bs-toggle="modal" data-bs-target="#pricingModal">pricing and fees</a>.
            </p>
            </form>
        </div>
    </div>

    <?php include "termsModal.php";?>
</body>


</html>
