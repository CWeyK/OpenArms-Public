<?php
include "header.php";




//how many results per page
$results_per_page = 8;
$start = 0;

if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $results_per_page;
}

//count how many results (no search)
$campaignCountquery = "SELECT * FROM campaign WHERE approvalStatus='Approved'";
$campaignCountresult = mysqli_query($conn, $campaignCountquery);
$number_of_results = mysqli_num_rows($campaignCountresult);




//search and filter (discoverJ.php)
if (isset($_GET['searchFilter'])) {
    // Initialize an empty base SQL
    $searchsql = "SELECT * ";

    //sort
    if (isset($_GET['recentDonation'])) {
        // Recent
        $sort = "dateRequested";
    } elseif (isset($_GET['popularDonation'])) {
        // Popular (most number of donations in one month)
        $sort = "donationCount";
        $subsql = "SELECT COUNT(*) AS donationCount FROM donation WHERE campaignid=campaign.campaignid AND date BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()";
    } elseif (isset($_GET['topDonation'])) {
        //determine which top
        if ($_GET['topOption'] == 'money') {
            // Top (most amount donated)
            $sort = "amountDonated";
            $subsql = "SELECT SUM(amount) AS amountDonated FROM donation WHERE campaignid=campaign.campaignid";
        } else if ($_GET['topOption'] == 'number') {
            // Top (most number of donations)
            $sort = "donationCount";
            $subsql = "SELECT COUNT(*) AS donationCount FROM donation WHERE campaignid=campaign.campaignid";
        }
    }

    // Add subquery
    if (isset($subsql)) {
        $searchsql .= ", ($subsql) AS $sort";
    }

    //add from
    $searchsql .= " FROM campaign";

    //add approval status requirement
    $searchsql .= " WHERE approvalStatus='Approved'";

    // General search box
    if (isset($_GET['search'])) {
        if ($_GET['search'] != "") {
            $search = $_GET['search'];
            $search = mysqli_real_escape_string($conn, $search);
            // Add conditions to the SQL
            $searchsql .= " AND
                (campaignName LIKE '%$search%' 
                OR campaignDetails LIKE '%$search%' 
                OR category LIKE '%$search%' 
                OR state LIKE '%$search%' 
                OR country LIKE '%$search%' 
                OR organizer IN (SELECT userid FROM user WHERE firstName LIKE '%$search%' OR lastName LIKE '%$search%'))";
        }
    }

    // Category filter
    if (isset($_GET['category'])) {
        $categories = $_GET['category'];

        // If there are multiple categories, use IN operator
        if (is_array($categories) && count($categories) > 0) {
            $categoryList = implode("','", $categories);
            $searchsql .= " AND category IN ('$categoryList')";
        } else {
            // If only one category is selected
            $searchsql .= " AND category='$categories'";
        }
    }

    //country filter
    if ($_GET['country'] != "" && $_GET['country'] != "Loading..." && $_GET['country'] != "Country") {
        $country = $_GET['country'];

        // Add country condition to the SQL
        $searchsql .= " AND country='$country'";
    }
    //if no sort selected, sort by date
    if (!isset($sort)) {
        $sort = "dateRequested";
    }
    // Add sort condition to the SQL    
    $searchsql .= " ORDER BY $sort DESC";
}


//obtain campaign details
//check if search filter has been applied or not
if (isset($searchsql)) {
    $campaignquery = $searchsql;
    $campaignquery .= " limit $start, $results_per_page";
    $campaignCountquery = $searchsql;
    $campaignCountresult = mysqli_query($conn, $campaignCountquery);
    $number_of_results = mysqli_num_rows($campaignCountresult);
} else {
    $campaignquery = "SELECT * FROM campaign WHERE approvalStatus='Approved' limit $start, $results_per_page";
}

$campaignresult = mysqli_query($conn, $campaignquery);
$campaigns = mysqli_fetch_all($campaignresult, MYSQLI_ASSOC);


