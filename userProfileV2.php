<?php
    session_start();
    include 'connection.php';

    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        header('location: login.php');
        exit(); // Ensure to exit after redirection
    }

    // Retrieve user information from session
    $userId = $_SESSION['userId'];
   
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
/* GENERAL */
body {
    font-family: 'Nunito', sans-serif;
    background-color: #f8f9fc;
    color: #000; /* lahat ng text black */
}

/* CARDS */
.card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 6px 18px rgba(54, 185, 204, 0.2);
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-5px);
}

/* TITLES & LABELS */
.card-body p.mb-0 {
    font-weight: 600;
    color: #000; /* black text */
}

.card-body .text-muted {
    color: #000 !important; /* override muted gray to black */
}

/* PROFILE IMAGE */
.img-profile {
    border: 3px solid #36b9cc;
    padding: 2px;
}

/* LIST GROUP */
.list-group-item {
    border: none;
    border-bottom: 1px solid #eee;
    color: #000;
}
.list-group-item:last-child {
    border-bottom: none;
}

/* ICONS */
.list-group-item i {
    color: #36b9cc;
    margin-right: 10px;
}

/* BUTTONS */
.btn-primary {
    background-color: #36b9cc;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    color: #fff; /* button text white for contrast */
    transition: all 0.3s ease-in-out;
}
.btn-primary:hover {
    background-color: #2c9faf;
    transform: scale(1.05);
}

/* MODAL */
.modal-content {
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.modal-header {
    background-color: #36b9cc;
    color: #fff;
    border-radius: 20px 20px 0 0;
}
.modal-header h5 {
    font-weight: 700;
}
.modal-body label {
    color: #000; /* labels black */
    font-weight: 600;
}

/* RESPONSIVE FIXES */
@media (max-width: 768px) {
    .card {
        margin-bottom: 20px;
    }
    .list-group-item {
        font-size: 14px;
    }
}

    </style>
</head>
<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-paw"></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="color: yellow; text-transform: none;">FurEver Finder</div>

                <!-- <div class="sidebar-brand-text mx-3">Finder</div> -->
            </a>

             <!-- Divider -->
             <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboardV2.php">
                    <i class="fa fa-home"></i>
                    <span>Homepage</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="animalProfileV2.php">
                    <i class="fas fa-paw"></i>
                    <span>Animal Profile</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="adoptionHistory.php">
                    <i class="fas fa-calendar"></i>
                    <span>Adoption History</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="appointment.php">
                    <i class="fas fa-calendar"></i>
                    <span>Appointment Schedule</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="donation2.php">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Send Your Donations</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="shop.php">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Shop Now</span></a>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                     <!-- Topbar Navbar -->
                     <ul class="navbar-nav ml-auto"> 
                         <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifications
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                     
                                    </div>
                                    <div>
                                   </div>
                                </a>
                                
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Notifications</a>
                            </div>
                        </li>

                        <!-- Nav Item - Shopping Cart -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-shopping-cart"></i>
                                <!-- Counter - Shopping Cart  -->
                                <span class="badge badge-danger badge-counter"></span>
                            </a>
                            <!-- Dropdown - Shopping Cart  -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    SHELTER SHOP
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                    </div>
                                    <div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Shop Notifications</a>
                            </div>
                        </li>


                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $firstName . ' ' . $lastName; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="user.png">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="userProfileV2.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

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
                                        <!-- <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Follow</button>
                                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Message</button> -->
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
                    <h5 class="modal-title" id="updateModalLabel">Update <strong><?php echo $_SESSION['user_name'] ?></strong>'s Profile</h5>
                    <button type="button" class="btn btn-icon" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>

                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    <form action="updateInsert.php" method="POST">
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
                            <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>
</html>