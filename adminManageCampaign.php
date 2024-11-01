<?php
include "header.php";
//check user permission
if ($_SESSION['rank'] != 'Admin') {
    include "accessDenied.php";
} else {

    //get campaign details
    if (isset($_GET['searchFilter'])) {
        $searchFilter = $_GET['searchFilter'];
        $searchFilter = mysqli_real_escape_string($conn, $searchFilter);
        $campaignquery = "SELECT * FROM campaign WHERE campaignName LIKE '%$searchFilter%' OR campaignDetails LIKE '%$searchFilter%' OR category LIKE '%$searchFilter%' OR state LIKE '%$searchFilter%' OR country LIKE '%$searchFilter%' OR organizer IN (SELECT userid FROM user WHERE firstName LIKE '%$searchFilter%' OR lastName LIKE '%$searchFilter%') OR approvalStatus LIKE '%$searchFilter%'";
    } else {
        $campaignquery = "SELECT * FROM campaign";
    }
    $campaignresult = mysqli_query($conn, $campaignquery);
    $campaigns = mysqli_fetch_all($campaignresult, MYSQLI_ASSOC);
    $count = mysqli_num_rows($campaignresult);
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
        <div class="adminSidebar">
            <h5 class="fw-bold mb-0 pb-3 px-3" style="border-bottom: 1px solid #D9D9D9;">Dashboard</h5>
            <nav class="nav flex-column">
                <a class="sidebarNavItems" href="adminApproveCampaign.php">Approve Campaigns</a>
                <a class="sidebarNavItems active" href="adminManageCampaign.php">Manage Campaigns</a>
                <a class="sidebarNavItems" href="adminManageUser.php">Manage Users</a>
                <a class="sidebarNavItems" href="adminPointShop.php">Manage Point Shop</a>
            </nav>
        </div>
        <div class="mainContent admin" style="font-size: 0.75rem;">
            <form action="adminManageCampaign.php" method="GET">
                <div class="d-flex justify-content-between mb-4">
                    <h5 class="fw-bold">Manage Campaigns</h5>
                    <div class="input-group" style="height: 30px; width: 250px;">
                        <input type="text" name="searchFilter" class="form-control form-control-sm" placeholder="Search...">
                        <?php if (isset($_GET['searchFilter'])) { ?>
                            <a href="adminManageCampaign.php" class="btn btn-outline-secondary py-1">Clear</a>
                        <?php } ?>
                    </div>
                </div>
            </form>
            <?php if (isset($_GET['searchFilter'])) { ?>
                <p>Searching for "<?= $searchFilter ?>" (<?= $count ?>) results found</p>
            <?php } ?>
            <?php
            if (isset($_SESSION['closeStatus'])) {
                echo $_SESSION['closeStatus'];
                unset($_SESSION['closeStatus']);
            }

            foreach ($campaigns as $campaign) {
                //obtain organizer information
                $organizerid = $campaign['organizer'];
                $organizerquery = "SELECT * FROM user where userid=$organizerid";
                $organizerresult = mysqli_query($conn, $organizerquery);
                $organizer = mysqli_fetch_assoc($organizerresult);

                //obtain amount raised
                $raisedquery = "SELECT SUM(amount) AS total FROM donation WHERE campaignid=" . $campaign['campaignid'];
                $raisedresult = mysqli_query($conn, $raisedquery);
                $raised = mysqli_fetch_assoc($raisedresult);
                if (empty($raised['total'])) {
                    $raised['total'] = 0;
                }

                $percentage = ($raised['total'] / $campaign['goal']) * 100;
                $percentage = number_format($percentage, 2);


            ?>
                <!-- loop start -->
                <div class="card adminCampaignCard mb-3">
                    <div class="d-flex">
                        <!-- campaign image -->
                        <img src="./images/<?= $campaign['picture'] ?>" class="campaignImage" />
                        <div class="p-3 d-flex flex-column w-100">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center mb-1">
                                    <!-- category -->
                                    <p class="fw-bold m-0 cardCategory"><?= $campaign['category'] ?></p>
                                    <span style="font-size: 4px; color: #D9D9D9;" class="mx-2"><i class="fa-solid fa-circle"></i></span>
                                    <!-- country -->
                                    <p class="m-0"><?= $campaign['country'] ?></p>
                                </div>
                                <div class="d-flex">
                                    <?php if ($campaign['approvalStatus'] === 'Approved') { ?>
                                        <div class="alert alert-primary p-1 me-4 mb-0" role="alert"><?= $campaign['approvalStatus'] ?></div>
                                    <?php
                                    } else if ($campaign['approvalStatus'] === 'Pending') { ?>
                                        <div class="alert alert-warning p-1 me-4 mb-0" role="alert"><?= $campaign['approvalStatus'] ?></div>
                                    <?php } else if ($campaign['approvalStatus'] === 'Closed') { ?>
                                        <div class="alert alert-danger p-1 me-4 mb-0" role="alert"><?= $campaign['approvalStatus'] ?></div>
                                    <?php } ?>

                                    <div class="dropdown">
                                        <button class="text-decoration-none cardCategory bg-transparent fs-5" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- campaign details (modal) -->
                                            <li><button class="dropdown-item" style="color: #769fcd; background-color: transparent !important;" data-bs-toggle="modal" data-bs-target="#campaignModal<?= $campaign['campaignid'] ?>">Details</button></li>
                                            <!-- close campaign button (modal) -->
                                            <li><button class="dropdown-item text-danger" style="background-color: transparent !important;" data-bs-toggle="modal" data-bs-target="#closeCampaignModal<?= $campaign['campaignid'] ?>">Close Campaign</button></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <!-- title -->
                            <h5 class="card-title mb-1"><?= $campaign['campaignName'] ?></h5>
                            <!-- description, note: i make it overflow for now-->
                            <p class="mb-1" style="max-height: 2.25rem; overflow: auto;">
                                <?= $campaign['campaignDetails'] ?>
                            </p>
                            <!-- donations -->
                            <div class="w-50 mt-auto">
                                <div class="d-flex justify-content-between">
                                    <p class="m-0">Donation</p>
                                    <p class="m-0"><?= $percentage ?>%</p>
                                </div>
                                <div class="progress" role="progressbar" style="height: 5px !important;">
                                    <!-- set the width by percentage -->
                                    <div class="progress-bar" style="width: <?= $percentage ?>%;"></div>
                                </div>
                                <div class="mb-1 d-flex justify-content-between">
                                    <p class="m-0">Raised: RM <?= $raised['total'] ?></p>
                                    <p class="m-0">Goal: RM <?= $campaign['goal'] ?></p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <!-- user image -->
                                    <img src="./images/<?= $organizer['profilepicture'] ?>" class="rounded-circle me-2" style="height:1.875rem; width:1.875rem" />
                                    <!-- Who is organising -->
                                    <p class="m-0 fw-bold"><?= $organizer['firstName'] ?> <?= $organizer['lastName'] ?> is organising this campaign</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- loop end -->
            <?php } ?>

        </div>

        <?php
        foreach ($campaigns as $campaign) {
            //obtain organizer information
            $organizerid = $campaign['organizer'];
            $organizerquery = "SELECT * FROM user where userid=$organizerid";
            $organizerresult = mysqli_query($conn, $organizerquery);
            $organizer = mysqli_fetch_assoc($organizerresult);

            //obtain amount raised
            $raisedquery = "SELECT SUM(amount) AS total FROM donation WHERE campaignid=" . $campaign['campaignid'];
            $raisedresult = mysqli_query($conn, $raisedquery);
            $raised = mysqli_fetch_assoc($raisedresult);
            if (empty($raised['total'])) {
                $raised['total'] = 0;
            }

            $percentage = ($raised['total'] / $campaign['goal']) * 100;


        ?>
            <!-- modal -->
            <!-- campaign details modal -->
            <div class="modal fade modal-lg" id="campaignModal<?= $campaign['campaignid'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold">Campaign Details</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="font-size: 0.875rem;">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Campaign Name</label>
                                    <!-- Campaign Name -->
                                    <input type="text" class="form-control form-control-sm" placeholder="Campaign Name" value="<?= $campaign['campaignName'] ?>" readonly>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Organizer</label>
                                    <!-- Organizer -->
                                    <input type="text" class="form-control form-control-sm" placeholder="Organizer" value="<?= $organizer['firstName'] ?> <?= $organizer['lastName'] ?>" readonly>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <!-- Category -->
                                    <input type="text" class="form-control form-control-sm" placeholder="Category" value="<?= $campaign['category'] ?>" readonly>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Goal</label>
                                    <!-- Goal -->
                                    <input type="number" class="form-control form-control-sm" placeholder="Goal" value="<?= $campaign['goal'] ?>" readonly>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <!-- Description -->
                                    <textarea class="form-control" style="font-size: 0.875rem; resize: none;" rows="4" readonly> <?= $campaign['campaignDetails'] ?> </textarea>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <!-- Country -->
                                    <input type="text" class="form-control form-control-sm" placeholder="Country" value="<?= $campaign['country'] ?>" readonly>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">State</label>
                                    <!-- State -->
                                    <input type="text" class="form-control form-control-sm" placeholder="State" value="<?= $campaign['state'] ?>" readonly>
                                </div>
                                <div class="col-12 my-3">
                                    <!-- donation -->
                                    <div class="d-flex justify-content-between">
                                        <p class="m-0">Donation</p>
                                        <p class="m-0"><?= $percentage ?>%</p>
                                    </div>
                                    <div class="progress" role="progressbar" style="height: 5px !important;">
                                        <!-- set the width by percentage -->
                                        <div class="progress-bar" style="width: <?= $percentage ?>%;"></div>
                                    </div>
                                    <div class="mb-1 d-flex justify-content-between">
                                        <p class="m-0">Raised: RM <?= $raised['total'] ?></p>
                                        <p class="m-0">Goal: RM <?= $campaign['goal'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php
        foreach ($campaigns as $campaign) {
        ?>
            <!-- close campaign modal -->
            <div class="modal fade" id="closeCampaignModal<?= $campaign['campaignid'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold">Confirm Close Campaign?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- change "Campaign" to Campaign's name" -->
                            Are you sure you want to close <span class="fw-bold"><?= $campaign['campaignName'] ?></span>?
                            <p class="mt-3 mb-0" style="font-size: 0.75rem;"><span class="fw-bold">NOTE:</span> The campaign will not be able to receive donations after closed.</p>
                        </div>
                        <form action="server.php" method="POST">
                            <!--Hidden field for campaignid-->
                            <input type="hidden" name="campaignid" value="<?= $campaign['campaignid'] ?>">
                            <input type="hidden" name="campaignName" value="<?= $campaign['campaignName'] ?>">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <!-- confirm close button -->
                                <button type="submit" name="closeCampaign" class="btn btn-danger">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>

    </body>

    </html>
<?php } ?>