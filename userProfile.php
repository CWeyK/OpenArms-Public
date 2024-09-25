<?php include "header.php";

//obtain user detail
$userid = $_SESSION['userid'];
$query = "SELECT * FROM user WHERE userid='$userid'";
$query_run = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($query_run);
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


    <div class="mainContent" style="margin: 0 100px;">
        <h3 class="fw-bold mt-4 ps-2">Profile </h3>
        <div class="row">
            <!-- left -->
            <div class="col-4">
                <div class="card p-4">
                    <div class="text-center profilePictureContainer position-relative">
                        <img src="./images/<?= $user['profilepicture'] ?>" style="width: 15rem; height: 15rem; object-fit: fill;" class="rounded-circle" />
                        <button type="button" class="profileEditImgBtn" data-bs-toggle="modal" data-bs-target="#editProfilePicModal">Edit</button>
                    </div>
                    <p class="mt-4" style="font-size: 0.875rem;"><span class="fw-bold">Points: </span><?= $user['points'] ?></p>
                    <p class="m-0" style="font-size: 0.875rem;">
                        <!-- change 123abc to get from database -->
                        <span class="fw-bold">Referral Code: </span><?= $user['referralCode'] ?>
                        <!-- here also vvv copyToClipboard('123abc') -->
                        <button type="button" class="copyBtn ms-2" data-bs-toggle="tooltip" data-bs-title="Copy" onclick="copyToClipboard('<?= $user['referralCode'] ?>')">
                            <i class="fa-regular fa-clipboard"></i>
                        </button>
                    </p>
                </div>
            </div>

            <!-- right -->
            <div class="col-8">
                <div class="card">
                    <form action='server.php' method='POST'>
                        <div class="d-flex justify-content-between">
                            <h4 class="p-3 m-0">Details</h4>
                            <?php
                            //display if update success
                            if (isset($_SESSION['profilestatus'])) {
                                echo $_SESSION['profilestatus'];
                                unset($_SESSION['profilestatus']);
                            }
                            if (isset($_SESSION['passwordStatus'])) {
                                echo $_SESSION['passwordStatus'];
                                unset($_SESSION['passwordStatus']);
                            }

                            ?>
                            <button type="button" id="editButton" class="btn p-3 profileEditBtn" onclick="enableEdit()" style="display: block;"><i class="fa-solid fa-pen-to-square fs-4"></i></button>
                            <div id="saveContainer" style="display:none;">
                                <!-- Remember to change the save button type to submit -->
                                <button class="btn p-3 profileSaveBtn" type='submit' value='profileSave' id="profileSave" name='profileSave'><i class="fa-regular fa-bookmark fs-4"></i></button>

                                <button type="button" class="btn p-3 profileCancelbtn" onclick="cancelEdit()"><i class="fa-regular fa-circle-xmark fs-4"></i></button>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="p-3 profileInput" style="font-size: 0.75rem;">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name='firstName' placeholder="First Name" value='<?= $user['firstName'] ?>' oninput="validateFNameFormat(this)" disabled>
                                    <small id="fNameHelp" class="form-text text-muted" style="display: none">No Special Characters</small>
                                </div>
                                <div class="col-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value='<?= $user['lastName'] ?>' oninput="validateLNameFormat(this)" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email Address" value='<?= $user['email'] ?>' oninput="validateEmailFormat(this)" disabled>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" placeholder="******" disabled>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#changePwModal"><i class="fa-regular fa-pen-to-square"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact" value='<?= $user['contact'] ?>' oninput="validateContactFormat(this)" disabled>
                                    <small id="contactHelp" class="form-text text-muted" style="display: none">Enter a valid phone number (e.g., +60123456789).</small>
                                </div>
                                <div class="col-6">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday" value='<?= $user['birthday'] ?>' disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" disabled style="resize: none;"><?= $user['address'] ?></textarea>
                                </div>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
    <script src="./js/userProfile.js"></script>
    <script src="./js/profilePictureChange.js"></script>

    <div class="modal fade" id="editProfilePicModal" tabindex="-1" role="dialog" aria-labelledby="editProfilePicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editProfilePicModalLabel">Edit Profile Picture</h5>
                    <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="server.php" method="POST" enctype="multipart/form-data" id="profilePicForm">
                        <div class="form-group">
                            <label for="profilePic">Choose Profile Picture:</label>
                            <input type="file" class="form-control-file mt-1" id="profilePic" name="profilePicture" accept="image/*" required>
                            <p id="fileInfo">Allowed file types: JPEG, JPG, PNG.<br>Maximum file size: 2 MB.</p>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hiddenRestaurantID">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="editProfilePicture" id="editRestaurantPhoto">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePwModal" tabindex="-1" role="dialog" aria-labelledby="editProfilePicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="m-0 fw-bold">Change Password</h6>
                    <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- form (validation all done) -->
                <form id="changePwForm" action="server.php" method="POST">
                    <div class="modal-body" style="font-size: 0.875rem;">

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label required">Old Password</label>
                            <input type="password" class="form-control form-control-sm" id="oldPassword" name="oldPassword" placeholder="Old Password">
                            <div class="invalid-feedback">
                                Please enter old password.
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control form-control-sm" id="newPassword" name="newPassword" placeholder="New Password" oninput="validatePassword()">
                            <div class="invalid-feedback">
                                Please enter a valid password.
                            </div>
                            <div id="passwordHelpBlock" class="form-text">
                                Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Repeat Password</label>
                            <input type="password" class="form-control form-control-sm" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password" oninput="validatePassword()">
                            <div class="invalid-feedback">
                                Password does not match.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="changePassword" id="changePassword">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>