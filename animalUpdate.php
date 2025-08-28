<?php 
    session_start();
    include 'connection.php';

    // Check if all required session variables are set
    if(!isset($_SESSION['userId']))
    {
        header('location:login.php');
        exit(); // Ensure to exit after redirection
    }

    // Initialize variables to store user's first name and last name
    $firstName = '';
    $lastName = '';
    $type = '';

    // Retrieve user's first name and last name from the database
    $userId = $_SESSION['userId'];
    $query = "SELECT firstName, lastName, type FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $query);
    // mysqli_stmt_bind_param($stmt, "i", $userId);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $firstName, $lastName, $type);
            mysqli_stmt_fetch($stmt);
        } else {
            // Handle SQL execution error
            echo "Error executing SQL statement: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt); // Close statement
    } else {
        // Handle SQL preparation error
        echo "Error preparing SQL statement: " . mysqli_error($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <style>
        /* Set max-height for scrollable container */
        .scrollable-container {
            overflow-y: auto;
            margin-top: 100px;
            max-height: 80vh;
            margin: 0px;
        }

        .scrollable-container::-webkit-scrollbar {
            display: none;
        }

        @media (min-width: 992px) {
            .animalCard .cardG .col-lg-3 {
                /* Adjust the width for large screens (desktops) */
                flex: 0 0 calc(20% - 1rem); /* Each card takes 25% width with margin */
                max-width: calc(20% - 1rem); /* Each card maximum width */
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
                <a class="nav-link" href="adminDashboard.php">
                    <i class="fa fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Shelter
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Animal</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Animal History</h6>
                        <a class="collapse-item" href="animalUpdate.php">Animal Profile</a>
                        <a class="collapse-item" href="#">Animal List</a>
                        <a class="collapse-item" href="#">Adoption History</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Users Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Users</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">User History</h6>
                        <a class="collapse-item" href="#">Adopters</a>
                        <a class="collapse-item" href="#">Volunteers</a>
                        <a class="collapse-item" href="#">Visitors</a>
                        <a class="collapse-item" href="#">Donations</a>
                        <a class="collapse-item" href="#">Scheduled Meeting</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                SHOP
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Overview</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Shelter Shop</h6>
                        <a class="collapse-item" href="#">Product Update</a>
                        <a class="collapse-item" href="#">Pending Sales</a>
                        <a class="collapse-item" href="#">Orders</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

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

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- <div class="input-group">
                        <select name="species" id="speciesFilter" class="form-control bg-light border-0 small">
                            <option value="" disabled selected></option>
                            <option class="form-control bg-light border-0 small" value="Dog">Dog</option>
                            <option class="form-control bg-light border-0 small" value="Cat">Cat</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <select class="form-control bg-light border-0 small" style="width: 5% !important;"name="status" id="statusFilter">
                            <option value="" disabled selected></option>
                            <option value="Adoptable">Adoptable</option>
                            <option value="In Foster">In Foster</option>
                            <option value="Pending">Pending</option>
                            <option value="Adopted">Adopted</option>
                            <option value="Medical Hold">Medical Hold</option>
                            <option value="Escaped/Lost">Escaped/Lost</option>
                            <option value="Pending Adoption">Pending Adoption</option>
                            <option value="Pending Transfer">Pending Transfer</option>
                        </select>
                    </div> -->



                    

                     <!-- Topbar Navbar -->
                     <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                         <!-- Nav Item - Alerts -->
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
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span> -->
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account! -->
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account. -->
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
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
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span> -->
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account! -->
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account. -->
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter"></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Messages 
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <!-- <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div> -->
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <!-- <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div> -->
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <!-- <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div> -->
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <!-- <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div> -->
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
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
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="userProfileV2.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                    

                </nav>
                <!-- End of Topbar -->

                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#animalModal" style="margin-left: 20px; margin-bottom: 10px;">Add Animal</button>

                     <!-- load cards -->
                    <!-- <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 animalCard">
                                <div class="scrollable-container cardG"> -->
                                    <div class="row" id="animalCardsRow" style="width: 100%;">
                                        <!-- Animal cards will be loaded dynamically here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- end -->

                <?php
                require 'connection.php';
                // session_start();

                function alert($title, $text, $icon, $timer = 2000) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: '{$icon}',
                                    title: '{$title}',
                                    text: '{$text}',
                                    showConfirmButton: false,
                                    timer: {$timer}
                                });
                            });
                        </script>";
                }

                if (isset($_POST["submitAnimal"])) {
                    // Validate and sanitize form inputs
                    $animalName = $_POST["animalName"] ?? '';
                    $species = $_POST["species"] ?? '';
                    $gender = $_POST["gender"] ?? '';
                    $status = $_POST["status"] ?? '';
                    $age = $_POST["age"] ?? '';
                    $birthday = $_POST["birthday"] ?? '';
                    $intakeType = $_POST["intakeType"] ?? '';
                    $intakeDate = $_POST["intakeDate"] ?? '';
                    $conditions = $_POST["conditions"] ?? '';
                    $description = $_POST["description"] ?? '';
                    $antiRabies = $_POST["antiRabies"] ?? '';
                    $vaccine = $_POST["vaccine"] ?? '';
                    $neutered = $_POST["neutered"] ?? '';
                    $deticked = $_POST["deticked"] ?? '';
                    $dewormed = $_POST["dewormed"] ?? '';

                    $newImageName = null;

                    // Handle image upload
                    if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== 4) {
                        $fileName = $_FILES["image"]["name"];
                        $fileSize = $_FILES["image"]["size"];
                        $tmpName = $_FILES["image"]["tmp_name"];
                        $validImageExtensions = ['jpg', 'jpeg', 'png'];
                        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                        if (!in_array($imageExtension, $validImageExtensions)) {
                            alert('Invalid File Extension', 'Allowed extensions are .jpg, .jpeg, .png.', 'error');
                        } else if ($fileSize > 10485760) {
                            alert('File Too Large', 'Image size should not exceed 10MB.', 'warning');
                        } else {
                            $newImageName = "animals/" . uniqid() . '.' . $imageExtension;
                            if (move_uploaded_file($tmpName, $newImageName)) {
                                // Prepare and execute the database insertion
                                $stmt = $conn->prepare("INSERT INTO animal (animalName, species, gender, status, age, birthday, intakeType, intakeDate, conditions, description, image, antiRabies, vaccine, neutered, deticked, dewormed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                $stmt->bind_param("ssssssssssssssss", $animalName, $species, $gender, $status, $age, $birthday, $intakeType, $intakeDate, $conditions, $description, $newImageName, $antiRabies, $vaccine, $neutered, $deticked, $dewormed);

                                if ($stmt->execute()) {
                                    $_SESSION['success_message'] = "Successfully inserted new animal.";
                                    echo "<script>window.location = '{$_SERVER['PHP_SELF']}';</script>";
                                    exit; // Redirect after successful insertion
                                } else {
                                    alert('Oops...', 'Failed to insert post into database.', 'error');
                                }
                            } else {
                                alert('Oops...', 'Failed to upload image.', 'error');
                            }
                        }
                    } else {
                        alert('Oops...', 'Image is required.', 'error');
                    }
                }
                ?>

                <!-- Modal for adding animal -->
        <div class="modal fade" id="animalModal" tabindex="-1" aria-labelledby="animalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="animalModalLabel">Add Animal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="animalForm" action="" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Image Preview -->
                                <div class="col-lg-4 mb-3">
                                    <div class="center-image mb-3">
                                        <img id="previewImage" src="https://via.placeholder.com/200" class="img-fluid rounded mb-3" alt="Preview Image">
                                    </div>
                                    <input type="file" name="image" id="animalImage" accept="image/*" class="form-control mb-3">
                                </div>
                            
                            <!-- Animal Details Section -->
                            <div class="col-lg-4">
                                <!-- <h4>Animal Details</h4> -->
                                <div class="mb-3">
                                    <label for="animalName" class="form-label">Animal Name</label>
                                    <input type="text" name="animalName" id="animalName" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="species" class="form-label">Species</label>
                                    <select name="species" id="species" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Adoptable">Adoptable</option>
                                        <option value="In Foster">In Foster</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Adopted">Adopted</option>
                                        <option value="Medical Hold">Medical Hold</option>
                                        <option value="Escaped/Lost">Escaped/Lost</option>
                                        <option value="Pending Adoption">Pending Adoption</option>
                                        <option value="Pending Transfer">Pending Transfer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" name="age" id="age" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" name="birthday" id="birthday" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="intakeType" class="form-label">Intake Type</label>
                                    <select name="intakeType" id="intakeType" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Stray">Stray</option>
                                        <option value="External Transfer">External Transfer</option>
                                        <option value="Owner Surrender">Owner Surrender</option>
                                        <option value="Born in Care">Born in Care</option>
                                        <option value="Return to Rescue">Return to Rescue</option>
                                        <option value="Abandoned">Abandoned</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="intakeDate" class="form-label">Intake Date</label>
                                    <input type="date" name="intakeDate" id="intakeDate" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            <!-- Medical Records Section -->
                            <div class="col-lg-4">
                                <!-- <h4>Medical Records</h4> -->
                                <div class="mb-3">
                                    <label for="conditions" class="form-label">Condition</label>
                                    <select name="conditions" id="conditions" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Healthy">Healthy</option>
                                        <option value="Pregnant">Pregnant</option>
                                        <option value="Injured">Injured</option>
                                        <option value="Sick">Sick</option>
                                        <option value="Feral">Feral</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="antiRabies" class="form-label">w/ Anti Rabies</label>
                                    <select name="antiRabies" id="antiRabies" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="vaccine" class="form-label">5-in-1 Vaccine</label>
                                    <select name="vaccine" id="vaccine" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="neutered" class="form-label">Neutered</label>
                                    <select name="neutered" id="neutered" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="deticked" class="form-label">Deticked</label>
                                    <select name="deticked" id="deticked" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dewormed" class="form-label">Dewormed</label>
                                    <select name="dewormed" id="dewormed" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submitAnimal" class="btn btn-secondary">Add Animal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    // Display success message if set in session
    if (isset($_SESSION['success_message'])) {
        alert('Success', $_SESSION['success_message'], 'success');
        unset($_SESSION['success_message']); // Clear the success message after displaying
    }
    ?>

    <script>
        // JavaScript to handle image preview
        document.getElementById('animalImage').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>



            </div>
        </div>
    </div>            
       





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

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- <script>
             $(document).ready(function() {
                loadAnimalCards(); // Load animal cards when the page is ready

                function loadAnimalCards(species = '', status = '') {
                    showSpinner();
                    $.ajax({
                        url: 'loadCards.php',
                        type: 'GET',
                        data: { species: species, status: status },
                        success: function(response) {
                            var cardsRow = $('#animalCardsRow');
                            cardsRow.empty(); // Clear existing cards
                            $(response).each(function(index, cardHtml) {
                                // Create a column div for each card and append to the row
                                var colDiv = $('<div>')
                                    .addClass('col-12 col-sm-6 col-md-4 col-lg-2 mb-4') // Adjust mb-4 for margin-bottom spacing
                                    .html(cardHtml);
                                cardsRow.append(colDiv);
                            });
                            updateCardCount();
                        },
                        complete: function() {
                        hideSpinner(); // Hide spinner after request completes
                        },
                        error: function() {
                            $('#animalCardsRow').html('<p class="text-danger">Error loading animal cards.</p>');
                            hideSpinner(); // Hide spinner on error
                        }
                    });
                }

                // Function to update the card count
                function updateCardCount() {
                    var cardCount = $('#animalCardsRow').children().length;
                    $('#cardCount').text(cardCount); // Update the card count displayed
                }

                // Listen for click event on the search button
                $('#searchButton').click(function() {
                    var selectedSpecies = $('#speciesFilter').val(); // Get selected species
                    var selectedStatus = $('#statusFilter').val(); // Get selected status
                    loadAnimalCards(selectedSpecies, selectedStatus); // Load cards based on selected filters
                });

                // Function to reset all filters and load original animal cards
                function resetFilters() {
                    $('#speciesFilter').val(''); // Clear species filter
                    $('#statusFilter').val(''); // Clear status filter
                    loadAnimalCards(); // Load all animal cards without filters
                }

                // Listen for click event on the refresh button
                $('#refreshButton').click(function() {
                    resetFilters(); // Reset filters and reload animal cards
                });
                
            });
        </script> -->

        <script>
    $(document).ready(function() {
        // Function to load animal cards via AJAX
        function loadAnimalCards(species = '', status = '') {
            // Show spinner or loading indicator if needed
            $.ajax({
                url: 'animalUpdateInsert.php',
                type: 'GET',
                data: { species: species, status: status },
                success: function(response) {
                    var cardsRow = $('#animalCardsRow');
                    cardsRow.empty(); // Clear existing cards
                    $(response).each(function(index, cardHtml) {
                        // Create a column div for each card and append to the row
                        var colDiv = $('<div>')
                            // .addClass('col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4')
                            .html(cardHtml);
                        cardsRow.append(colDiv);
                    });
                    // Optionally, update card count or perform other tasks after loading
                },
                error: function() {
                    // Handle error loading cards
                    $('#animalCardsRow').html('<p class="text-danger">Error loading animal cards.</p>');
                },
                complete: function() {
                    // Hide spinner or loading indicator if needed
                }
            });
        }

        // Initial load of animal cards when the page is ready
        loadAnimalCards();
    });
</script>


</body>
</html>
