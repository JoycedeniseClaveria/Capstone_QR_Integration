<?php 
    include 'connection.php';

    session_start();

    // Check if all required session variables are set
    if(!isset($_SESSION['userId']))
    {
        header('location:login.php');
        exit(); // Ensure to exit after redirection
    }

    // Initialize variables to store user's first name and last name
    $firstName = '';
    $lastName = '';

    // Retrieve user's first name and last name from the database
    $userId = $_SESSION['userId'];
    $query = "SELECT firstName, lastName FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $query);
    // mysqli_stmt_bind_param($stmt, "i", $userId);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $firstName, $lastName);
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
    <title>Animal Profile</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <style>
        /* Set max-height for scrollable container */
        .scrollable-container {
            overflow-y: auto;
            margin-top: 10px;
            max-height: 85vh;
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

  .cards {
  
    padding-left: 20px;
      
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }
    #dogCardsRow, #catCardsRow {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px; 
    padding-top:5px;
    /* space between cards */
}


/* Tablet */
@media (min-width: 576px) {
    .cards {
        flex: 0 1 calc(50% - 30px); /* 2 cards per row */
    }
}

/* Desktop */
@media (min-width: 768px) {
    .cards {
        flex: 0 1 calc(33.33% - 30px); /* 3 cards per row */
    }
}

/* Large screens */
@media (min-width: 1200px) {
    .cards {
        flex: 0 1 calc(25% - 30px); /* 4 cards per row */
    }
}

.cards {
    flex: 0 1 calc(20% - 20px); /* 5 cards per row */
    max-width: calc(20% - 20px);
    padding-left: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-paw"></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="color: yellow; text-transform: none;">SECASPI</div>

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

            </li> 

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
                <!--<a class="nav-link" href="donation1.html">-->
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
<div class="d-flex justify-content-end align-items-center gap-2 mb-3 pr-4" style="gap: 10px;">
    <select id="speciesFilter" class="form-control" style="width: 200px;">
        <option value="All">All Species</option>
        <option value="Dog">Dog</option>
        <option value="Cat">Cat</option>
    </select>

    <select id="statusFilter" class="form-control" style="width: 200px;">
        <option value="">All Status</option>
        <option value="Adoptable">Adoptable</option>
        <option value="In foster">In foster</option>
        <option value="Pending">Pending</option>
        <option value="Adopted">Adopted</option>
        <option value="Medical Hold">Medical Hold</option>
        <option value="Escaped/Lost">Escaped/Lost</option>
        <option value="Pending Adoption">Pending Adoption</option>
        <option value="Pending Transfer">Pending Transfer</option>
    </select>
</div>


<section id="dog-section" class="animal-section">
  <h4 class="section-title"
      id="dogSectionTitle"
      style="font-weight: bold; color: black; padding-left: 30px;">
    Dog Lists
  </h4>
  <div class="row justify-content-center px-4"
       id="dogCardsRow"
       style="width: 100%;">
    <!-- Add dog cards here -->
  </div>
</section>

<section id="cat-section" class="animal-section" style="margin-top: 30px;">
  <h4 class="section-title"
      id="catSectionTitle"
      style="font-weight: bold; color: black; padding-left: 30px;">
    Cat Lists
  </h4>
  <div class="row justify-content-center px-4"
       id="catCardsRow"
       style="width: 100%;">
    <!-- Add cat cards here -->
  </div>
</section>
        
       




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

    

 <script>
$(document).ready(function () {
    function loadAnimalCards(species, status) {
        if (species === 'Dog') {
            $.ajax({
                url: 'loadCards.php',
                type: 'GET',
                data: { species: 'Dog', status: status },
                success: function (response) {
                    $('#dogCardsRow').html(response);
                    $('#dogSectionTitle').show();
                    $('#dogCardsRow').show();
                    $('#catSectionTitle').hide();
                    $('#catCardsRow').hide();
                }
            });
        } else if (species === 'Cat') {
            $.ajax({
                url: 'loadCards.php',
                type: 'GET',
                data: { species: 'Cat', status: status },
                success: function (response) {
                    $('#catCardsRow').html(response);
                    $('#catSectionTitle').show();
                    $('#catCardsRow').show();
                    $('#dogSectionTitle').hide();
                    $('#dogCardsRow').hide();
                }
            });
        } else {
            // All animals: Load both
            $.ajax({
                url: 'loadCards.php',
                type: 'GET',
                data: { species: 'Dog', status: status },
                success: function (response) {
                    $('#dogCardsRow').html(response);
                    $('#dogSectionTitle').show();
                    $('#dogCardsRow').show();
                }
            });
            $.ajax({
                url: 'loadCards.php',
                type: 'GET',
                data: { species: 'Cat', status: status },
                success: function (response) {
                    $('#catCardsRow').html(response);
                    $('#catSectionTitle').show();
                    $('#catCardsRow').show();
                }
            });
        }
    }

    // Initial load
    const defaultSpecies = $('#speciesFilter').val();
    const defaultStatus = $('#statusFilter').val();
    loadAnimalCards(defaultSpecies, defaultStatus);

    // Event listeners for both filters
    $('#speciesFilter, #statusFilter').on('change', function () {
        const species = $('#speciesFilter').val();
        const status = $('#statusFilter').val();
        loadAnimalCards(species, status);
    });
});
</script>



</body>
</html>