//determine number of pages
$pages = ceil($number_of_results / $results_per_page);



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

    <form action="discoverJ.php" method="GET">
        <div class="mainContent d-flex flex-column">
            <div class="marginContent mt-4">
                <div class="d-flex flex-wrap justify-content-between">
                    <h5 class="fw-bold mb-2">Discover Campaign To Donate</h5>
                    <div class="d-flex">
                        <!-- search -->
                        <div class="input-group me-3 mb-2 mb-md-0" style="height: 30px; width: 250px;">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search...">
                        </div>
                        <!-- expand offcanvas filter -->
                        <button class="quantityBtn" type="button" style="width: 30px; height: 30px;" data-bs-toggle="offcanvas" data-bs-target="#filterOffCanvas"><i class="fa-solid fa-filter"></i></button>
                    </div>
                </div>
                <?php
                if (isset($_GET['search'])) {
                    if ($_GET['search'] != "") {
                ?>
                        <p>Searching for "<?= $search ?>" (<?= $number_of_results ?>) results found</p>
                <?php }
                } ?>
                <!-- no results found -->
                <?php if ($number_of_results == 0) { ?>
                    <h4 class="fw-bold mx-auto" style="width:fit-content">No results found!</h4>
                <?php } ?>
                <div class="row">
                    <!-- only need one card and loop all -->
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
                        <div class="col-md-6 col-sm-12 col-lg-3">

                            <div class="card p-0 my-3 mx-auto" style="width: 18rem;">
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
            <?php if ($number_of_results !== 0) { ?>

                <div class="discoverPagination mx-auto text-center">
                    <!--Pagination-->
                    <?php
                    if (!isset($_GET['page-nr'])) {
                        $pageCurrent = 1;
                    } else {
                        $pageCurrent = $_GET['page-nr'];
                    }
                    ?>
                    <div style="font-size: 0.875rem;" class="mb-2 text-muted fw-medium">Showing page <?= $pageCurrent ?> of <?= $pages ?></div>

                    <!-- First -->
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="?page-nr=1<?php echo buildQueryString(); ?>">First</a>
                        </li>

                        <!-- Previous -->
                        <?php if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?page-nr=<?php echo $_GET['page-nr'] - 1; ?><?php echo buildQueryString(); ?>">Previous</a>
                            </li>
                        <?php } else { ?>
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                        <?php } ?>

                        <!-- Page numbers -->
                        <?php
                        $currentPage = isset($_GET['page-nr']) ? $_GET['page-nr'] : 1;
                        $halfRange = 2; // Adjust this value to determine the half-range of page numbers to display.

                        $start = max(1, $currentPage - $halfRange);
                        $end = min($pages, $currentPage + $halfRange);

                        // Ensure that at least 5 page numbers are displayed
                        while (($end - $start + 1) < 5 && $end < $pages) {
                            $end++;
                        }

                        $start = max(1, $end - 4); // Adjust to display exactly 5 page numbers

                        for ($counter = $start; $counter <= $end; $counter++) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="?page-nr=<?php echo $counter; ?><?php echo buildQueryString(); ?>" <?php echo ($counter == $currentPage) ? 'class="current"' : ''; ?>><?php echo $counter; ?></a>
                            </li>
                        <?php } ?>

                        <!-- Next -->
                        <?php if (!isset($_GET['page-nr']) || $_GET['page-nr'] < $pages) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?page-nr=<?php echo isset($_GET['page-nr']) ? $_GET['page-nr'] + 1 : 2; ?><?php echo buildQueryString(); ?>">Next</a>
                            </li>
                        <?php } else { ?>
                            <li class="page-item disabled">
                                <a class="page-link">Next</a>
                            </li>
                        <?php } ?>

                        <!-- Last -->
                        <li class="page-item">
                            <a class="page-link" href="?page-nr=<?php echo $pages; ?><?php echo buildQueryString(); ?>">Last</a>
                        </li>
                </div>
            <?php } ?>

        </div>
        </div>

        <!-- filter offcanvas -->
        <div class="offcanvas offcanvas-end" style="font-size: 0.875rem;" tabindex="-1" id="filterOffCanvas" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header" style=" box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                <h5 class="offcanvas-title fw-bold" style="color: #769fcd;"><i class="fa-solid fa-filter me-2"></i>Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" style="padding-bottom: 4.5rem;">
                <div class="text-end">
                    <button class="resetBtn" type="button"><a href="discoverJ.php" style="text-decoration:none; color:white">Reset</a></button>
                </div>
                <!-- sort by -->
                <h6 class="fw-semibold">Sort By</h6>
                <div class="d-flex">
                    <div class="form-check me-4">
                        <!-- top donation -->
                        <input class="form-check-input sortCheckbox" type="checkbox" name="topDonation" id="topDonation">
                        <label class="form-check-label">
                            Top
                        </label>
                    </div>
                    <div class="col-6">
                        <!-- select top donation type-->
                        <select class="form-select form-select-sm rounded-pill topDonationSelect" name="topOption" style="font-size: 0.75rem; display: none;">
                            <option value="money" selected>Money Raised</option>
                            <option value="number">Number of Donation</option>
                        </select>
                    </div>
                </div>
                <div class="form-check">
                    <!-- recent donation -->
                    <input class="form-check-input sortCheckbox" type="checkbox" name="recentDonation" id="recentDonation">
                    <label class="form-check-label">
                        Recent
                    </label>
                </div>
                <div class="form-check">
                    <!-- popular donation -->
                    <input class="form-check-input sortCheckbox" type="checkbox" name="popularDonation" id="popularDonation">
                    <label class="form-check-label">
                        Popular
                    </label>
                </div>

                <!-- category -->
                <h6 class="fw-semibold mt-4">Categories</h6>
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
                            <div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='category[]' id='$category' value='$category'>
                                <label class='form-check-label'>
                                    $category
                                </label>
                            </div>
                        ";
                }
                ?>

                <!-- country -->
                <h6 class="fw-semibold mt-4">Country</h6>
                <select class="form-select form-select-sm rounded-pill" style="font-size: 0.75rem;" name="country" id="country">
                    <option selected>Loading...</option>
                </select>

            </div>


            <!-- apply filter -->
            <div class="applyFilter">
                <button class="applyFilterBtn" name="searchFilter" value="1" type="submit">(0 Selected) Apply</button>
            </div>
        </div>
    </form>
    <script src="./js/discover.js"></script>
    <script src="./js/countryState.js"></script>
</body>

</html>