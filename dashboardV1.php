<?php 
    include 'connection.php';

    session_start();

    if(!isset($_SESSION['userId']))
    {
        header('location:login.php');
        exit(); 
    }

    $firstName = '';
    $lastName = '';

    $userId = $_SESSION['userId'];
    $query = "SELECT firstName, lastName FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $firstName, $lastName);
            mysqli_stmt_fetch($stmt);
        } else {
        
            echo "Error executing SQL statement: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {

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
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link href="css/sb-admin-2.css" rel="stylesheet"> 
    <link rel="stylesheet" href="style.css">
 
    <style>
            body {
        opacity: 0;
        transition: opacity 0.5s ease-in;
        background: var(--bg);
        font-family: 'Nunito', system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;
        color: #343A40;
        line-height: 1.6;
        transition: opacity .5s ease-in;
        }

            body.fade-in {
        opacity: 1;
        }

            html {
        scroll-behavior: smooth;
        }

       

        h3, h4, h5 {
        font-weight: 600;
        }

        a {
        text-decoration: none;
        transition: var(--transition);
        }


        
        .card {
        border: none;
        border-radius: var(--card-radius);
        background: #fff;
        transition: var(--transition);
        position: relative;
        }

        .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.08);
        }

        .section-title {
        position: relative;
        display: inline-block;
        }

        .section-title::after {
        content: '';
        display: block;
        height: 4px;
        width: 80px;
        background: var(--primary);
        margin: 8px auto 0;
        border-radius: 2px;
        }

        .highlight-card {
        background: #fff;
        border-radius: var(--card-radius);
        overflow: hidden;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
        background-color: var(--primary);
        border-radius: 25%;
        padding: 12px;
        background-size: 16px;
        }

        .badge-custom {
        background: var(--accent);
        color: #fff;
        border-radius: 999px;
        padding: .3rem .7rem;
        font-size: .65rem;
        text-transform: uppercase;
        }

        .upcoming-card .card-title {
        color: var(--primary);
        }
    
    
    .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 225px;
    z-index: 1000;
    overflow: hidden;
         margin: 0 !important;
        padding: 0 !important;
}

#content-wrapper {
    margin-left: 225px;
    height: 100vh;
    overflow-y: auto;
}

@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }

    #content-wrapper {
        margin-left: 0;
        height: auto;
        overflow-y: visible;
    }
}


    </style>
 
</head>
<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-paw"></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="color: yellow; text-transform: none;">SECASPI</div>
            </a>

             <!-- Divider -->
             <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboardV2.php">
                    <i class="fa fa-home"></i>
                    <span>Homepage</span></a>
            </li>
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
                                   
                                    </div>
                                    <div>
                                   </div>
                                </a>
                                
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Notifications</a>
                            </div>
                        </li>

                        <!-- Nav Item - Shopping Cart -->
                        <li class="nav-item">
                            <a href="#" class="nav-link position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="fas fa-shopping-cart fa-lg text-dark"></i>

                            </a>
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



        <!-- AOS JS -->
        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
        AOS.init();
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
            document.body.classList.add("fade-in");
            });
        </script>


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