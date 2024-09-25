<?php include "header.php";
//obtain campaign information
$campaignid = $_GET["cid"];
$campaignquery = "SELECT * FROM campaign where campaignid=$campaignid";
$campaignresult = mysqli_query($conn, $campaignquery);
$campaign = mysqli_fetch_assoc($campaignresult);

//fetch organizer name
$organizerquery = "SELECT * FROM user where userid=" . $campaign['organizer'];
$organizerresult = mysqli_query($conn, $organizerquery);
$organizer = mysqli_fetch_assoc($organizerresult);

//fetch amount raised
$donationquery = "SELECT SUM(amount) as total FROM donation where campaignid=$campaignid";
$donationresult = mysqli_query($conn, $donationquery);
$donation = mysqli_fetch_assoc($donationresult);

//calculate percentage
$percentage = ($donation['total'] / $campaign['goal']) * 100;

//find how many donations
$donationcountquery = "SELECT COUNT(*) as total FROM donation where campaignid=$campaignid";
$donationcountresult = mysqli_query($conn, $donationcountquery);
$donationcount = mysqli_fetch_assoc($donationcountresult);
if (empty($donationcount['total'])) {
    $donationtext = "No Donations";
} elseif ($donationcount['total'] < 2) {
    $donationtext = $donationcount['total'] . " Donation";
} else {
    $donationtext = $donationcount['total'] . " Donations";
}

//set amount to 0 if no amount
if (empty($donation['total'])) {
    $donation['total'] = 0;
}

//if user has been deleted
if (empty($organizer['userid'])) {
    $organizer['firstName'] = "Deleted User";
    $organizer['lastName'] = "";
    $organizer['profilepicture'] = "profileicon.png";
}


