<?php require_once 'server.php';
//fetch most recent 4 campaigns details
$campaignquery = "SELECT * FROM campaign where approvalStatus='Approved' ORDER BY dateRequested DESC LIMIT 4";
$campaignresult = mysqli_query($conn, $campaignquery);
$campaigns = mysqli_fetch_all($campaignresult, MYSQLI_ASSOC);


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
    <?php include 'header.php'; ?>
    <!-- Top Content-->
    <div class="position-relative">
        <img src="./images/homeBg.png" style="width: 100%; height: 85%; object-fit: cover" />
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <p class="fs-5 m-0 fw-semibold">
                Unite, Serve, Strengthen Together
            </p>
            <p class="fs-2 fw-semibold">
                Serving Humanity, Saving Lives <br />OpenArms
            </p>
            <p class="fs-6">
                Compassion drives us. Together, we serve, uplift, and
                strengthen communities. <br />Join us in making a difference, one
                act of kindness at a time.
            </p>
            <a href="discoverJ.php"><button class="signinBtn" style="width: 200px">Donate Now</button></a>
        </div>
    </div>

    <div class="homeContent">

        <h3 class="homeTitle fw-semibold">Find The Popular Cause<br />And Donate Them</h1>
            <div class="d-flex">
                <p class="fw-bold">Latest Campaigns</p>
                <hr style="width: 80px" class="ms-2">
            </div>

            <div class="row my-3 justify-content-between">

                <?php
                //display campaigns
                foreach ($campaigns as $campaign) {
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
                    <div class="col-3">

                        <div class="card p-0 my-3" style="width: 18rem;">
                            <img src="images/<?= $campaign['picture'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text cardCategory fw-semibold fs-6 mb-0"><?= $campaign['category'] ?></p>
                                <!-- country -->
                                <p class="fw-bold" style="font-size: 0.875rem;"><?= $campaign['country'] ?></p>
                                <h5 class="card-title" style="min-height: 48px;"><?= $campaign['campaignName'] ?></h5>
                                <p class="card-text card-text-height"><?= $campaign['campaignDetails'] ?></p>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text m-0">Donation</p>
                                    <p class="card-text m-0"><?= $percentage ?>%</p>
                                </div>
                                <div class="progress" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: <?= $percentage ?>%"></div>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <p class="card-text" style="font-size: 0.75rem;">Raised: RM<?= $raised['total'] ?></p>
                                    <p class="card-text" style="font-size: 0.75rem;">Goal: RM<?= $campaign['goal'] ?></p>
                                </div>
                                <div class="mb-2">
                                    <a href="campaignDetails.php?cid=<?= $campaign['campaignid'] ?>" class="donateBtn">Donate Now</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end here -->
                <?php } ?>

            </div>
    </div>
    <script>
        $(document).ready(function() {
            $(window).on("scroll", function() {
                if ($(window).scrollTop() > 0) {
                    $("nav").addClass("nav-scrolled");
                    $("nav").removeClass("homeNavbar");
                } else {
                    $("nav").addClass("homeNavbar");
                    $("nav").removeClass("nav-scrolled");
                }
            });
        });
    </script>
</body>


</html>