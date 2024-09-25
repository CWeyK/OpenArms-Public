<?php
include "header.php";

//fetch purchse history
if (isset($_GET['searchFilter'])) {
    $searchFilter = $_GET['searchFilter'];
    $searchFilter = mysqli_real_escape_string($conn, $searchFilter);
    $purchasequery = "SELECT * FROM purchase WHERE userid='" . $_SESSION['userid'] . "' AND (purchaseid LIKE '%$searchFilter%' OR date LIKE '%$searchFilter%' OR items LIKE '%$searchFilter%' OR total LIKE '%$searchFilter%' OR shippingAddress LIKE '%$searchFilter%')";
} else {
    $purchasequery = "SELECT * FROM purchase WHERE userid='" . $_SESSION['userid'] . "'";
}

$purchaseresult = mysqli_query($conn, $purchasequery);
$purchases = mysqli_fetch_all($purchaseresult, MYSQLI_ASSOC);
//count number of rows
$count = mysqli_num_rows($purchaseresult);



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
                <h5 class="fw-bold mb-4">Order History</h5>
                <div class="input-group me-3" style="height: 30px; width: 250px;">
                    <!-- search -->
                    <form action="orderHistory.php" method="GET" class="d-flex">
                        <input type="text" name="searchFilter" class="form-control form-control-sm me-2" placeholder="Search..." style="height: fit-content;">
                        <?php if (isset($_GET['searchFilter'])) { ?>
                            <a href="orderHistory.php" class="btn btn-outline-secondary py-1">Clear</a>
                        <?php } ?>
                </div>

            </div>
            <?php if (isset($_GET['searchFilter'])) { ?>
                <p>Searching for "<?= $searchFilter ?>" (<?=$count?>) results found</p>
            <?php } ?>
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="background-color: #769fcd; color: white;">Order ID</th>
                        <th style="background-color: #769fcd; color: white;">Quantity</th>
                        <th style="background-color: #769fcd; color: white;">Price</th>
                        <th style="background-color: #769fcd; color: white;">Order Date</th>
                        <th style="background-color: #769fcd; color: white;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($purchases as $purchase) {
                        //count how many items
                        $totalQuantity = 0;
                        $totalPrice = 0;
                        $orderData = json_decode($purchase['items'], true);
                        foreach ($orderData as $item) {
                            $totalQuantity += (int)$item['quantity'];
                            $totalPrice += (int)$item['quantity'] * (float)$item['pricePP'];
                        }

                    ?>
                        <tr>
                            <!-- order ID (#infront) -->
                            <th scope="row">#<?= $purchase['purchaseid'] ?></th>
                            <!-- quantity -->
                            <td><?= $totalQuantity ?> Items</td>
                            <!-- total point cost -->
                            <td><?= $totalPrice ?> Points</td>
                            <!-- purchase date -->
                            <td><?= $purchase['date'] ?></td>
                            <!-- details button (orderDetails.php) -->
                            <td class="text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#detailsModal<?= $purchase['purchaseid'] ?>" class="btn btn-secondary">Details</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- details modal -->
    <?php
    foreach ($purchases as $purchase) {
        $totalQuantity = 0;
        $totalPrice = 0;
        $orderData = json_decode($purchase['items'], true);
        foreach ($orderData as $item) {
            $totalQuantity += (int)$item['quantity'];
            $totalPrice += (int)$item['quantity'] * (float)$item['pricePP'];
        }
    ?>
        <div class="modal fade" id="detailsModal<?= $purchase['purchaseid'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="d-flex justify-content-between p-3 pb-1">
                        <!-- order id, after # -->
                        <h5 class="fw-bold">Order #<?= $purchase['purchaseid'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body pt-0" style="font-size: 0.875rem;">
                        <!-- order date -->
                        <p>Date ordered: <?= $purchase['date'] ?></p>
                        <!-- total items quantity -> (2) -->
                        <h6>Items (<?= $totalQuantity ?>)</h6>
                        <hr>
                        <!-- loop start -->
                        <?php
                        foreach ($orderData as $item) {
                        ?>
                            <div class="row">
                                <div class="col-8 d-flex align-items-center">
                                    <div class="ms-2">
                                        <!-- item name -->
                                        <p class="fs-6 fw-semibold"><?= $item['productName'] ?></p>
                                        <!-- quantity -->
                                        <p class="mb-0">Quantity: <?= $item['quantity'] ?></p>
                                    </div>
                                </div>
                                <div class="col-4 text-end justify-content-center d-flex flex-column">
                                    <!-- total points of that items -->
                                    <p class="m-0"><?= $item['quantity'] ?> x <?= $item['pricePP'] ?> points</p>
                                </div>
                            </div>
                            <hr>
                            <!-- loop end -->
                        <?php } ?>


                        <div class="row">
                            <div class="col-6">
                                <p class="fw-bold">
                                    Total:
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <!-- Total points -->
                                <?= $totalPrice ?> Points
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

</html>