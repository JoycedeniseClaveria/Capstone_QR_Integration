<?php
    // session_start();
    include 'connection.php';
    include 'dashboardAdmin.php';

    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        header('location: login.php');
        exit(); // Ensure to exit after redirection
    }

    // Retrieve user information from session
    $userId = $_SESSION['userId'];
    // $firstName = $_SESSION['firstName'];
    // $lastName = $_SESSION['lastName'];

    // Fetch user data based on the logged-in user's information
    $query = "SELECT * FROM users WHERE userId = '$userId'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch user data from the result set
        $row = mysqli_fetch_assoc($result);

        // Extract user data for form input values
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $gender = $row['gender']; // Assuming 'gender' column in database (0 for Male, 1 for Female)
        $birthday = $row['birthday'];
        $emailAddress = $row['emailAddress'];
        $contactNo = $row['contactNo'];
        $maritalStatus = $row['maritalStatus'];
        $citizenship = $row['citizenship'];
        $location = $row['location'];

        // Determine checked status for gender radio buttons
        $checkedMale = ($gender == 0) ? 'checked' : '';
        $checkedFemale = ($gender == 1) ? 'checked' : '';

        // Check status for maritalStatus
        $checkedSingle = ($maritalStatus == 0) ? 'checked' : '';
        $checkedMarried = ($maritalStatus == 1) ? 'checked' : '';
        $checkedWidowed = ($maritalStatus == 2) ? 'checked' : '';
    } else {
        // Handle case where no user data was found
        die('User data not found.');
    }

    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* General Styles for the container and rows */
        .container {
            padding: 30px 15px; /* Adjust padding as needed */
        }

        /* Styling cards for consistency */
        .card {
            margin-bottom: 20px; /* Space between cards */
        }

        .card-body {
            text-align: center; /* Centering text for all card bodies */
        }

        .input-box label.icon {
            cursor: pointer; /* Indicate that label is clickable */
        }

        .list-group-item {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 15px; /* Uniform padding for list items */
        }

        .list-group-item i {
            font-size: 20px; /* Uniform font size for icons */
        }

        /* Increase card width on desktop screens */
        @media (min-width: 992px) {
            .col-lg-4 .card {
                width: 100%; /* Example: Increasing width to 80% of its container */
                margin: auto; /* This centers the card within its column if needed */
            }

            .card {
                width: 700px;
                margin-left: 20px;
                margin-right: 20px;
            }
        }

        /* Responsive column adjustments */
        @media (min-width: 768px) {
            .col-lg-4, .col-lg-8 {
                padding-right: 15px;
                padding-left: 15px;
            }
        }

        /* Specific styles for buttons */
        .btn-primary {
            margin-right: 5px; /* Space between buttons */
        }

        /* Modal button */
        [data-bs-toggle="modal"] {
            margin-top: 20px; /* Space above the modal trigger button */
        }

        .center-btn {
            display: flex;      
            justify-content: center; 
            align-items: center; 
        }

        .modal-header {
            background-color: #e3896b;
            color: white;
        }

    </style>
