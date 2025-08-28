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
    <title>Shelter Shop</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <style>
         .product-list {
            padding: 0;
        }
        .product {
            margin-bottom: 1em;
            display: flex;
            justify-content: center;
        }
        .card {
            position: relative;
            padding: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 500px; /* Adjust this value as needed */
            max-width: 400px; /* Adjust this value as needed */
            width: 100%;
            overflow: hidden;
        }
        .carousel-inner img {
            height: 300px;
            object-fit: cover;
        }
        .card h3, .card p, .card form {
            margin-bottom: 1em;
        }
        .card .card-body {
            transition: transform 0.3s ease-in-out;
            transform: translateY(-100%);
            position: absolute;
            height: 100%;
            /* bottom: 0; */
            top: 0;
            left: 0;
            right: 0;
            background: orange;
            padding: 1em;
            z-index: 10;
            opacity: 0.6;
        }
        .card:hover .card-body {
            transform: translateY(0);
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5em 1em;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .btn-custom i {
            margin-right: 0.5em;
        }

        .button-container {
            display: flex;
            justify-content: center;
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

            <!-- Heading -->
            <div class="sidebar-heading">
                Animal
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="animalProfileV2.php" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="fas fa-paw"></i>
                    <span>Animal Profile</span>
                </a>

                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Animal Profile</h6>
                        <a class="collapse-item" href="buttons.html">Animal Profile</a>
                        <a class="collapse-item" href="cards.html">Adoption</a>
                    </div>
                </div>
            </li> -->

            <!-- Nav Item - Animal Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Animal</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Animal History</h6>
                        <a class="collapse-item" href="animalProfileV2.php">Animal Profile</a>
                        <a class="collapse-item" href="adopt.php">Adoption</a>
                        <a class="collapse-item" href="#"></a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
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
                    <form
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
                    </form>

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
                            <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-shopping-cart"></i>
                                <!-- Counter - Shopping Cart  -->
                                <span class="badge badge-danger badge-counter" id="cartItemCount">0</span>
                            </a>
                            <!-- Dropdown - Shopping Cart  -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="cartDropdown">
                                <h6 class="dropdown-header">
                                    SHELTER SHOP
                                </h6>
                                <div id="cartItems">
                                    <!-- Cart items will be dynamically added here -->
                                </div>
                                <a class="dropdown-item text-center small text-gray-500" id="checkoutButton" href="#">Go to Shop</a>
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
                <main class="container"> 
                    <section> 
                        <h2>Products</h2> 
                        <div class="row product-list"> 
                            <div class="col-12 col-md-6 product"> 
                                <div class="card"> 
                                    <!-- <h3>Hat</h3>  -->
                                    <div id="carouselHat" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="hat1.jpg" class="d-block w-100" alt="Hat image 1">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="hat2.jpg" class="d-block w-100" alt="Hat image 2">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="hat3.jpg" class="d-block w-100" alt="Hat image 3">
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselHat" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselHat" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a><br>
                                    </div>
                                        <p style="text-align: center; font-size: 20px; font-weight: bold;"><span>₱350.00</span></p> 
                                        <p style="text-align: center; font-size: 18px;">SECASPI Caps</p> 
                                        <form method="post" action="shop.php"> 
                                            <input type="hidden" 
                                                name="product_id" 
                                                value="2"> 
                                            <!-- <label for="product2_quantity"> 
                                                Quantity: <input type="number" 
                                                id="product2_quantity" 
                                                name="product_quantity" 
                                                value="" 
                                                min="0" 
                                                max="10">  </label> <br> -->
                                            <div class="button-container">
                                                <button type="button" class="btn btn-custom add-to-cart" data-id="2" data-name="SECASPI Caps" data-price="350" data-colors='["hat1.jpg", "hat2.jpg", "hat3.jpg"]'>
                                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                                </button>
                                            </div>
                                        </form> 

                                    </div> 
                                    
                            </div> 

                            <div class="col-12 col-md-6 product"> 
                                <div class="card"> 
                                    <!-- <h3>Tote Bag</h3>  -->
                                    <div id="carouselBag" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="bag1.jpg" class="d-block w-100" alt="Bag image 1">
                                            </div>
                                        </div><br>
                                    </div> 
                                    <p style="text-align: center; font-size: 20px; font-weight: bold;"><span>₱100.00</span></p> 
                                    <p style="text-align: center; font-size: 18px;">Tote Bag</p>
                                    <form method="post" action="shop.php"> 
                                        <input type="hidden" 
                                            name="product_id" 
                                            value="1"> 
                                        <!-- <label for="product1_quantity"> 
                                            Quantity: <input type="number" 
                                            id="product1_quantity" 
                                            name="product_quantity" 
                                            value="" 
                                            min="0" 
                                            max="10">  </label> <br>  -->
                                        <div class="button-container">
                                            <button type="button" class="btn btn-custom add-to-cart" data-id="1" data-name="Tote Bag" data-price="100" data-colors='["bag1.jpg"]'>
                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                            </button>
                                        </div>
                                    </form> 
                                </div> 
                            </div> 
                        </div> 
                    </section> 
                </main>

                <!-- modal for add to cart  -->
                <div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="addToCartModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="product-details">
                                    <img id="modalProductImage" src="" class="img-fluid" alt="Product Image">
                                    <h5 id="modalProductName"></h5>
                                    <p id="modalProductPrice" class="font-weight-bold"></p>
                                    <form id="modalAddToCartForm" method="post" action="shop.php">
                                        <input type="hidden" name="product_id" id="modalProductId">
                                        <div class="form-group" id="colorSelection">
                                            <label for="modalProductColor">Color:</label>
                                            <select id="modalProductColor" name="product_color" class="form-control">
                                                <!-- Color options will be dynamically added here -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="modalProductQuantity">Quantity:</label>
                                            <input type="number" id="modalProductQuantity" name="product_quantity" class="form-control" value="1" min="1" max="10">
                                        </div>
                                        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        

                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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


        <!-- <script>
            $(document).ready(function() {
                let cart = [];

                $('.add-to-cart').on('click', function() {
                    // Get product details from the button's data attributes
                    var productId = $(this).data('id');
                    var productName = $(this).data('name');
                    var productPrice = $(this).data('price');
                    var productColors = $(this).data('colors');

                    // Populate the modal with the product details
                    $('#modalProductId').val(productId);
                    $('#modalProductName').text(productName);
                    $('#modalProductPrice').text(productPrice);

                    // Populate color options or hide the color selection if only one option
                    if (productColors.length > 1) {
                        var colorOptions = '';
                        productColors.forEach(function(color) {
                            var colorName = color.split('.')[0]; // Assuming the filename describes the color
                            colorOptions += `<option value="${color}">${colorName}</option>`;
                        });
                        $('#modalProductColor').html(colorOptions).show();
                        $('#colorSelection').show();
                    } else {
                        $('#modalProductColor').html(`<option value="${productColors[0]}">${productColors[0].split('.')[0]}</option>`).show();
                        $('#colorSelection').hide();
                        $('#modalProductImage').attr('src', productColors[0]);
                    }

                    // Set the initial product image to the first color
                    $('#modalProductImage').attr('src', productColors[0]);

                    // Update the product image when a new color is selected
                    $('#modalProductColor').off('change').on('change', function() {
                        var selectedColor = $(this).val();
                        $('#modalProductImage').attr('src', selectedColor);
                    });

                    // Show the modal
                    $('#addToCartModal').modal('show');
                });

                // Handle the form submission within the modal
                $('#modalAddToCartForm').on('submit', function(event) {
                    event.preventDefault(); // Prevent the form from submitting traditionally

                    // Get the product details from the modal
                    var productId = $('#modalProductId').val();
                    var productName = $('#modalProductName').text();
                    var productPrice = $('#modalProductPrice').text();
                    var productColor = $('#modalProductColor').val();
                    var productQuantity = $('#modalProductQuantity').val();

                    // Add product to the cart array
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        color: productColor,
                        quantity: productQuantity
                    });

                    // Update the cart item count
                    $('#cartItemCount').text(cart.length);

                    // Update the cart dropdown items
                    updateCartDropdown();

                    // Hide the modal
                    $('#addToCartModal').modal('hide');
                });

                // Function to update the cart dropdown items
                function updateCartDropdown() {
                    var cartItemsContainer = $('#cartItems');
                    cartItemsContainer.empty();

                    cart.forEach(function(item, index) {
                        var itemHtml = `
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-box text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-weight-bold">${item.name}</div>
                                    <div class="small text-gray-500">${item.price} x ${item.quantity}</div>
                                </div>
                            </a>`;
                        cartItemsContainer.append(itemHtml);
                    });
                }

                // Handle the click event on the "Go to Shop" button
                $('#checkoutButton').on('click', function(event) {
                    event.preventDefault();
                    // Redirect to the shop page
                    window.location.href = 'shelterShop.php';
                });
            });




        </script> -->
        
        <script>
            $(document).ready(function() {
                // Function to update the cart count
                function updateCartCount() {
                    $.ajax({
                        url: 'cartCount.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#cartItemCount').text(data.cart_count);
                        }
                    });
                }

                // Function to update the cart items
                function updateCartItems() {
                    $.ajax({
                        url: 'getCartItems.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            var cartItemsHtml = '';
                            data.forEach(function (item) {
                                cartItemsHtml += `<div class="dropdown-item">
                                                    <img src="${item.productImage}" alt="${item.productName}" class="mr-3" style="width: 50px;">
                                                    <div>
                                                        <strong>${item.productName}</strong>
                                                        <span class="text-muted">${item.productQuantity} x $${item.productPrice}</span>
                                                    </div>
                                                </div>`;
                            });
                            $('#cartItems').html(cartItemsHtml);
                        }
                    });
                }

                // Initial load of cart count
                updateCartCount();
                updateCartItems();


                $('.add-to-cart').on('click', function() {
                    // Get product details from the button's data attributes
                    var productId = $(this).data('id');
                    var productName = $(this).data('name');
                    var productPrice = $(this).data('price');
                    var productColors = $(this).data('colors');

                    // Populate the modal with the product details
                    $('#modalProductId').val(productId);
                    $('#modalProductName').text(productName);
                    $('#modalProductPrice').text(productPrice);

                    // Populate color options or hide the color selection if only one option
                    if (productColors.length > 1) {
                        var colorOptions = '';
                        productColors.forEach(function(color) {
                            var colorName = color.split('.')[0]; // Assuming the filename describes the color
                            colorOptions += `<option value="${color}">${colorName}</option>`;
                        });
                        $('#modalProductColor').html(colorOptions).show();
                        $('#colorSelection').show();
                    } else {
                        $('#modalProductColor').html(`<option value="${productColors[0]}">${productColors[0].split('.')[0]}</option>`).show();
                        $('#colorSelection').hide();
                        $('#modalProductImage').attr('src', productColors[0]);
                    }

                    // Set the initial product image to the first color
                    $('#modalProductImage').attr('src', productColors[0]);

                    // Update the product image when a new color is selected
                    $('#modalProductColor').off('change').on('change', function() {
                        var selectedColor = $(this).val();
                        $('#modalProductImage').attr('src', selectedColor);
                    });

                    // Show the modal
                    $('#addToCartModal').modal('show');
                });

                // Handle the form submission within the modal
                $('#modalAddToCartForm').on('submit', function(event) {
                    event.preventDefault(); // Prevent the form from submitting traditionally

                    // Get the product details from the modal
                    var productId = $('#modalProductId').val();
                    var productName = $('#modalProductName').text();
                    var productPrice = $('#modalProductPrice').text();
                    var productColor = $('#modalProductColor').val();
                    var productQuantity = $('#modalProductQuantity').val();

                    // AJAX request to add the product to the cart
                    $.ajax({
                        url: 'addToCart.php',
                        method: 'POST',
                        data: {
                            productName: productName,
                            productColor: productColor,
                            productQuantity: productQuantity,
                            productPrice: productPrice
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Update the cart item count
                                updateCartCount();
                                // Hide the 
                                updateCartItems();
                                $('#addToCartModal').modal('hide');
                            } else {
                                alert('There was an error adding the item to the cart.');
                            }
                        }
                    });
                });

                // Handle the click event on the "Go to Cart" button
                $('#checkoutButton').on('click', function(event) {
                    event.preventDefault();
                    // Redirect to the shop page
                    window.location.href = 'shop.php';
                });
            });
        </script>


</body>
</html>