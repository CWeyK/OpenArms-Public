<?php require_once "server.php";


?>
<html>

<head>
<meta charset="UTF-8" />
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
        <div class="login-container">
            <h1 class="fw-bold">LOGIN</h1>
            <h4 class="fw-medium mb-5">Welcome Back.</h4>
            <?php 
                if(isset($_SESSION['loginstatus'])){ 
                echo $_SESSION['loginstatus'];
                unset($_SESSION['loginstatus']);
                }
            ?>
        <form action="server.php" method="post">
            <div class="mb-4">
                <p class="mb-1">Email</p>
                <input type="email" class="login-input" placeholder="Email Address" name="email" required/>
            </div>
            <div class="mb-1">
                <p class="mb-1">Password</p>
                <input type="password" class="login-input" placeholder="Password" name="password" required/>
            </div>
            <div class="d-flex justify-content-between mb-4">
                <div class="align-items-center d-flex">
                    <input type="checkbox" name="rememberMe" class="login-checkbox"/>
                    <label style="font-size: 14px;" class="ms-1">Remember me</label>
                </div>
                <a href="forgotPassword.php" style="color: black; font-size: 14px;">Forgot Password?</a>
            </div>
            <button type="submit" value="login" name="login" class="mt-3 mb-2 signinBtn rounded fw-semibold" style="width: 450px; height: 50px;">Sign In</button>
            <p>Don't have an account? <a href="register.php" style="color: black;">Sign Up</a></p>
            <p>Or <a href="index.php" style="color: black;">browse</a> as a guest</p>
        </form>
        </div>
    </div>
</body>

</html>