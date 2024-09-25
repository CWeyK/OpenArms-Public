<?php require_once "server.php" ?>
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
            <p class="mb-4">Please enter your email address and we will send you a password reset link.</p>
            <?php
            if (isset($_SESSION['forgotStatus'])) {
                echo $_SESSION['forgotStatus'];
                unset($_SESSION['forgotStatus']);
            }
            ?>
            <form action="server.php" method="post">
                <div class="mb-4">
                    <p class="mb-1">Email</p>
                    <input type="email" class="login-input" placeholder="Email Address" name="email" required />
                </div>
                <button type="submit" value="login" name="forgotPassword" class="mt-3 mb-2 signinBtn rounded fw-semibold" style="width: 450px; height: 50px;">Confirm</button>
            </form>
        </div>
    </div>
</body>

</html>