</head>
                <!-- User Profile  -->
                <?php
                    include 'connection.php';

                    // Check if all required session variables are set
                    if(!isset($_SESSION['userId']))
                    {
                        header('location:login.php');
                        exit(); 
                    }

                    // Assuming the user_name uniquely identifies the user in your database
                    $username = $_SESSION['userId'];

                    // Fetch data from the database for the logged-in user
                    $query = "SELECT * FROM users WHERE userId = '$userId'";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die('Query failed: ' . mysqli_error($conn));
                    }

                    // Display user information in a card
                    if ($row = mysqli_fetch_assoc($result)) {
                        // echo '<h2>User Profile</h2>';
                        // echo '<p><strong>Name:</strong> ' . $row['firstName'] . ' ' . $row['lastName'] . '</p>';
                        // echo '<p><strong>Email:</strong> ' . $row['emailAddress'] . '</p>'; // Adjust this line based on your database columns
                        // echo '<p><strong>Address:</strong> ' . $row['contactNo'] . '</p>'; // Adjust this line based on your database columns
                        // Add more fields as needed
                    }

                    // Free result set
                    mysqli_free_result($result);

                    // Close connection
                    mysqli_close($conn);
                ?>

                <section style="">
                    <div class="container py-5">
                        <div class="row">

                        <div class="row" style="margin-top: 30px;">
                            <div class="col-lg-4">
                                <div class="card mb-4" >
                                     <div class="card-body text-center">
                                        <!-- <img src="" alt="avatar"
                                        class="rounded-circle img-fluid" style="width: 150px;"> -->
                                        <div class="input-box">
                                            <label for="profile-image-upload" class="icon"><i class='bx bx-image-add'></i></label>
                                            <input type="file" id="profile-image-upload" name="profileImage" style="display: none;">
                                            <span id="selected-file-name"></span>
                                        </div>
                                        <h5 class="my-3"><?php echo $row['firstName'] . ' ' . $row['lastName'] . '</p>';?></h5>
                                        <p class="text-muted mb-1"><?php echo $row['username'];?></p>
                                        <p class="text-muted mb-4"><?php echo $row['location'];?></p>
                                        <div class="d-flex justify-content-center mb-2">
                                        <!-- <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Follow</button> -->
                                        <!-- <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Message</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4 mb-lg-0">
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush rounded-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="fa fa-phone" style="font-size:20px"></i>
                                            <p class="mb-0"><?php echo $row['contactNo'];?></p>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="fa fa-envelope" style="font-size:20px"></i>
                                            <p class="mb-0"><?php echo $row['emailAddress'];?></p>
                                        </li>
                                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                            <p class="mb-0">@mdbootstrap</p>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                            <p class="mb-0">mdbootstrap</p>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                            <p class="mb-0">mdbootstrap</p>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Full Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['firstName'] . ' ' . $row['lastName'] . '</p>';?></p>
                                        </div>
                                    </div>
                                
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Gender</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                $gender = $row['gender'];
                                                $genderText = ($gender == 1) ? 'Female' : 'Male';
                                            ?>
                                            <p class="text-muted mb-0"><?php echo $genderText; ?></p>
                                        </div>
                                    </div>
                                
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Birthday</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                $birthday = $row['birthday']; 
                                                $formattedBirthday = date('F j, Y', strtotime($birthday));
                                            ?>
                                            <p class="text-muted mb-0"><?php echo $formattedBirthday; ?></p>
                                        </div>
                                    </div>
                                        
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Marital Status</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                            $maritalStatus = $row['maritalStatus'];

                                            if ($maritalStatus == 0) {
                                                $statusText = "Single";
                                            } elseif ($maritalStatus == 1) {
                                                $statusText = "Married";
                                            } elseif ($maritalStatus == 2) {
                                                $statusText = "Widowed";
                                            } else {
                                                $statusText = "Unknown";
                                            }
                                            ?>
                                            <p class="text-muted mb-0"><?php echo $statusText; ?></p>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Citizenship</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['citizenship'];?></p>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Location</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['location'];?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <td style="text-align: center; padding: 10px;">
                                <a href="update.php" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Update
                                </a>
                            </td> -->

                            <!-- Button to trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fas fa-edit"></i> Update Profile </button>
                        </div>
                     </div>
                </section>
            </div>
        </div>
    </div>

     <!-- Modal -->
     <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg custom-modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update <strong><?php echo $_SESSION['admin_name'] ?></strong>'s Profile</h5>
                    <button type="button" class="btn btn-icon" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true" style="color: white;"></i>
                    </button>

                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    <form action="updateAdminInsert.php" method="POST">
                        <label for="firstName"><strong>First Name</strong></label>
                        <input type="text" name="firstName" class="form-control" value="<?php echo htmlspecialchars($firstName); ?>" readonly><br>

                        <label for="lastName"><strong>Last Name</strong></label>
                        <input type="text" name="lastName" class="form-control" value="<?php echo htmlspecialchars($lastName); ?>" readonly><br>

                        <label for="gender"><strong>Gender</strong></label><br>
                        <input type="radio" name="gender" value="0" <?php echo $checkedMale; ?>> Male
                        <input type="radio" name="gender" value="1" <?php echo $checkedFemale; ?>> Female<br><br>

                        <label for="birthday"><strong>Birthday</strong></label>
                        <input type="date" name="birthday" class="form-control" value="<?php echo $birthday; ?>"><br>

                        <label for="emailAddress"><strong>Email Address</strong></label>
                        <input type="email" name="emailAddress" class="form-control" value="<?php echo $emailAddress; ?>"><br>

                        <label for="contactNo"><strong>Contact No</strong></label>
                        <input type="text" name="contactNo" class="form-control" value="<?php echo $contactNo; ?>"><br>

                        <label for="maritalStatus"><strong>Marital Status</strong></label><br>
                        <input type="radio" name="maritalStatus" value="0" <?php echo $checkedSingle; ?>> Single
                        <input type="radio" name="maritalStatus" value="1" <?php echo $checkedMarried; ?>> Married
                        <input type="radio" name="maritalStatus" value="2" <?php echo $checkedWidowed; ?>> Widowed<br><br>

                        <label for="citizenship"><strong>Citizenship</strong></label>
                        <input type="text" name="citizenship" class="form-control" value="<?php echo $citizenship; ?>"><br>

                        <label for="location"><strong>Location</strong></label>
                        <input type="text" name="location" class="form-control" value="<?php echo $location; ?>">

                        <div class="center-btn mt-3">
                            <button type="submit" name="update" class="btn btn-primary mt-3" style="background-color: #e3896b !important; border-color: #e3896b !important;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>