//check if campaign is pending approval and user is not organizer
if ($campaign['approvalStatus'] == "Pending" && $campaign['organizer'] != $_SESSION['userid']) {
    include "accessDenied.php";
} else {
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
                <h5 class="fw-bold mb-4"><?= $campaign['campaignName'] ?></h5>
                <div class="row">
                    <?php
                    if (isset($_SESSION['donateStatus'])) {
                        echo $_SESSION['donateStatus'];
                        unset($_SESSION['donateStatus']);
                    }
                    if (isset($_SESSION['closeStatus'])) {
                        echo $_SESSION['closeStatus'];
                        unset($_SESSION['closeStatus']);
                    }
                    ?>
                    <!-- left -->
                    <div class="col-7">
                        <img src="./images/<?= $campaign['picture'] ?>" class="campaign-img" />

                        <div class="mt-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="./images/<?= $organizer['profilepicture'] ?>" style="width: 2.25rem; height: 2.25rem; object-fit:fill;" class="me-3 rounded-circle" />
                                <p class="m-0 text-muted" style="font-size: 0.875rem;"><?= $organizer['firstName'] ?> <?= $organizer['lastName'] ?> is organising this campaign.</p>
                            </div>
                            <!--Display close option if user is organizer-->
                            <?php 
                            if($campaign['approvalStatus'] == "Closed"){
                            ?>
                                <p class="m-0 text-muted" style="font-size: 0.875rem;">Closed</p>
                            <?php 
                            }else if (isset($_SESSION['userid'])){
                                if ($_SESSION['userid'] == $campaign['organizer']){ 
                            ?>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#closeModal">Close</button>
                            <?php 
                                } 
                            }?>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center mb-2" style="font-size: 0.875rem;">
                            <!-- category -->
                            <p class="fw-bold m-0 cardCategory"><?=$campaign['category']?></p>
                            <span style="font-size: 4px; color: #D9D9D9;" class="mx-2"><i class="fa-solid fa-circle"></i></span>
                            <!-- country -->
                            <p class="m-0"><?=$campaign['country']?></p>
                            <span style="font-size: 4px; color: #D9D9D9;" class="mx-2"><i class="fa-solid fa-circle"></i></span>
                            <!-- state -->
                            <p class="m-0"><?=$campaign['state']?></p>
                        </div>
                        <p class="m-0 lh-lg" style="font-size: 0.75rem;"><?= $campaign['campaignDetails'] ?></p>
                    </div>

                    <!-- right -->
                    <div class="col-5">
                        <div class="card py-3 px-5 campaignDetailCard" style="border-radius: 15px;">
                            <div class="d-flex mb-3">
                                <p class="card-text fw-bold fs-5 m-0 me-1">RM <?= $donation['total'] ?></p>
                                <p class="card-text m-0 pt-2" style="color: #767676">raised of RM <?= $campaign['goal'] ?> target</p>
                            </div>
                            <div class="progress mb-3" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: <?= $percentage ?>%"></div>
                            </div>
                            <p class="card-text" style="color: #767676"><?= $donationtext ?></p>
                            <div class="row justify-content-around mb-4">
                                <div class="col-6">
                                    <button class="campaignShareButton" id="shareButton">Share</button>
                                </div>
                                <div class="col-6">
                                    <?php //check if campaign is closed
                                    if ($campaign['approvalStatus'] != "Closed") {
                                        //check if user is logged in
                                        if (isset($_SESSION['userid'])) {
                                    ?>
                                           <a href="donateCampaign.php?cid=<?= $campaignid ?>">
                                                <button class="campaignDonateBtn">Donate</button>
                                            </a>
                                    <?php }else { ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#loginFirst">
                                                <button class="campaignDonateBtn">Donate</button>
                                             </a>
                                    <?php 
                                        }
                                    } else { ?>
                                        <button class="campaignDonateBtn" disabled>Closed</button>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <p class="card-text fs-6 fw-semibold m-0">Donations</p>
                                <select class="form-select form-select-sm" id="sort" name="sort" style="width: 155px; font-size: 12px;" aria-label="Small select example">
                                    <option value="recentDonation" selected>Recent Donations</option>
                                    <option value="topDonation">Top Donations</option>
                                </select>
                            </div>

                            <!--WARNING CHANGING THIS CLASS WILL BREAK THE AJAX, NOTIFY ME WHEN YOU DO-->
                            <div class="mt-2 row g-4">
                                <?php
                                //fetch donors
                                $donorquery = "SELECT * FROM donation where campaignid=$campaignid ORDER BY date DESC LIMIT 5";
                                $donorresult = mysqli_query($conn, $donorquery);
                                $donors = mysqli_fetch_all($donorresult, MYSQLI_ASSOC);
                                foreach ($donors as $donor) {
                                    //fetch donor details
                                    //if donor has been deleted
                                    if ($donor['donorid'] == 0) {
                                        $donordetails['firstName'] = "Deleted User";
                                        $donordetails['lastName'] = "";
                                        $donordetails['profilepicture'] = "profileicon.png";
                                    } else {
                                        $donordetailsquery = "SELECT * FROM user where userid=" . $donor['donorid'];
                                        $donordetailsresult = mysqli_query($conn, $donordetailsquery);
                                        $donordetails = mysqli_fetch_assoc($donordetailsresult);
                                    }
                                    //calculate how long ago
                                    $today = date("Y-m-d H:i:s");
                                    $date = date_create($donor['date']);
                                    $date = date_format($date, "Y-m-d H:i:s");
                                    $diff = date_diff(date_create($date), date_create($today));
                                    //if less than 1 day ago
                                    if ($diff->format("%a") < 1) {
                                        //if less than 1 hour ago
                                        if ($diff->format("%h") < 1) {
                                            //if less than 1 minute ago
                                            if ($diff->format("%i") < 1) {
                                                $diff = $diff->format("%s seconds");
                                            } else {
                                                $diff = $diff->format("%i minutes");
                                            }
                                        } else {
                                            $diff = $diff->format("%h hours");
                                        }
                                    } else {
                                        $diff = $diff->format("%a days");
                                    }
                                    //if anonymous
                                    if ($donor['anonymous'] == 1) {
                                        $donordetails['firstName'] = "Anonymous";
                                        $donordetails['lastName'] = "";
                                        $donordetails['profilepicture'] = "profileicon.png";
                                    }
                                ?>

                                    <div class="userDonations d-flex">
                                        <img src="./images/<?= $donordetails['profilepicture'] ?>" style="width: 2.25rem; height: 2.25rem; object-fit:fill;" class="me-3 rounded-circle" />
                                        <div>
                                            <p class="m-0" style="font-size: 0.75rem;"><?= $donordetails['firstName'] ?> <?= $donordetails['lastName'] ?></p>
                                            <div class="d-flex align-items-center">
                                                <p class="m-0 fw-bold me-2" style="font-size: 0.75rem; color: #4C4C4C;">RM<?= $donor['amount'] ?></p>
                                                <span style="font-size: 4px; color: #D9D9D9;" class="me-2"><i class="fa-solid fa-circle"></i></span>
                                                <p class="m-0" style="font-size: 0.75rem;"><?= $diff ?> ago</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="modal fade" id="closeModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold">Confirm Close Campaign?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to close <span class="fw-bold"><?=$campaign['campaignName']?></span>?
                        <p class="mt-3 mb-0" style="font-size: 0.75rem;"><span class="fw-bold">NOTE:</span> The campaign will not be able to receive donations after closed.</p>
                    </div>
                    <form action="server.php" method="POST">
                        <!--Hidden field for campaignid-->
                        <input type="hidden" name="campaignid" value="<?= $campaign['campaignid'] ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <!-- confirm close button -->
                            <button type="submit" name="closeCampaign" class="btn btn-danger">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
        var campaignid = <?= $campaignid ?>;
    </script>
    <script src="js/donorAjax.js"></script>
    <script>
        // Function to copy text to clipboard
        function copyToClipboard(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;

            // Ensure it's not displayed and append it to the document
            textArea.style.position = 'fixed';
            document.body.appendChild(textArea);

            // Select and copy the text
            textArea.select();
            document.execCommand('copy');

            // Cleanup
            document.body.removeChild(textArea);
        }

        // Event listener for the Share button
        document.getElementById('shareButton').addEventListener('click', function() {
            // Get the current URL
            const currentURL = window.location.href;

            // Copy the current URL to the clipboard
            copyToClipboard(currentURL);

            // Optionally, provide feedback to the user (e.g., show a message)
            alert('URL copied to clipboard!');
        });
    </script>
    </html>

<?php } ?>