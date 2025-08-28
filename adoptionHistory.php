<?php
    include 'connection.php';
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['userId'])) 
    {
        header('location:login.php');
        exit(); // Ensure to exit after redirection
    }

    // Retrieve user's first name and last name from the database
    $userId = $_SESSION['userId'];
    $query = "SELECT firstName, lastName FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $firstName, $lastName);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt); // Close statement
            } else {
                // Handle SQL execution error
                echo "Error executing SQL statement: " . mysqli_stmt_error($stmt);
            }
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
    <title>Adoption History</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .adoptionTable {
            height: 80vh;
        }
        .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 225px;
    z-index: 1000;
    overflow: hidden;
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

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-paw"></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="color: yellow; text-transform: none;">FurEver Finder</div>
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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top"  style="z-index: 999;">

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
              <!-- Adoption Table Start  -->
               <?php
// Combine first name and last name
$userName = $firstName . ' ' . $lastName;

// Prepare and execute SQL statement
$query = "SELECT * FROM adoption WHERE name = ? ORDER BY adoptionId DESC";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $userName);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        // Table styles
        echo '<style>
            .view-application-link {
                text-decoration: none;
                background-color: #36b9cc;
                border-radius: 5px;
                padding: 8px 12px;
                margin-top: 10px;
                color: white;
                display: inline-block;
                font-size: 0.9rem;
            }
            .view-application-link i {
                margin-left: 5px;
            }
            thead th {
                position: sticky;
                top: 0;
                z-index: 1;
                background-color: #36b9cc;
                color: white;
                text-align: center;
            }
            tbody td {
                text-align: center;
                vertical-align: middle;
            }
            .table-responsive {
                max-height: 550px;
                overflow-y: auto;
            }
            .badge-success { background-color: #28a745; color: white; }
            .badge-warning { background-color: #ffc107; color: black; }
            .badge-danger { background-color: #dc3545; color: white; }
            .badge-secondary { background-color: #6c757d; color: white; }

            /* Responsive adjustments for mobile */
            @media (max-width: 767px) {
                .table thead { display: none; }
                .table tbody td { 
                    display: block;
                    text-align: right;
                    position: relative;
                    padding-left: 50%;
                }
                .table tbody td::before {
                    content: attr(data-label);
                    position: absolute;
                    left: 15px;
                    width: 45%;
                    padding-left: 0;
                    font-weight: bold;
                    text-align: left;
                }
            }
        </style>';

        echo '<div class="container mt-4">';

        // Dropdown for status filter
        echo '<div class="d-flex justify-content-between mb-3">';
        echo '<div class="dropdown">';
        echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status</button>';
        echo '<div class="dropdown-menu" aria-labelledby="statusDropdown">';
        echo '<a class="dropdown-item" href="#" onclick="filterTable(\'\')">All</a>';
        echo '<a class="dropdown-item" href="#" onclick="filterTable(\'Approved\')">Approved</a>';
        echo '<a class="dropdown-item" href="#" onclick="filterTable(\'Pending\')">Pending</a>';
        echo '<a class="dropdown-item" href="#" onclick="filterTable(\'Rejected\')">Rejected</a>';
        echo '</div></div></div>';

        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered">';
        echo '<thead><tr>
                <th>Status</th>
                <th>Animal Name</th>
                <th>Application Date</th>
                <th>Name</th>
                <th>View Your Application</th>
              </tr></thead>';
        echo '<tbody>';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $status = $row["status"] ?? 'Pending';
                $badgeClass = 'badge-warning';

                if ($status === 'Approved') $badgeClass = 'badge-success';
                elseif ($status === 'Rejected') $badgeClass = 'badge-danger';
                elseif ($status === 'Pending' || empty($status)) {
                    $status = 'Pending';
                    $badgeClass = 'badge-warning';
                } else $badgeClass = 'badge-secondary';

                $badgeHtml = '<span class="badge ' . $badgeClass . '">' . htmlspecialchars($status) . '</span>';

                echo '<tr>';
                echo '<td data-label="Status">' . $badgeHtml . '</td>';
                echo '<td data-label="Animal Name">' . htmlspecialchars($row["animalName"]) . '</td>';
                echo '<td data-label="Application Date">' . htmlspecialchars($row["applicationDate"]) . '</td>';
                echo '<td data-label="Name">' . htmlspecialchars($row["name"]) . '</td>';
                echo '<td data-label="View"><a href="#" data-toggle="modal" data-target="#applicationModal" onclick="showAdoptionDetails(' . $row["adoptionId"] . ')" class="view-application-link">View <i class="fas fa-eye"></i></a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5" style="text-align:center;">No Records Found</td></tr>';
        }

        echo '</tbody></table></div></div>'; // Close table-responsive & container
    } else {
        echo '<div class="container mt-5"><div class="alert alert-danger">Error executing SQL: ' . mysqli_stmt_error($stmt) . '</div></div>';
    }
    mysqli_stmt_close($stmt);
} else {
    echo '<div class="container mt-5"><div class="alert alert-danger">Error preparing SQL: ' . mysqli_error($conn) . '</div></div>';
}

mysqli_close($conn);
?>
          <!-- Adoption Table End  -->
            </div>
        </div>
    </div>
    

    <!-- Modal for displaying adoption details -->
    <div class="modal fade" id="applicationModal" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title" id="applicationModalLabel"><strong>Adoption Details</strong></h5><br>
            
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

               <div class="modal-body text-dark">
    <div class="container-fluid">
        <div class="row">
            <!-- Animal Card -->
            <div class="col-md-4">
        <img src="" id="animalImage" class="card-img-top img-fluid rounded" alt="Animal Image">
        <h4 class="fw-bold text-dark mb-2" id="animalName">Animal Name</h4><br>
        <div class="card mb-3 text-dark">
        <div class="card-body text-start">
            <p class="card-text"><strong>Application Date:</strong> <span id="applicationDate" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Name:</strong> <span id="userName" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Age:</strong> <span id="age" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Email:</strong> <span id="emailAddress" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Location:</strong> <span id="location" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Contact No:</strong> <span id="contactNo" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Profession:</strong> <span id="profession" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Facebook Name:</strong> <span id="fbName" class="fw-bold text-dark"></span></p>
            <p class="card-text"><strong>Facebook Link:</strong> <span id="fbLink" class="fw-bold text-dark"></span></p>
        </div>
    </div>
</div>

                            <div class="col-md-8">
                <div class="row">
                    <!-- Left column -->
                    <div class="col-md-6">
                                
                                <p style="text-align: ;"><strong>1. Why did you decide to adopt an animal?</strong><br> <span id="data1" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>2. Have you adopted from us before?</strong><br> <span id="data2" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>3. If YES, when?</strong><br> <span id="data3" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>4. What type of residence do you live in?</strong><br> <span id="data4" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>5. Is the residence for RENT? If YES, please secure a written letter from your landlord that pets are allowed.</strong><br> <span id="data5" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>6. Who do you live with? Please be specific.</strong><br> <span id="data6" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>7. How long have you lived in the address registered here?</strong><br> <span id="data7" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>8. Are you planning to move in the next six (6) months?</strong><br> <span id="data8" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>9. If YES, where? Please leave a specific address.</strong><br> <span id="data9" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>10. Will the whole family be involved in the care of the animal?</strong><br> <span id="data10" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>11. If NO, please explain.</strong><br> <span id="data11" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>12. Is there anyone in your household who has objection(s) to the arrangement?</strong><br> <span id="data12" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>13. If YES, please explain.</strong><br> <span id="data13" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>14. Are there any children who visit your home frequently?</strong><br> <span id="data14" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>15. Are there any other regular visitors on your home which your new companion (dog) must get along?</strong><br> <span id="data15" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                            </div>

                                  <div class="col-md-6">
                                <p style="text-align: ;"><strong>16. Are there any member of your household who has an allergy to cats and dogs?</strong><br> <span id="data16" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>17. If YES, who?</strong><br> <span id="data17" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>18. What will happen to this animal if you have to move unexpectedly?</strong><br> <span id="data18" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>19. What kind of behavior(s) of the dog do you feel you will be unable to accept?</strong><br> <span id="data19" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>20. How many hours in an average work day will your companion animal spend without a human? </strong><br> <span id="data20" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>21. What will happen to your companion animal when you go on vacation or in case of emergency?</strong><br> <span id="data21" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>22. Do you have a regular veterinarian?</strong><br> <span id="data22" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>23. If YES, please provide these information: Name, Address and Contact Number</strong><br> <span id="data23" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>24. Do you have other companion animals?</strong><br> <span id="data24" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>25. If YES, please specify what type and the total number.</strong><br> <span id="data25" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>26. In which part of the house will the animal stay?</strong><br> <span id="data26" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>27. Where will this animal be kept during the day and during night? Please specify.</strong><br> <span id="data27" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>28. Do you have a fenced yard? If YES, please specify the height and type.</strong><br> <span id="data28" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>29. If NO fence, how will you handle the dog's exercise and toilet duties?</strong><br> <span id="data29" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>30. If adopting a cat, where will be the litter box be kept?</strong><br> <span id="data30" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                                <p style="text-align: ;"><strong>31. Upload a Valid ID</strong><br> <span id="data31" style="display: inline-block; padding: 5px; border: 2px solid #ccc; border-radius: 5px; width: 100%;"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function filterTable(status) {
            const rows = document.querySelectorAll('#adoptionTableBody tr');
            rows.forEach(row => {
                const statusBadge = row.querySelector('td .badge').textContent.trim();
                if (status === '' || statusBadge === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function showAdoptionDetails(adoptionId) {
            // AJAX request to fetch adoption details
            $.ajax({
                url: 'getAdoptionDetails.php',
                type: 'GET',
                data: { adoptionId: adoptionId }, // Corrected variable name
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    // Populate modal with fetched data
                    $('#animalImage').attr('src', response.image);
                    $('#animalName').text(response.animalName);
                    $('#applicationDate').text(response.applicationDate);
                    $('#userName').text(response.name);
                    $('#age').text(response.age);
                    $('#emailAddress').text(response.emailAddress);
                    $('#location').text(response.location);
                    $('#contactNo').text(response.contactNo);
                    $('#profession').text(response.profession);
                    $('#fbName').text(response.fbName);
                    $('#fbLink').text(response.fbLink);
                    $('#data1').text(response.data1);
                    $('#data2').text(response.data2);
                    $('#data3').text(response.data3);
                    $('#data4').text(response.data4);
                    $('#data5').text(response.data5);
                    $('#data6').text(response.data6);
                    $('#data7').text(response.data7);
                    $('#data8').text(response.data8);
                    $('#data9').text(response.data9);
                    $('#data10').text(response.data10);
                    $('#data11').text(response.data11);
                    $('#data12').text(response.data12);
                    $('#data13').text(response.data13);
                    $('#data14').text(response.data14);
                    $('#data15').text(response.data15);
                    $('#data16').text(response.data16);
                    $('#data17').text(response.data17);
                    $('#data18').text(response.data18);
                    $('#data19').text(response.data19);
                    $('#data20').text(response.data20);
                    $('#data21').text(response.data21);
                    $('#data22').text(response.data22);
                    $('#data23').text(response.data23);
                    $('#data24').text(response.data24);
                    $('#data25').text(response.data25);
                    $('#data26').text(response.data26);
                    $('#data27').text(response.data27);
                    $('#data28').text(response.data28);
                    $('#data29').text(response.data29);
                    $('#data30').text(response.data30);
                    $('#data31').text(response.data31);



                    // $('#checkbox').text(response.checkbox);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching adoption details:', error);
                    alert('Error fetching adoption details.');
                }
            });
        }


//for notification

    function loadNotifications() {
        $.ajax({
            url: 'getNotifications.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                let notifList = '';
                let counter = data.length;

                if (counter > 0) {
                    $('.badge-counter').text(counter); // show red count
                } else {
                    $('.badge-counter').text('');
                }

                data.forEach(function (notif) {
                    notifList += `
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="font-weight-bold small">${notif.message}</div>
                            <div class="text-gray-500 small ml-2">${notif.createdAt}</div>
                        </a>`;
                });

                $('.dropdown-list[aria-labelledby="alertsDropdown"]').find('.dropdown-item.d-flex').remove(); // clear old
                $('.dropdown-list[aria-labelledby="alertsDropdown"]').prepend(notifList);
            }
        });
    }

    $(document).ready(function () {
        loadNotifications();
        setInterval(loadNotifications, 30000); // optional auto-refresh
    });




    </script>

  
</body>
</html>
