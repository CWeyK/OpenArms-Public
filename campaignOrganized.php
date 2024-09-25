<?php
include "header.php";

//fetch campaigns organized
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $campaignquery = "SELECT * FROM campaign WHERE organizer='" . $_SESSION['userid'] . "' AND (campaignid LIKE '%$search%' OR campaignName LIKE '%$search%' OR campaignDetails LIKE '%$search%' OR country LIKE '%$search%' OR category LIKE '%$search%' or state LIKE '%$search%')";
} else {
    $campaignquery = "SELECT * FROM campaign WHERE organizer='" . $_SESSION['userid'] . "'";
}

$campaignresult = mysqli_query($conn, $campaignquery);
$campaigns = mysqli_fetch_all($campaignresult, MYSQLI_ASSOC);

$count=mysqli_num_rows($campaignresult);
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
                <h5 class="fw-bold mb-4">My Campaigns</h5>
                <div class="d-flex">
                    <a href="campaignOrganized.php" class="buttonGroup buttonGroup1 active">Organized</a>
                    <a href="campaignDonated.php" class="buttonGroup buttonGroup2">Donated</a>
                    <!-- search -->
                    <form action="campaignOrganized.php" method="GET">
                    <div class="input-group mx-3" style="height: 30px; width: 250px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search...">
                        <?php if (isset($_GET['search'])) { ?>
                            <a href="campaignOrganized.php" class="btn btn-outline-secondary py-1">Clear</a>
                        <?php } ?>
                    </div>
                    </form>
                </div>
            </div>
            <?php if (isset($_GET['search'])) { ?>
                <p>Searching for "<?= $search ?>" (<?=$count?>) results found</p>
            <?php } ?>
            <div class="row">
                <!-- loop my campaign start -->
                <?php 
                    foreach($campaigns as $campaign){
                    $raisedquery = "SELECT SUM(amount) AS total FROM donation WHERE campaignid=" . $campaign['campaignid'];
                        $raisedresult = mysqli_query($conn, $raisedquery);
                        $raised = mysqli_fetch_assoc($raisedresult);
                        if (empty($raised['total'])) {
                            $raised['total'] = 0;
                        }

                        $percentage = ($raised['total'] / $campaign['goal']) * 100;
                        $percentage = number_format($percentage, 2);
                        ?>
                <div class="col-3">

                    <div class="card p-0 my-3" style="width: 18rem;">
                        <img src="images/<?=$campaign['picture']?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- category -->
                                <p class="card-text cardCategory fw-semibold fs-6 mb-0"><?=$campaign['category']?></p>
                                <p class="m-0 fw-bold" style="font-size: 0.75rem; color: #767676;"><?=$campaign['approvalStatus']?></p> <!-- Donated/Organised or Started or whatever -->
                            </div>
                            <!-- country -->
                            <p class="fw-bold" style="font-size: 0.875rem;"><?=$campaign['country']?></p>
                            <!-- title -->
                            <h5 class="card-title" style="min-height: 48px;"><?=$campaign['campaignName']?></h5>
                            <!-- description -->
                            <p class="card-text card-text-height"><?=$campaign['campaignDetails']?></p>
                            <div class="d-flex justify-content-between">
                                <p class="card-text m-0">Donation</p>
                                <!-- donation percentage -->
                                <p class="card-text m-0"><?=$percentage?>%</p>
                            </div>
                            <div class="progress" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: <?=$percentage?>%"></div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <p class="card-text" style="font-size: 0.75rem;">Raised: RM<?=$raised['total']?></p>
                                <p class="card-text" style="font-size: 0.75rem;">Goal: RM<?=$campaign['goal']?></p>
                            </div>
                            <div class="mb-2">
                                <a href="campaignDetails.php?cid=<?= $campaign['campaignid'] ?>" class="donateBtn">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end loop -->
                <?php } ?>
            </div>

        </div>
    </div>
</body>

</html>