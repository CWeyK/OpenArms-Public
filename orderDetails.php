<?php
include "header.php";
//obtain cart details
$cartquery = "SELECT * FROM cart WHERE userid = " . $_SESSION['userid'] . ";";
$cartresult = mysqli_query($conn, $cartquery);
$cart = mysqli_fetch_all($cartresult, MYSQLI_ASSOC);

//obtain total number of items in cart
$countquery = "SELECT SUM(quantity) AS count FROM cart WHERE userid = " . $_SESSION['userid'] . ";";
$countresult = mysqli_query($conn, $countquery);
$count = mysqli_fetch_assoc($countresult);
$cartCount = $count['count'];

//obtain total points
$totalquery = "SELECT SUM(quantity*price) AS total FROM cart INNER JOIN product ON cart.productid=product.productid WHERE userid = " . $_SESSION['userid'] . ";";
$totalresult = mysqli_query($conn, $totalquery);
$total = mysqli_fetch_assoc($totalresult);
$cartTotal = $total['total'];


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
    <div class="mainContent">
        <div class="marginContent mt-4">
            <a href="orderHistory.php" class="backBtn"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
            <h5 class="fw-bold my-4">Your Order #12345</h5>
            <div class="row">
                <div class="col-8">
                    <div class="card p-3 mb-3">
                        <!-- loop start -->
                        <div class="d-flex">
                            <!-- image -->
                            <img src="./images/tshirt.png" width="100px" height="100px" style="object-fit: fill;" />
                            <div class="d-flex justify-content-between w-100 ms-3">
                                <div class="d-flex flex-column my-auto">
                                    <!-- name -->
                                    <h4 class="fw-bold">T-shirt</h4>
                                    <!-- quantity -->
                                    <p class="fw-medium m-0">Quantity: 1</p>
                                </div>
                                <div class="my-auto">
                                    <!-- point -->
                                    <p class="fw-semibold m-0">750 Points</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- loop end -->
                        <!-- test -->
                        <div class="d-flex">
                            <img src="./images/tshirt.png" width="100px" height="100px" style="object-fit: fill;" />
                            <div class="d-flex justify-content-between w-100 ms-3">
                                <div class="d-flex flex-column my-auto">
                                    <h4 class="fw-bold">T-shirt</h4>
                                    <p class="fw-medium m-0">Quantity: 1</p>
                                </div>
                                <div class="my-auto">
                                    <p class="fw-semibold m-0">750 Points</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- test end -->
                    </div>
                </div>

                <div class="col-4">
                    <div class="card p-3">
                        <h4 class="fw-bold mb-0">Summary</h4>
                        <hr>
                        <div class="row fw-semibold" style="font-size: 0.875rem;">
                            <div class="col-4">
                                <p>Quantity:</p>
                            </div>
                            <div class="col-8">
                                <p>2 Items</p>
                            </div>
                            <div class="col-4">
                                <p>Total:</p>
                            </div>
                            <div class="col-8">
                                <p>1500 Points</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>