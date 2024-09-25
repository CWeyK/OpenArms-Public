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
            <h5 class="fw-bold mb-4">Cart</h5>
            <?php 
                if(isset($_SESSION['cartStatus'])){
                    echo $_SESSION['cartStatus'];
                    unset($_SESSION['cartStatus']);
                }
            ?>
            <div class="d-flex justify-content-between">
                <a href="pointShop.php" class="backBtn"><i class="fa-solid fa-arrow-left me-2"></i>Back to store</a>
                <!-- clear cart button -->
                <form action="server.php " method="POST">
                    <button class="btn btn-danger me-2" type="submit" name="clearCart">Clear All</button>
                </form>
            </div>
            <div class="row mt-3">
                <div class="col-8">
                    <?php

                    if (!isset($cartCount)) {
                        echo "Your cart is empty.";
                        $cartCount = 0;
                        $cartTotal = 0;
                    }
                    foreach ($cart as $cartItem) {
                        //get product details
                        $productquery = "SELECT * FROM product WHERE productid='" . $cartItem['productid'] . "'";
                        $productresult = mysqli_query($conn, $productquery);
                        $product = mysqli_fetch_assoc($productresult);

                    ?>
                        <!-- loops start -->
                        <div class="card p-3 mb-3">
                            <div class="row">
                                <div class="col-4">
                                    <!-- product image -->
                                    <img src="./images/<?= $product['productPicture'] ?>" width="220px" height="220px" style="object-fit: fill;">
                                </div>
                                <div class="col ps-0">
                                    <div class="d-flex justify-content-between">
                                        <!-- name -->
                                        <h4 class="fw-bold"><?= $product['productName'] ?></h4>
                                        <!-- remove item -->
                                        <form action="server.php" method="POST">
                                            <input type="hidden" name="productid" value="<?= $cartItem['productid'] ?>">
                                            <button class="btn btn-outline-danger rounded-circle p-2" type="submit" name="removeCart" ><i class="fa-solid fa-xmark" style="width: 16px; height: 16px;"></i></button>
                                        </form>
                                    </div>
                                    <!-- point -->
                                    <p class="fw-medium" style="margin-bottom: 80px;"><?= $product['price'] ?> Points</p>
                                    <div class="d-flex">
                                        <button type="button" class="quantityBtn" onclick="decrementQuantity('<?= $cartItem['cartid'] ?>')"><i class="fa-solid fa-minus"></i></button>
                                        <!-- quantity -->
                                        <input type="number" name="quantity" id="quantityInput<?= $cartItem['cartid'] ?>" value="<?= $cartItem['quantity'] ?>" class="productQuantityInput" data-productid="<?= $cartItem['productid'] ?>" data-cartid="<?= $cartItem['cartid'] ?>" readonly />

                                        <button type="button" class="quantityBtn" onclick="incrementQuantity('<?= $cartItem['cartid'] ?>')"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end loop -->
                    <?php } ?>


                </div>

                <div class="col-4">
                    <div class="card p-3" id="summaryFrame">
                        <h5 class="fw-bold mb-0">Summary</h5>
                        <hr>
                        <div class="row fw-semibold" style="font-size: 0.875rem;">
                            <div class="col-4">
                                <p>Quantity:</p>
                            </div>
                            <div class="col-8">
                                <!-- total quantity -->
                                <p id="totalQuantity"><?= $cartCount ?> <?php if ($cartCount == 1) {
                                                                            echo "Item";
                                                                        } else {
                                                                            echo "Items";
                                                                        } ?></p>
                            </div>

                            <div class="col-4">
                                <p>Total:</p>
                            </div>
                            <div class="col-8">
                                <!-- total points -->
                                <p id="totalPoints"><?= $cartTotal ?> Points</p>
                            </div>
                        </div>

                        <div class="text-end">
                            <!-- checkout button -->
                            <?php if ($cartCount > 0) { ?>
                                <button class="addCartBtn" type="submit" onclick=redirectToCheckOut()>Checkout</button>
                            <?php } else { ?>
                                <button class="addCartBtn" type="submit" onclick=unableToCheckOut()>Checkout</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/cart.js"></script>
</body>

</html>