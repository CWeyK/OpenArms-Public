<?php
include "header.php";
//check user permission
if($_SESSION['rank']!='Admin'){
    include "accessDenied.php";
 }else{

//fetch product details
if(isset($_GET['searchFilter'])){
    $searchFilter = $_GET['searchFilter'];
    $searchFilter = mysqli_real_escape_string($conn, $searchFilter);
    $productquery = "SELECT * FROM product WHERE productid LIKE '%$searchFilter%' OR productName LIKE '%$searchFilter%' OR productDetails LIKE '%$searchFilter%' OR price LIKE '%$searchFilter%'";
}else{
    $productquery = "SELECT * FROM product";
}
$productresult = mysqli_query($conn, $productquery);
$products = mysqli_fetch_all($productresult, MYSQLI_ASSOC);
$count=mysqli_num_rows($productresult);
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
    <script src="js/productPicture.js"></script>
</head>

<body>

    <div class="adminSidebar">
        <h5 class="fw-bold mb-0 pb-3 px-3" style="border-bottom: 1px solid #D9D9D9;">Dashboard</h5>
        <nav class="nav flex-column">
            <a class="sidebarNavItems" href="adminApproveCampaign.php">Approve Campaigns</a>
            <a class="sidebarNavItems" href="adminManageCampaign.php">Manage Campaigns</a>
            <a class="sidebarNavItems" href="adminManageUser.php">Manage Users</a>
            <a class="sidebarNavItems active" href="adminPointShop.php">Manage Point Shop</a>
        </nav>
    </div>
    <div class="mainContent admin" style="font-size: 0.75rem;">
        <div class="d-flex justify-content-between mb-4">
            <h5 class="fw-bold">Manage Point Shop</h5>
            <div class="d-flex">
                <button class="addProductBtn me-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus me-2"></i>Add</button>
                <div class="input-group" style="height: 30px; width: 250px;">
                    <form action="adminPointShop.php" method="GET">
                    <input type="text" name="searchFilter" class="form-control form-control-sm" placeholder="Search...">
                    <?php if (isset($_GET['searchFilter'])) { ?>
                            <a href="adminPointShop.php" class="btn btn-outline-secondary py-1">Clear</a>
                    <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <?php if (isset($_GET['searchFilter'])) { ?>
                <p>Searching for "<?= $searchFilter?>" (<?=$count?>) results found</p>
            <?php } ?>
        <!--Display notification if success or failed-->
        <?php
        if (isset($_SESSION['editProductStatus'])) {
            echo $_SESSION['editProductStatus'];
            unset($_SESSION['editProductStatus']);
        }
        if (isset($_SESSION['deleteProductStatus'])) {
            echo $_SESSION['deleteProductStatus'];
            unset($_SESSION['deleteProductStatus']);
        }
        if (isset($_SESSION['addProductStatus'])) {
            echo $_SESSION['addProductStatus'];
            unset($_SESSION['addProductStatus']);
        }
        ?>
        <table class="table adminPointShopTable align-middle" style="font-size: 0.875rem;">
            <thead class="fs-6">
                <tr>
                    <th scope="col">
                        <!-- sort button -->
                        <!-- when a to z (<i class="fa-solid fa-arrow-down-a-z"></i>) -->
                        <!-- when z to a (<i class="fa-solid fa-arrow-up-a-z"></i>) -->
                        <button class="shopping-cart"><i class="fa-solid fa-arrow-down-a-z"></i></button>
                        Product
                    </th>
                    <th scope="col" style="width: 300px !important;">Description</th>
                    <th scope="col" class="text-center">Price (Points)</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop start -->
                <?php
                foreach ($products as $product) {
                ?>
                    <tr>
                        <th scope="row">
                            <!-- image -->
                            <img src="./images/<?= $product['productPicture'] ?>" style="width: 150px; height: 150px" />
                            <!-- name -->
                            <span class="fw-bold ms-3 fs-6"><?= $product['productName'] ?></span>
                        </th>
                        <!-- description -->
                        <td><?= $product['productDetails'] ?></td>
                        <!-- price (points) -->
                        <td class="text-center"><?= $product['price'] ?></td>
                        <td class="text-center">
                            <!-- edit button (modal) -->
                            <button class="btn btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $product['productid'] ?>">Edit</button>
                            <!-- delete button (modal) -->
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $product['productid'] ?>">Delete</button>
                        </td>
                    </tr>
                    <!-- loop end -->
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- modal -->
    <!-- add modal -->
    <div class="modal fade modal-lg" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold">Add product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- form -->
                <form action="server.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body" style="font-size: 0.875rem;">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <!-- product name -->
                                    <input type="text" name="productName" class="form-control form-control-sm" placeholder="Product Name" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Price (Points)</label>
                                    <!-- price (points) -->
                                    <input type="number" name="price" class="form-control form-control-sm" placeholder="Price" required>
                                </div>
                            </div>
                            <div class="col-6"> 
                                <label class="form-label">Description</label>
                                <!-- description -->
                                <textarea class="form-control" name="productDetails" style="font-size: 0.875rem; resize: none;" rows="4" required></textarea>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="profilePic">Choose Picture:</label>
                                    <!-- image -->
                                    <input type="file" class="form-control-file mt-1" id="productPic" name="productPicture" required>
                                    <p id="fileInfo">Allowed file types: JPEG, JPG, PNG.<br>Maximum file size: 2 MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <!-- save button (submit) -->
                        <button type="submit" class="btn btn-success" name="addProduct" id="saveButton">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    foreach ($products as $product) {
    ?>
        <!-- edit modal -->
        <div class="modal fade modal-lg" id="editModal<?= $product['productid'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold">Edit product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- form -->
                    <form action="server.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body" style="font-size: 0.875rem;">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <!-- product name -->
                                        <input type="text" name="productName" class="form-control form-control-sm" value="<?= $product['productName'] ?>" placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Price (Points)</label>
                                        <!-- price (points) -->
                                        <input type="number" name="price" class="form-control form-control-sm" value="<?= $product['price'] ?>" placeholder="Price">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Description</label>
                                    <!-- description -->
                                    <textarea class="form-control" name="productDetails" style="font-size: 0.875rem; resize: none;" rows="4"><?= $product['productDetails'] ?></textarea>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="profilePic">Choose Picture:</label>
                                        <!-- image -->
                                        <input type="file" class="form-control-file mt-1" id="productPic<?= $product['productid'] ?>" name="productPicture">
                                        <p id="fileInfo<?= $product['productid'] ?>">Allowed file types: JPEG, JPG, PNG.<br>Maximum file size: 2 MB.</p>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- hidden input for product id -->
                        <input type="hidden" name="productid" value="<?= $product['productid'] ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <!-- save button (submit) -->
                            <button type="submit" class="btn btn-success" name="editProduct" id="saveButton<?= $product['productid'] ?>">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- delete modal -->
        <div class="modal fade" id="deleteModal<?= $product['productid'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- product name -->
                        <h1 class="modal-title fs-5 fw-bold">Confirm Delete <?=$product['productName']?>?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <!-- confirm delete button -->
                        <form action="server.php" method="POST">
                            <!-- hidden input for product id -->
                            <input type="hidden" name="productid" value="<?= $product['productid'] ?>">
                            <input type="submit" value="Delete" name="deleteProduct" class="btn btn-danger">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var fileInput<?= $product['productid'] ?> = document.getElementById('productPic<?= $product['productid'] ?>');

                console.log(fileInput<?= $product['productid'] ?>);
                var fileInfo<?= $product['productid'] ?> = document.getElementById('fileInfo<?= $product['productid'] ?>');
                var saveChangesButton<?= $product['productid'] ?> = document.getElementById('saveButton<?= $product['productid'] ?>');

                fileInput<?= $product['productid'] ?>.addEventListener('change', function() {
                    var file = fileInput<?= $product['productid'] ?>.files[0];

                    if (!file.type.startsWith('image/')) {
                        fileInfo<?= $product['productid'] ?>.textContent = 'Error: Only JPEG, JPG, and PNG files are allowed.';
                        fileInput<?= $product['productid'] ?>.value = ''; // Clear the file input
                        disableSaveButton<?= $product['productid'] ?>();
                        return;
                    }

                    // Check file size
                    var maxSize = 1 * 1024 * 1024; // 1 MB
                    if (file.size > maxSize) {
                        fileInfo.textContent = 'Error: File size exceeds the maximum limit (1 MB).';
                        fileInput.value = ''; // Clear the file input
                        disableSaveButton<?= $product['productid'] ?>();
                        return;
                    }


                    fileInfo<?= $product['productid'] ?>.textContent = 'File selected: ' + file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
                    enableSaveButton<?= $product['productid'] ?>();
                });

                // Function to disable the "Save Changes" button
                function disableSaveButton<?= $product['productid'] ?>() {
                    saveChangesButton<?= $product['productid'] ?>.disabled = true;
                    saveChangesButton<?= $product['productid'] ?>.style.backgroundColor = 'red'; // Change the button color to red
                }

                // Function to enable the "Save Changes" button
                function enableSaveButton<?= $product['productid'] ?>() {
                    saveChangesButton<?= $product['productid'] ?>.disabled = false;
                    saveChangesButton<?= $product['productid'] ?>.style.backgroundColor = ''; // Reset the button color
                }

            });
        </script>
    <?php } ?>

</body>


</html>
<?php }?>