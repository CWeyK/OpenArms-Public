<!--Check which header to use based on whether user is logged in or not-->
<?php
require_once 'server.php';
//Check if in home page
//echo (basename($_SERVER['SCRIPT_FILENAME']));
if ((basename($_SERVER['SCRIPT_FILENAME'])) == "index.php" || (basename($_SERVER['SCRIPT_FILENAME'])) == "aboutUs.php") {
    $navbar = "homeNavbar";
} else {
    $navbar = "nav-scrolled";
}
//echo $_SESSION['userid'];
if (!isset($_SESSION['userid'])) {
?>
    <!-- No Login Header -->
    <header>
        <nav class="<?= $navbar ?> navbar position-fixed w-100 z-3">
            <div class="container-fluid justify-content-around">
                <a class="d-flex align-items-center navbar-brand m-0" href="index.php" style="width: 175px">
                    <img src="./images//LogoTrans.png" height="60px" width="60px" />
                    <p class="mb-0 logo" style="font-size: 16px">OPENARMS</p>
                </a>

                <div class="d-flex text-white fw-semibold" style="font-size: 14px;">
                    <a href="discoverJ.php" class="nav-link mx-3 p-1">Discover</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginFirst" class="nav-link mx-3 p-1">Start A Campaign</a>
                    <a href="pointShop.php" class="nav-link mx-3 p-1">Points Shop</a>
                    <a href="aboutUs.php" class="nav-link mx-3 p-1">About Us</a>
                    <a href="contact.php" class="nav-link mx-3 p-1">Contact</a>
                </div>

                <div style="width: 175px" class="text-center fw-semibold">
                    <a href="login.php" class="signinBtn">Sign In</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="modal fade" id="loginFirst" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border: none !important;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-auto mb-4 text-center">
                <h5 class="fw-bold mb-4">Please login before proceeding.</h5>
                <a href="./login.php" class="signInBtn rounded-pill">Login Now</a>
            </div>
        </div>
    </div>
</div>



<?php
} else {
?>

    <header>
        <nav class="<?= $navbar ?> navbar position-fixed w-100 z-3">
            <div class="container-fluid justify-content-around">
                <a class="align-items-center navbar-brand m-0 logoContainer" href="index.php" style="width: 175px">
                    <img src="./images//LogoTrans.png" height="60px" width="60px" />
                    <p class="mb-0 logo" style="font-size: 16px">OPENARMS</p>
                </a>

                <div class="d-flex fw-semibold" style="font-size: 14px;">
                    <a href="discoverJ.php" class="nav-link mx-3 p-1">Discover</a>
                    <a href="startCampaign.php" class="nav-link mx-3 p-1">Start a Campaign</a>
                    <a href="pointShop.php" class="nav-link mx-3 p-1">Points Shop</a>
                    <a href="aboutUs.php" class="nav-link mx-3 p-1">About Us</a>
                    <a href="contact.php" class="nav-link mx-3 p-1">Contact</a>
                </div>

                <!--Dropdown-->
                <img src="images/<?= $_SESSION['profilepicture'] ?>" class="user-pic" onclick="toggleMenu()">
                <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <div class="user-info">
                            <img src="images/<?= $_SESSION['profilepicture'] ?>">
                            <h3><?php echo  $_SESSION['name']; ?></h3>
                        </div>
                        <hr>
                        <a href="userProfile.php" class="sub-menu-link">
                            <div class="col-1">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <p> Edit Profile</p>
                        </a>
                        <!--Extra option if admin-->
                        <?php
                        if ($_SESSION['rank'] == "Admin") {
                        ?>
                            <a href="adminApproveCampaign.php" class="sub-menu-link">
                                <div class="col-1">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <p> Admin Dashboard</p>
                            </a>
                        <?php } ?>
                        <a href="orderHistory.php" class="sub-menu-link">
                            <div class="col-1">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <p> Order History</p>
                        </a>
                        <a href="campaignOrganized.php" class="sub-menu-link">
                            <div class="col-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <p> My Campaign</p>
                        </a>
                        <a href="logout.php" class="sub-menu-link">
                            <div class="col-1">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </div>
                            <p> Logout</p>
                        </a>
                    </div>
                </div>
                <!--<div style="width: 175px">
                    <a href="#" class="profileBtn"><i class="fa-solid fa-user"></i></a>
                </div>-->
            </div>
        </nav>
    </header>
    <script src="js/header.js"></script>

    
<?php
}
?>

