<?php
require_once 'server.php';
?>
<!DOCTYPE HTML>

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

<!-- <body style="height: 100vh; width: 100vw; overflow: hidden;">
        
            <form action="server.php" method="post">
                <h1>REGISTER</h1>
                <h3>Welcome.</h3>
                Display if login successful
                <?php
                // if(isset($_SESSION['registerstatus'])){
                //     echo $_SESSION['registerstatus'];
                //     unset($_SESSION['registerstatus']);
                // }
                ?>
                <p>Email</p>
                <input class="registertext" type="email" required name="email" maxlength="50" placeholder="Enter your email" class="input">
                <p>Name</p>
                <input class="registertext" type="text" required name="name" maxlength="50" placeholder="Enter your name" class="input">
                <p>Password</p>
                <input class="registertext" type="password" required name="password" maxlength="50" placeholder="Enter your password" class="input">
                <p>Confirm Password</p>
                <input class="registertext" type="password" required name="cpassword" maxlength="50" placeholder="Confirm your password" class="input">
                
                <br>
                <input type="submit" value="register" name="register" class="btn">
            </form>

            <p>Already have an account? Log-in <a href="login.php">here</a></p>
    </body> -->

<body style="height: 100vh; width: 100vw; overflow: hidden;">
    <div class="d-flex w-100 h-100">
        <img src="./images/loginBg.jpg" style="width: 35%; height: 100%; object-fit:cover;" />
        <div class="login-container">
            <h1 class="fw-bold mb-4">REGISTER</h1>
            <!-- Display if login successful -->
            <?php
            if (isset($_SESSION['registerstatus'])) {
                echo $_SESSION['registerstatus'];
                unset($_SESSION['registerstatus']);
            }
            ?>
            <form action="server.php" method="POST">

                <div class="mb-2">
                    <p class="mb-1">Email</p>
                    <input type="email" class="login-input" placeholder="Email Address" oninput="validateEmailFormat(this)" required name="email" />
                    <small class="text-success" id="emailHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Valid email format (Eg. abc@mail.com)</small>
                    <small class="text-danger" id="emailHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Invalid email format (Eg. abc@mail.com)</small>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <p class="mb-1">First Name</p>
                        <input type="text" class="login-input" placeholder="First Name" required name="firstName" id="firstName" oninput="validateName()" />
                    </div>
                    <div class="col-6">
                        <p class="mb-1">Last Name</p>
                        <input type="text" class="login-input" placeholder="Last Name" required name="lastName" id="lastName" oninput="validateName()" />
                    </div>
                    <small class="text-success" id="nameHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Name must not contain any special characters</small>
                    <small class="text-danger" id="nameHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Name must not contain any special characters</small>
                </div>

                <div class="mb-2">
                    <p class="mb-1">Password</p>
                    <input type="password" class="login-input" id="password" placeholder="Password" oninput="validatePassword()" required name="password" />
                    <small class="text-success" id="lengthHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Password must be at between 8 to 20 characters long</small>
                    <small class="text-danger" id="lengthHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Password must be at between 8 to 20 characters long</small>
                    <small class="text-success" id="numberHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Password must be contain at least 1 number</small>
                    <small class="text-danger" id="numberHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Password must be contain at least 1 number</small>
                    <small class="text-success" id="specialHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Password must not contain any special characters</small>
                    <small class="text-danger" id="specialHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Password must not contain any special characters</small>
                </div>

                <div class="mb-2">
                    <p class="mb-1">Confirm Password</p>
                    <input type="password" class="login-input" id="repeatPassword" placeholder="Confirm Password" oninput="validatePassword()" required name="cpassword" />
                    <small class="text-success" id="matchHelpT" style="display:none;"><i class="fa-solid fa-check"></i> Both password matches</small>
                    <small class="text-danger" id="matchHelpF" style="display:none;"><i class="fa-solid fa-xmark"></i> Both passwords do not match</small>
                </div>
                <div class="mb-2">
                    <p class="mb-1">Referral Code (Optional)</p>
                    <input type="text" class="login-input" placeholder="Referral Code" name="referrer" />
                </div>

                <button class="mt-3 mb-2 signinBtn rounded fw-semibold" style="width: 450px; height: 50px;" id="register" value="register" name="register" type="submit">Register</button>
                <p>Already have an account? <a href="login.php" style="color: black;">Sign In</a></p>
            </form>
        </div>
    </div>
</body>
<script src="js/register.js"></script>
    


</html>