<?php
include "header.php";

//obtain campaign information
$campaignid = $_GET["cid"];
$campaignquery = "SELECT * FROM campaign where campaignid=$campaignid";
$campaignresult = mysqli_query($conn, $campaignquery);
$campaign = mysqli_fetch_assoc($campaignresult);
?>

<html>

<head>
    <script>
        // Set the timeout (e.g., 15 minutes)
        const timeoutDuration = 15 * 60 * 1000; // 15 minutes in milliseconds
        let timeoutId;
        timeOut = false;

        function resetTimer() {
            clearTimeout(timeoutId);

            if (timeOut == true) {
                return;

            } else {

                timeoutId = setTimeout(function() {

                    const modalBackdrop = document.createElement('div');
                    modalBackdrop.classList.add('modal-backdrop', 'fade', 'show');
                    document.body.appendChild(modalBackdrop);
                    document.getElementById('timeoutModal').classList.add('show');
                    document.getElementById('timeoutModal').style.display = "block";
                    timeOut = true;
                }, timeoutDuration);
            }
        }


        // Reset the timer on user interaction

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);

        // Start the timer when the page loads
        resetTimer();
    </script>
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
        <div class="card mx-auto px-5 py-4 mt-4" style="border-radius: 15px; width: 40%; height: calc(100vh - 144px);">
            <!-- form -->
            <form class="h-100 d-flex flex-column" action="server.php" method="POST">
                <!-- back button -->
                <a href="campaignDetails.php?cid=<?= $campaignid ?>" class="text-decoration-none fw-medium mb-2" style="color: black; max-width:fit-content;">
                    <i class="fa-solid fa-chevron-left me-2"></i>Back
                </a>
                <div class="d-flex align-items-center mb-4">
                    <!-- campaign image -->
                    <img src="./images/<?= $campaign["picture"] ?>" class="rounded" style="width: 130px; height: 95px; object-fit:cover;" />
                    <!-- campaign title -->
                    <p class="m-0 ps-4">You're supporting <span class="fw-bold"><?= $campaign["campaignName"] ?></span></p>
                </div>
                <p class="fw-bold mb-1" style="font-size: 0.875rem;">Enter Your Donation</p>
                <div class="input-group mb-1 donationAmountInput">
                    <span class="input-group-text">RM</span>
                    <!-- input donation amount -->
                    <input type="number" class="form-control text-end" id="donationAmount" name="amount" required>
                </div>
                <div class="form-check" style="font-size: 0.75rem;">
                    <!-- input checkbox for anonymous -->
                    <input class="form-check-input" type="checkbox" name="anonymous" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Don’t display my name publicy on the campaign
                    </label>
                </div>

                <div class="mt-auto">
                    <!-- the amount will be updated automatically based on user input -->
                    <p class="mb-2 fw-bold" style="font-size: 0.75rem;">Your Donation</p>
                    <div class="d-flex justify-content-between" style="font-size: 0.75rem;">
                        <p class="m-0">Donation</p>
                        <p class="m-0" id="donationAmountDisplay">RM0.00</p>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex justify-content-between" style="font-size: 0.75rem;">
                        <p class="m-0">Total</p>
                        <p class="m-0" id="donationTotalAmount">RM0.00</p>
                    </div>
                    <!--Hidden input field for campaignid-->
                    <input type="hidden" name="campaignid" value="<?= $campaignid ?>">
                    <button type="submit" name='donate' class="signinBtn rounded w-100 mt-4 mb-1 fw-bold">Pay</button>
                    <!-- To be develop in the future -->
                    <p class="m-0 fw-medium" style="font-size: 0.75rem;">
                        By continuing, you agree with <a href="#" style="color: black;" data-bs-toggle="modal" data-bs-target="#termsModal">OpenArms terms</a> and <a href="#" style="color: black;" data-bs-toggle="modal" data-bs-target="#privacyModal">privacy note</a>.
                        <br>Learn more about <a href="#" style="color: black;" data-bs-toggle="modal" data-bs-target="#pricingModal">pricing and fees</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script src="./js/donateCampaign.js"></script>

    <div class="modal fade" id="timeoutModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-items-center">
                    <p>Your payment session has timed out. Please start over.</p>
                    <a class="signInBtn" href="campaignDetails.php?cid=<?= $campaignid ?>" style="width:fit-content">Return to campaign</a>
                </div>
            </div>
        </div>
    </div>

    <?php include "termsModal.php"; ?>
</body>

</html>