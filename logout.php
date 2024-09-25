<?php 
include 'server.php';
if (isset($_COOKIE['email'])) {
    setcookie("email", "", time() - 3600, "/");
}

if (isset($_COOKIE['password'])) {
    setcookie("password", "", time() - 3600, "/");
}

session_destroy();

header('location: login.php');

?>