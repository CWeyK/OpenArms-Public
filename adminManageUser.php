<?php
include "header.php";
//check user permission
if($_SESSION['rank']!='Admin'){
    include "accessDenied.php";
 }else{

//get user details
if (isset($_GET['searchFilter'])) {
    $searchFilter = $_GET['searchFilter'];
    $searchFilter = mysqli_real_escape_string($conn, $searchFilter);
    $userquery = "SELECT * FROM user WHERE userid LIKE '%$searchFilter%' OR firstName LIKE '%$searchFilter%' OR lastName LIKE '%$searchFilter%' OR email LIKE '%$searchFilter%' OR contact LIKE '%$searchFilter%' OR address LIKE '%$searchFilter%' OR birthday LIKE '%$searchFilter%' or rank LIKE '%$searchFilter%' ";
} else {
    $userquery = "SELECT * FROM user";
}
$userresult = mysqli_query($conn, $userquery);
$users = mysqli_fetch_all($userresult, MYSQLI_ASSOC);
$count=mysqli_num_rows($userresult);
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
</head>

<body>
    <div class="adminSidebar">
        <h5 class="fw-bold mb-0 pb-3 px-3" style="border-bottom: 1px solid #D9D9D9;">Dashboard</h5>
        <nav class="nav flex-column">
            <a class="sidebarNavItems" href="adminApproveCampaign.php">Approve Campaigns</a>
            <a class="sidebarNavItems" href="adminManageCampaign.php">Manage Campaigns</a>
            <a class="sidebarNavItems active" href="adminManageUser.php">Manage Users</a>
            <a class="sidebarNavItems" href="adminPointShop.php">Manage Point Shop</a>
        </nav>
    </div>
    <div class="mainContent admin" style="font-size: 0.75rem;">
    <form action="adminManageUser.php" method="GET">
        <div class="d-flex justify-content-between mb-4">
            <h5 class="fw-bold">Manage Users</h5>
            <div class="input-group" style="height: 30px; width: 250px;">
                <input type="text" name="searchFilter" class="form-control form-control-sm" placeholder="Search...">
                <?php if (isset($_GET['searchFilter'])) { ?>
                            <a href="adminManageUser.php" class="btn btn-outline-secondary py-1">Clear</a>
                    <?php } ?>
            </div>
        </div>
    </form>
    <?php if (isset($_GET['searchFilter'])) { ?>
                <p>Searching for "<?= $searchFilter?>" (<?=$count?>) results found</p>
            <?php } ?>
        <div class="row">
            <?php 
            if(isset($_SESSION['rankStatus'])){
                echo $_SESSION['rankStatus'];
                unset($_SESSION['rankStatus']);
            }
            
            if(isset($_SESSION['deleteStatus'])){
                echo $_SESSION['deleteStatus'];
                unset($_SESSION['deleteStatus']);
            }

            foreach ($users as $user) {
            ?>
            <!-- loop start -->
            <div class="col-6 mb-3">
                <div class="card userCard">
                    <div class="adminEditUserButton">
                        <div class="dropdown">
                            <button type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-sliders fs-6"></i>
                            </button>
                            <ul class="dropdown-menu" style="font-size: 0.875rem;">
                                <!-- edit button (modal) -->
                                <li><button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#editModal<?=$user['userid']?>"><i class="fa-solid fa-wrench me-2"></i>Edit</button></li>
                                <!-- delete button (modal) -->
                                <li><button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?=$user['userid']?>"><i class="fa-regular fa-circle-xmark me-2"></i>Delete</button></li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex">
                        <img src="./images/<?=$user['profilepicture']?>" style="height: 100px; width: 100px;" class="rounded-circle"/>
                        <div class="userCardDetails">
                            <!-- role -->
                            <p class="fw-bold cardCategory m-0 fs-6"><?=$user['rank']?></p>
                            <!-- name -->
                            <p class="card-title fs-6"><?=$user['firstName']?> <?=$user['lastName']?></p>
                            <div class="row">
                                <div class="col-3">
                                    <p class="mb-1 fw-semibold" style="color: #555555">Email: </p>
                                </div>
                                <div class="col-9">
                                    <!-- contact -->
                                    <p class="m-0"><?=$user['email']?></p>
                                </div>
                                <div class="col-3">
                                    <p class="m-0 fw-semibold" style="color: #555555">Contact: </p>
                                </div>
                                <div class="col-9">
                                    <!-- email -->
                                    <p class="mb-1"><?=$user['contact']?></p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end loop -->
            <?php } ?>
        </div>
    </div>

    <!-- modal -->
    <?php
    foreach ($users as $user) {
    ?>
    <!-- edit modal -->
    <div class="modal fade modal-xl" id="editModal<?=$user['userid']?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold">User Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- form -->
                <form action="server.php" method="POST">
                    <div class="modal-body" style="font-size: 0.875rem;">
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label class="form-label">First Name</label>
                                <!-- First Name -->
                                <input type="text" class="form-control form-control-sm" placeholder="First Name" value="<?=$user['firstName']?>" disabled>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <!-- Last Name -->
                                <input type="text" class="form-control form-control-sm" placeholder="Last Name" value="<?=$user['lastName']?>" disabled>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Email Address</label>
                                <!-- Email -->
                                <input type="email" class="form-control form-control-sm" placeholder="Email" value="<?=$user['email']?>" disabled>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Birthday</label>
                                <!-- birthday -->
                                <input type="date" class="form-control form-control-sm" placeholder="Birthday" value="<?=$user['birthday']?>" disabled>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Contact</label>
                                <!-- contact -->
                                <input type="text" class="form-control form-control-sm" placeholder="Contact" value="<?=$user['contact']?>" disabled>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Points</label>
                                <!-- points -->
                                <input type="number" class="form-control form-control-sm" placeholder="Points" value="<?=$user['points']?>" disabled>
                            </div>
                            <div class="col-8 mb-3">
                                <label class="form-label">Address</label>
                                <!-- address -->
                                <textarea class="form-control" style="font-size: 0.875rem; resize: none;" rows="4" disabled> <?=$user['address']?> </textarea>
                            </div>
                            <div class="col-4 mb-3">
                                <!--Hidden field for userid-->
                                <input type="hidden" name="userid" value="<?=$user['userid']?>">
                                <label class="form-label">Role</label>
                                <!-- role -->
                                <select class="form-select form-select-sm" name="userRank">
                                    <?php if($user['rank']=="User"){
                                        echo "<option value='User' selected>User</option>";
                                        echo "<option value='Admin'>Admin</option>";
                                    }else{
                                        echo "<option value='User'>User</option>";
                                        echo "<option value='Admin' selected>Admin</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <!-- save button (submit) -->
                        <button type="submit" name="changeRank" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php foreach ($users as $user) { ?>
    <!-- delete modal -->
    <div class="modal fade" id="deleteModal<?=$user['userid']?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold">Confirm Delete User?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <span class="fw-bold"><?=$user['firstName']?> <?=$user['lastName']?></span>?
                </div>
                <!--Hidden field for userid-->
                <form action="server.php" method="POST">
                <input type="hidden" name="userid" value="<?=$user['userid']?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- confirm delete button -->
                    <button type="submit" name="deleteUser" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>

</body>

</html>
<?php }?>