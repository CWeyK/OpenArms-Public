<?php
include "header.php";
//fetch product details
$productquery = "SELECT * FROM product";
$productresult = mysqli_query($conn, $productquery);
$products = mysqli_fetch_all($productresult, MYSQLI_ASSOC);

//find how many items in cart
$cartquery = "SELECT * FROM cart WHERE userid='" . $_SESSION['userid'] . "'";
$cartresult = mysqli_query($conn, $cartquery);
$cart = mysqli_fetch_all($cartresult, MYSQLI_ASSOC);
$cartCount = count($cart);


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
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold mb-4">Points Store</h5>
                <!--Display notification if success or failed-->
                <?php
                if (isset($_SESSION['addStatus'])) {
                    echo $_SESSION['addStatus'];
                    unset($_SESSION['addStatus']);
                }
                ?>
                <!-- shopping cart button -->
                <div class="position-relative">
                    <?php
                    //check if user is logged in
                    if (isset($_SESSION['userid'])) {
                    ?>
                        <button class="shopping-cart" onclick="redirectToCart()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>


                            <!-- cart indicator -->
                            <?php
                            //check if got item in cart
                            if ($cartCount > 0) {
                            ?>
                                <span class="rounded-circle cart-indicator"><?= $cartCount ?></span>
                            <?php } ?>

                        </button>
                    <?php } else { ?>
                        <button class="shopping-cart" data-bs-toggle="modal" data-bs-target="#loginFirst">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                        </button>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($products as $product) {
                ?>
                    <div class="col-3">
                        <div class="card p-0 my-3 mx-0" style="width: 18rem;">
                            <img src="./images/<?= $product['productPicture'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['productName'] ?></h5>
                                <p class="card-text card-text-height align-items-center d-flex"><?= $product['price'] ?> Points</p>
                                <div class="text-end">
                                    <button type="button" class="addCartBtn" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $product['productid'] ?>" data-product-name="<?= $product['productName'] ?>" data-product-price="<?= $product['price'] ?>" data-product-image="<?= $product['productPicture'] ?>" data-product-details="<?= $product['productDetails'] ?>" data-product-id="<?= $product['productid'] ?>">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>
    </div>
    <?php foreach ($products as $product) { ?>
        <!-- modal -->
        <div class="modal fade" id="exampleModal<?= $product['productid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <button type="button" class="btn-close ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body p-4">
                        <div class="row mb-4">
                            <div class="col-4">
                                <!-- product image -->
                                <img src="./images/<?= $product['productPicture'] ?>" width="250px" height="250px" style="object-fit: fill;" />
                            </div>
                            <div class="col ps-4">
                                <!-- product name -->
                                <h3 class="fw-bold"><?= $product['productName'] ?></h3>
                                <!-- points -->
                                <h6 class="fw-medium"></h6>
                                <!-- description -->
                                <p class="d-flex align-items-center" style="height: 100px;"><?= $product['productDetails'] ?></p>
                                <form action="server.php" method="POST">
                                    <div class="d-flex">
                                        <button type="button" class="quantityBtn" onclick="decrementQuantity('<?= $product['productid'] ?>')"><i class="fa-solid fa-minus"></i></button>
                                        <!-- quantity -->
                                        <input type="number" name="quantity" id="quantityInput<?= $product['productid'] ?>" value="1" class="productQuantityInput" readonly />
                                        <!--hidden input for product id-->
                                        <input type="hidden" name="productid" value="<?= $product['productid'] ?>" />
                                        <button type="button" class="quantityBtn" onclick="incrementQuantity('<?= $product['productid'] ?>')"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <div class="text-end">
                                        <!-- add to cart button -->
                                        <?php
                                        //check if user is logged in
                                        if (isset($_SESSION['userid'])) {
                                        ?>
                                            <button type="submit" name="addCart" class="addCartBtn">Add To Cart</button>
                                        <?php } else { ?>
                                            <button type="button" class="addCartBtn" data-bs-target="#loginFirst" data-bs-toggle="modal">Add To Cart</button>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <script src="./js/pointShop.js"></script>
</body>

</html>