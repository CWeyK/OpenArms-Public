<?php
include "header.php";
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
        <div class="card mx-auto px-5 py-4 mt-4 startCampaignCard" style="border-radius: 15px; width: 40%; height: calc(100vh - 144px);">
            <!-- change form destination, note: everything is under one form -->
            <form action="server.php" method="POST" enctype="multipart/form-data">
                <!-- First Page  -->
                <div class="campaignFirstPage">
                    <h6 class="fw-bold">Start a Campaign</h6>
                    <p class="mb-4" style="color: #AAAAAA; font-size: 0.75rem">Please fill in the details below.</p>
                    <p style="font-size: 0.875rem;" class="mb-1 fw-medium">What best describes why you’re starting a campaign?</p>

                    <!-- inputs to edit -->
                    <div class="row mx-auto chooseCategories mb-3">
                        <!-- loop this, note: change all text option, e.g. options, option1-->
                        <!--<div class="col">
                            <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off">
                            <label class="categoryButton" for="option1">option 1</label>
                        </div>-->
                        <!-- end here -->
                        <?php
                        $categories = [
                            'Animal Welfare',
                            'Arts and Culture',
                            'Community Development',
                            'Crisis Intervention',
                            'Disaster Relief',
                            'Elderly Care',
                            'Emergency Assistance',
                            'Environmental Conservation',
                            'Healthcare',
                            'Human Rights',
                            'Poverty Alleviation',
                            'Refugee Support',
                            'Technology',
                            'Urban Revitalization',
                            'Youth Empowerment'
                        ];

                        foreach ($categories as $category) {
                            echo "
                                <input type='radio' class='btn-check' name='category' id='$category' value='$category' autocomplete='off'>
                                <label class='categoryButton mx-2' for='$category' style='max-width: fit-content;'>$category</label>
                            ";
                        }
                        ?>


                    </div>

                    <p style="font-size: 0.875rem;" class="mb-1 fw-medium">Where are you located?</p>
                    <div class="row">
                        <div class="col-6">
                            <!-- Country dropdown -->
                            <label for="country">Country:</label>
                            <select class="form-select form-select-sm rounded-pill" style="font-size: 0.75rem;" name="country" id="country" onchange="getStates(this.options[this.selectedIndex].getAttribute('data-geoname-id'));">
                                <option selected>Loading...</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <!-- State dropdown -->
                            <label for="state">State:</label>
                            <select class="form-select form-select-sm rounded-pill" style="font-size: 0.75rem;" name="state" id="state">
                                <option selected>State</option>
                            </select>
                        </div>
                    </div>
                </div>
                </select>

                <!-- Second Page -->
                <div class="campaignSecondPage">
                    <h6 class="fw-bold">Step 2</h6>
                    <p class="mb-4" style="color: #AAAAAA; font-size: 0.75rem">Tell us a bit more about your campaign.</p>

                    <!-- inputs to edit -->
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.75rem">Campaign Name</label>
                        <input type="text" class="form-control" placeholder="Campaign Name" name="campaignName" style="font-size: 0.75rem">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.75rem">Upload a picture of campaign</label>
                        <input class="form-control" type="file" id="formFile" name="campaignPicture" accept="image/png,image/jpeg,image/jpg" style="font-size: 0.75rem">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.75rem">Description</label>
                        <textarea class="form-control" rows="3" name="description" style="font-size: 0.75rem; resize:none"></textarea>
                    </div>
                </div>

                <!-- Third Page -->
                <div class="campaignThirdPage">
                    <h6 class="fw-bold">Step 3</h6>
                    <p class="mb-4" style="color: #AAAAAA; font-size: 0.75rem">How much would you like to raise?</p>

                    <div class="input-group input-group-sm my-5">
                        <span class="input-group-text" id="basic-addon1">RM</span>
                        <input type="number" class="form-control" name="goal" placeholder="Your Initial Goal">
                    </div>
                    <div class="alert alert-main">
                        To receive money raised, please make sure the person withdrawing has:
                        <ul class="mt-2">
                            <li>An Identity Card or a passport</li>
                            <li>A bank account in Malaysia</li>
                            <li>A mailing address in Malaysia</li>
                        </ul>
                    </div>
                </div>

                <!-- Fourth Page -->
                <div class="campaignFourthPage">
                    <div class="d-flex w-100 h-100">
                        <div class="m-auto">
                            <h4 class="fw-bold text-center">Thanks for your cooperation!</h4>
                            <p class="mb-4" style="color: #AAAAAA; font-size: 0.75rem">
                                Please wait for our admin to verify the campaign after you have submitted.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Button Container -->
                <div class="campaignButtonContainer">
                    <div class="row justify-content-end">
                        <div class="col-12 mb-3">
                            <div class="progress" role="progressbar" style="height: 2px !important;">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <button type="button" class="backButton" onclick="backFirstPage()" style="display: none"><i class="fa-solid fa-circle-left fs-2"></i></button>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" name="startCampaign" class="rounded-pill donateBtn py-1 px-3 nextButton" style="font-size: 0.875rem" onclick="showSecondPage()">Continue</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="./js/startCampaign.js"></script>
    <script src="js/countryState.js"></script>
    <div class="successAlert"></div>
</body>

</html>