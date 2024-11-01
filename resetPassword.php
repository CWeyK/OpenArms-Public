<?php require_once "server.php";
if(isset($_GET['email'])){
    $email = $_GET['email'];
}else{
    $email="";
}
if(isset($_GET['token'])){
    $token = $_GET['token'];
}

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

<body style="height: 100vh; width: 100vw; overflow: hidden;">
    <div class="d-flex w-100 h-100">
        <img src="./images/loginBg.jpg" style="width: 35%; height: 100%; object-fit:cover;" />
        <a href="login.php" class="backBtn position-absolute backLogin"><i class="fa-solid fa-arrow-left me-2"></i>Back to Login</a>
        <div class="login-container">
            <h1 class="fw-bold mb-5">Forgot Password</h1>
            <?php
            if (isset($_SESSION['resetStatus'])) {
                echo $_SESSION['resetStatus'];
                unset($_SESSION['resetStatus']);
            }
            ?>
            <form action="server.php" method="post">
                <div class="mb-4">
                    <p class="mb-1">Email</p>
                    <input type="email" class="login-input" placeholder="Email Address" name="email" value="<?= $email ?>" required readonly />
                </div>
                <div class="mb-4">
                    <p class="mb-1">New Password</p>
                    <input type="password" class="login-input" placeholder="Password" name="password" id="password" oninput="validatePassword()" required />
                    <small class="text-success" id="lengthHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Password must be at between 8 to 20 characters long</small>
                    <small class="text-danger" id="lengthHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Password must be at between 8 to 20 characters long</small>
                    <small class="text-success" id="numberHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Password must be contain at least 1 number</small>
                    <small class="text-danger" id="numberHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Password must be contain at least 1 number</small>
                    <small class="text-success" id="specialHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Password must not contain any special characters</small>
                    <small class="text-danger" id="specialHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Password must not contain any special characters</small>
                </div>
                <div class="mb-4">
                    <p class="mb-1">Repeat Password</p>
                    <input type="password" class="login-input" placeholder="Repeat Password" name="repeatPassword" id="repeatPassword" oninput="validatePassword()" required />
                    <small class="text-success" id="matchHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Both password matches</small>
                    <small class="text-danger" id="matchHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Both passwords do not match</small>
                </div>
                <input type="hidden" name="token" value="<?=$token?>">
                <button type="submit" id="reset" value="login" name="resetPassword" class="mt-3 mb-2 signinBtn rounded fw-semibold" style="width: 450px; height: 50px;">Confirm</button>
            </form>
        </div>
    </div>
</body>
<script src="js/reset.js"></script>

</html>