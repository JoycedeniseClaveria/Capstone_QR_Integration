<?php 
include 'connection.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['userId'])) {
    header('location:login.php');
    exit();
}

// Initialize variables
$firstName = '';
$lastName = '';
$email = '';
$contactNo = '';
$location = '';

// Retrieve user info
$userId = $_SESSION['userId'];
$query = "SELECT firstName, lastName, emailAddress, contactNo, location FROM users WHERE userId = ?";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    // Bind parameter (userId)
    mysqli_stmt_bind_param($stmt, "i", $userId);

    if (mysqli_stmt_execute($stmt)) {
        // Bind results
        mysqli_stmt_bind_result($stmt, $firstName, $lastName, $emailAddress, $contactNo, $location);
        mysqli_stmt_fetch($stmt);
    } else {
        echo "Error executing SQL statement: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing SQL statement: " . mysqli_error($conn);
}

// Filters for animals
$speciesFilter = isset($_GET['species']) ? $_GET['species'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM animal WHERE 1";

// Apply filters
if (!empty($speciesFilter)) {
    $sql .= " AND species = '" . mysqli_real_escape_string($conn, $speciesFilter) . "'";
}

if (!empty($statusFilter)) {
    $sql .= " AND status = '" . mysqli_real_escape_string($conn, $statusFilter) . "'";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <link rel="stylesheet" href="adoptstyle.css">

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
                                        <!-- <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div> -->
                                    </div>
                                    <div>
                                        <!-- <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span> -->
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
                
                <div class="container-fluid" id="grad1">
  <div class="row justify-content-center mt-0 no-gutters align-items-start custom-row">
    
    <!-- Card (left) -->
    <div class="col-auto">
      <div class="card1" id="animalCard">
        <img id="animalImage" src="" alt="Animal Image" class="card-img">
        <div class="card-body">
          <h3 id="animalName"></h3>
          <p id="gender"></p>
          <p id="status"></p>
          <p id="age"></p>
        </div>
      </div>
    </div>

                <!-- MultiStep Form -->

                <?php 
                require 'connection.php';

                if (isset($_POST["submitAdoption"])) {
                    $icon = 'info'; // Example value
                    $title = 'Confirmation'; // Example value
                    $text = 'Are you sure about you adopted?'; // Example value
                
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('msform').addEventListener('submit', function(event) {
                                event.preventDefault(); // Prevent form submission
                                
                                Swal.fire({
                                    icon: '{$icon}',
                                    title: '{$title}',
                                    text: '{$text}',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, I am sure',
                                    cancelButtonText: 'No, cancel',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Proceed with form submission
                                        this.submit();
                                    } else {
                                        // User cancelled the submission
                                        Swal.fire('Cancelled', 'Your adoption process has been cancelled.', 'error');
                                    }
                                });
                            });
                        });
                    </script>";

                // if (isset($_POST["submitAdoption"])) {
                    // Validate and sanitize form inputs
                    $animalName = $_POST["animalName"] ?? '';
                    $applicationDate = $_POST["applicationDate"] ?? '';
                    $name = $_POST["name"] ?? '';
                    $age = $_POST["age"] ?? '';
                    $emailAddress = $_POST["emailAddress"] ?? '';
                    $location = $_POST["location"] ?? '';
                    $contactNo = $_POST["contactNo"] ?? '';
                    $profession = $_POST["profession"] ?? '';
                    $fbName = $_POST["fbName"] ?? '';
                    $fbLink = $_POST["fbLink"] ?? '';
                    $data1 = $_POST["data1"] ?? '';
                    $data2 = $_POST["data2"] ?? '';
                    $data3 = $_POST["data3"] ?? '';
                    $data4 = $_POST["data4"] ?? '';
                    $data5 = $_POST["data5"] ?? '';
                    $data6 = $_POST["data6"] ?? '';
                    $data7 = $_POST["data7"] ?? '';
                    $data8 = $_POST["data8"] ?? '';
                    $data9 = $_POST["data9"] ?? '';
                    $data10 = $_POST["data10"] ?? '';
                    $data11 = $_POST["data11"] ?? '';
                    $data12 = $_POST["data12"] ?? '';
                    $data13 = $_POST["data13"] ?? '';
                    $data14 = $_POST["data14"] ?? '';
                    $data15 = $_POST["data15"] ?? '';
                    $data16 = $_POST["data16"] ?? '';
                    $data17 = $_POST["data17"] ?? '';
                    $data18 = $_POST["data18"] ?? '';
                    $data19 = $_POST["data19"] ?? '';
                    $data20 = $_POST["data20"] ?? '';
                    $data21 = $_POST["data21"] ?? '';
                    $data22 = $_POST["data22"] ?? '';
                    $data23 = $_POST["data23"] ?? '';
                    $data24 = $_POST["data24"] ?? '';
                    $data25 = $_POST["data25"] ?? '';
                    $data26 = $_POST["data26"] ?? '';
                    $data27 = $_POST["data27"] ?? '';
                    $data28 = $_POST["data28"] ?? '';
                    $data29 = $_POST["data29"] ?? '';
                    $data30 = $_POST["data30"] ?? '';
                    $data31 = $_POST["data31"] ?? '';
                    $checkbox = $_POST["checkbox"] ?? '';

                    // Prepare and bind
                    if ($stmt = $conn->prepare("INSERT INTO adoption (animalName, applicationDate, name, age, emailAddress, location, contactNo, profession, fbName, fbLink, data1, data2, data3, data4, data5, data6, data7, data8, data9, data10, data11, data12, data13, data14, data15, data16, data17, data18, data19, data20, data21, data22, data23, data24, data25, data26, data27, data28, data29, data30, data31, checkbox) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                        $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssss", 
                            $animalName, $applicationDate, $name, $age, $emailAddress, $location, 
                            $contactNo, $profession, $fbName, $fbLink, $data1, $data2, $data3, 
                            $data4, $data5, $data6, $data7, $data8, $data9, $data10, $data11, 
                            $data12, $data13, $data14, $data15, $data16, $data17, $data18, 
                            $data19, $data20, $data21, $data22, $data23, $data24, $data25, 
                            $data26, $data27, $data28, $data29, $data30, $data31, $checkbox
                        );

                       // Execute the prepared statement
                        if ($stmt->execute()) {
                            // Insertion successful
                            echo "<script>
                                Swal.fire('Success!', 'Animal adoption details saved successfully.', 'success').then(() => {
                                    window.location.href = 'adoptionHistory.php'; // Redirect to another page after success
                                });
                            </script>";
                        } else {
                            // Insertion failed
                            echo "<script>Swal.fire('Error', 'Failed to save adoption details. Error: " . $stmt->error . "', 'error');</script>";
                        }

                        // Close the prepared statement
                        $stmt->close();
                    } else {
                        // Error preparing SQL statement
                        echo "<script>alert('Error', 'Failed to prepare the SQL statement. Error: " . $conn->error . "', 'error');</script>";
                    }

                    // Close the database connection
                    $conn->close();
                }
                ?>
  <div class="col">
      <div class="card px-3 pt-4 pb-0 mt-3 mb-3">
        <h2 style="font-size: 22px; text-transform: uppercase;"><strong>Adoption Application</strong></h2>
        <h2 style="font-size: 20px;"><strong>Second Chance Aspin Shelter Philippines, Inc.</strong></h2>
        <p style="text-align: justify;">
          Please fill in with correct information. Make sure that you will enter your active e-mail and mobile numbers. 
          Take note that personal information is vital for the process of your adoption.
        </p>
        <form id="msform" method="POST" enctype="multipart/form-data" action="">
          <ul id="progressbar">
            <li class="active" id="account"><strong>Personal Info</strong></li>
            <li id="personal"><strong>Adoption Info</strong></li>
            <li id="payment"><strong>Additional Requirements</strong></li>
            <li id="confirm"><strong>Finish</strong></li>
          </ul>

<fieldset> 
    <div class="form-card">
        <label for="animalName">Animal Name: <span class="required">*</span></label>
        <input type="text" name="animalName" id="animalNameInput" placeholder="" readonly required>
        
        <!-- ✅ Date auto-generated -->
        <label for="applicationDate">Date of Application: <span class="required">*</span></label>
        <input type="text" name="applicationDate" 
               value="<?php echo date('Y-m-d'); ?>" 
               readonly required/>

        <!-- ✅ Auto-filled Name -->
        <label for="name">Name: <span class="required">*</span></label>
        <input type="text" name="name" 
               value="<?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>" 
               readonly required/>

        <label for="age">Age: <span class="required">*</span></label>
        <input type="text" name="age" placeholder="" required/>

        <!-- ✅ Auto-filled Email -->
        <label for="emailAddress">Email Address: <span class="required">*</span></label>
        <input type="email" name="emailAddress" 
               value="<?php echo htmlspecialchars($emailAddress); ?>" 
               readonly required/>
        
        <label for="location">Address: <span class="required">*</span></label>
<input type="text" name="location" 
       value="<?php echo htmlspecialchars($location); ?>" 
       readonly required/>
        <label for="contactNo">Contact Number/s: <span class="required">*</span></label>
        <input type="tel" name="contactNo"  
               value="<?php echo htmlspecialchars($contactNo); ?>" 
               readonly required/>
        <span id="contactError" style="color: red; display: none;">Invalid contact number!</span>

        <label for="profession">What is your profession? (Please put if you are still a student and what grade level) <span class="required">*</span></label>
        <input type="text" name="profession" placeholder="" required/>

        <label for="fbName">Facebook Profile Name <span class="required">*</span></label>
        <input type="text" name="fbName" placeholder="" required/>

        <label for="fbLink">Facebook Profile Link <span class="required">*</span></label>
        <input type="text" name="fbLink" placeholder="" required/>
    </div>
    <input type="button" name="next" class="next action-button" value="Next"/>
</fieldset>

                                            <fieldset>
    <div class="form-card">
        <label for="data1">Why did you decide to adopt an animal? <span class="required">*</span></label>
        <input type="text" name="data1" placeholder="" required/>

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data2">Have you adopted from us before? <span class="required">*</span></label>
                <select class="list-dt" id="data2" name="data2" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <label for="data3">If YES, when? (put N/A if otherwise)</label>
        <input type="text" name="data3" placeholder="e.g. June 2024 or N/A" class="form-control" />

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data4">What type of residence do you live in? <span class="required">*</span></label>
                <select class="list-dt" id="data4" name="data4" required>
                    <option value="" disabled selected></option>
                    <option value="Condominium">Condominium</option>
                    <option value="Apartment">Apartment</option>
                    <option value="Detached House (with fence/gate)">Detached House (with fence/gate)</option>
                    <option value="Detached House (without fence/gate)">Detached House (without fence/gate)</option>
                    <option value="Townhouse (with fence/gate)">Townhouse (with fence/gate)</option>
                    <option value="Townhouse (without fence/gate)">Townhouse (without fence/gate)</option>
                </select>
            </div>
        </div><br>

        <label for="data5">Is the residence for RENT? If YES, please secure a written letter from your landlord that pets are allowed. (put N/A if otherwise)</label>
        <input type="file" name="data5" placeholder=""/>

        <label for="data6">Who do you live with? Please be specific. <span class="required">*</span></label>
        <input type="text" name="data6" placeholder="" required/>

        <label for="data7">How long have you lived in the address registered here? <span class="required">*</span></label>
        <input type="text" name="data7" placeholder="" required/>

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data8">Are you planning to move in the next six (6) months? <span class="required">*</span></label>
                <select class="list-dt" id="data8" name="data8" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <label for="data9">If YES, where? Please leave a specific address. (put N/A if otherwise)</label>
        <input type="text" name="data9" placeholder="" />

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data10">Will the whole family be involved in the care of the animal? <span class="required">*</span></label>
                <select class="list-dt" id="data10" name="data10" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <label for="data11">If NO, please explain. (put N/A if otherwise)</label>
        <input type="text" name="data11" placeholder="" />

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data12">Is there anyone in your household who has objection(s) to the arrangement? <span class="required">*</span></label>
                <select class="list-dt" id="data12" name="data12" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <label for="data13">If YES, please explain. (put N/A if otherwise)</label>
        <input type="text" name="data13" placeholder="" />

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data14">Are there any children who visit your home frequently? <span class="required">*</span></label>
                <select class="list-dt" id="data14" name="data14" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data15">Are there any other regular visitors in your home which your new companion (dog) must get along? <span class="required">*</span></label>
                <select class="list-dt" id="data15" name="data15" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data16">Are there any members of your household who have an allergy to cats and dogs? <span class="required">*</span></label>
                <select class="list-dt" id="data16" name="data16" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <label for="data17">If YES, who? (put N/A if otherwise)</label>
        <input type="text" name="data17" placeholder="" />

        <label for="data18">What will happen to this animal if you have to move unexpectedly? <span class="required">*</span></label>
        <input type="text" name="data18" placeholder="" required/>

        <label for="data19">What kind of behavior(s) of the dog do you feel you will be unable to accept? <span class="required">*</span></label>
        <input type="text" name="data19" placeholder="" required/>

        <label for="data20">How many hours in an average work day will your companion animal spend without a human? <span class="required">*</span></label>
        <input type="text" name="data20" placeholder="" required/>

        <label for="data21">What will happen to your companion animal when you go on vacation or in case of emergency? <span class="required">*</span></label>
        <input type="text" name="data21" placeholder="" required/>

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data22">Do you have a regular veterinarian? <span class="required">*</span></label>
                <select class="list-dt" id="data22" name="data22" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <label for="data23">If YES, please provide these information: Name, Address and Contact Number (put N/A if otherwise)</label>
        <input type="text" name="data23" placeholder="" />

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data24">Do you have other companion animals? <span class="required">*</span></label>
                <select class="list-dt" id="data24" name="data24" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div><br>

        <label for="data25">If YES, please specify what type and the total number. (put N/A if otherwise)</label>
        <input type="text" name="data25" placeholder="" />

        <div class="row">
            <div class="col-12">
                <label class="pay" for="data26">In which part of the house will the animal stay? <span class="required">*</span></label>
                <select class="list-dt" id="data26" name="data26" required>
                    <option value="" disabled selected></option>
                    <option value="Inside the house ONLY">Inside the house ONLY</option>
                    <option value="Inside/Outside the house">Inside/Outside the house</option>
                    <option value="Outside the house ONLY">Outside the house ONLY</option>
                </select>
            </div>
        </div><br>

        <label for="data27">Where will this animal be kept during the day and during night? Please specify. <span class="required">*</span></label>
        <input type="text" name="data27" placeholder="" required/>

        <label for="data28">Do you have a fenced yard? If YES, please specify the height and type. (put N/A if otherwise)</label>
        <input type="text" name="data28" placeholder="" />

        <label for="data29">If NO fence, how will you handle the dog's exercise and toilet duties? (put N/A if otherwise)</label>
        <input type="text" name="data29" placeholder="" />

        <label for="data30">If adopting a cat, where will be the litter box be kept? (put N/A if otherwise)</label>
        <input type="text" name="data30" placeholder="" />
    </div>

    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
    <input type="button" name="next" class="next action-button" value="Next"/>
</fieldset>

                                            <fieldset>
                                                <div class="form-card">
                                                    
                                                    <h2 style="font-size: 16px; text-align: center; font-weight: bold;">Second Chance Aspin Shelter Philippines, Inc. reserves the right to refuse an adoption.</h2>
                                                    <!-- <h2 class="fs-title">Valid ID</h2> --><br><br>

                                                    <label for="validId">Valid ID (Upload or Take Photo)</label>
<input
  type="file"
  name="data31"
  id="validId"
  accept="image/*,.pdf"
  capture="environment"
  required
/>
<img id="idPreview" style="max-width: 100%; margin-top: 10px;" />

                                                    <h2 style="font-size: 14px;">
                                                        Please secure the following requirements:<br>
                                                            1. Government Issued and company ID<br>
                                                            2. A copy of the signature above the printed name on a sheet of paper (scanned/photo)<br><br>

                                                            FOR APPLICANTS BELOW 18  YEARS OLD:<br>
                                                            1. School ID<br>
                                                            2. Birth <br>
                                                            3. Parent's/Guardian's government-issued ID<br>
                                                            4. A copy of the signature above the printed name of the parent/guardian on a sheet of paper (scanned/photo)<br></h2>
                                                </div>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                                <input type="button" name="next" class="next action-button" value="Next"/>
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <label for="checkbox">I certify that the above information is true and understand that false information may result in automatic nullification of my proposed adoption. <span class="required">*</span></label>
                                                    <input type="checkbox" name="checkbox" required/>
                                                </div>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                                <input type="submit" name="submitAdoption" class="next action-button" value="Submit"/>
                                            </fieldset>                           
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include SweetAlert2 JavaScript -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <div class="loading-wrapper">
                    <div class="loading-paw"></div>
                </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <?php
        // Display success message if set in session
        if (isset($_SESSION['success_message'])) {
            alert('Success', $_SESSION['success_message'], 'success');
            unset($_SESSION['success_message']); // Clear the success message after displaying
        }
        ?>


     <div class="modal fade" id="animalModal" tabindex="-1" role="dialog" aria-labelledby="animalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="animalModalLabel"><strong>Help them find a new home!</strong></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid" id="modalContent">
                    <div class="row">
                        <!-- Image Section -->
                        <div class="col-md-4">
                            <img src="" id="animalImage" class="img-fluid rounded" alt="Animal Image">
                            
                        </div>
                        <!-- Animal Details Section -->
                        <div class="col-md-4">
                            <h5 class="modal-section-title">Animal Details</h5>
                            <p><strong>Name:</strong> <span id="animalName"></span></p>
                            <p><strong>Species:</strong> <span id="animalSpecies"></span></p>
                            <p><strong>Gender:</strong> <span id="animalGender"></span></p>
                            <p><strong>Status:</strong> <span id="animalStatus"></span></p>
                            <p><strong>Age:</strong> <span id="animalAge"></span></p>
                            <p><strong>Birthday:</strong> <span id="animalBirthday"></span></p>
                            <p><strong>Intake Type:</strong> <span id="animalIntakeType"></span></p>
                            <p><strong>Intake Date:</strong> <span id="animalIntakeDate"></span></p>
                            <p><strong>Description:</strong> <span id="animalDescription"></span></p>
                        </div>
                        <!-- Medical Info Section -->
                        <div class="col-md-4">
                            <h5 class="modal-section-title">Others</h5>
                            <p><strong>Condition:</strong> <span id="animalCondition"></span></p>
                            <p><strong>Anti Rabies:</strong> <span id="animalAntiRabies"></span></p>
                            <p><strong>5-in-1 Vaccine:</strong> <span id="animalVaccine"></span></p>
                            <p><strong>Neutered:</strong> <span id="animalNeutered"></span></p> 
                            <p><strong>Deticked:</strong> <span id="animalDeticked"></span></p>
                            <p><strong>Dewormed:</strong> <span id="animalDewormed"></span></p>
                            <!-- Add more medical info as needed -->
                        </div>
                    </div><br>
                    <div class="modal-footer">
                        <!-- <a href="adopt.php" type="submit" name="submitAnimal" class="btn btn-secondary">Adopt Now</a> -->
                  
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const queryParams = new URLSearchParams(window.location.search);
            const animalId = queryParams.get('animalId');

            if (animalId) {
                fetch(`getAnimalDetails2.php?animalId=${animalId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            document.getElementById('animalImage').src = data.image;
                            document.getElementById('animalName').textContent = data.animalName;
                            document.getElementById('gender').textContent = `Gender: ${data.gender}`;
                            document.getElementById('status').textContent = `Status: ${data.status}`;
                            document.getElementById('age').textContent = `Age: ${data.age}`;

                            const animalNameInput = document.getElementById('animalNameInput');
                            animalNameInput.value = data.animalName;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to fetch animal details.');
                    });
            } else {
                alert('Invalid animalId.');
            }
        });

        function showAnimalDetails(animalId) {
        // AJAX request to fetch animal details
            $.ajax({
                url: 'getAnimalDetails2.php',
                type: 'GET',
                data: { animalId: animalId },
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    // Populate modal with fetched data
                    $('#animalImage').attr('src', response.image);
                    $('#animalName').text(response.animalName);
                    $('#animalSpecies').text(response.species);
                    $('#animalGender').text(response.gender);
                    $('#animalStatus').text(response.status);
                    $('#animalAge').text(response.age);
                    $('#animalBirthday').text(response.birthday);
                    $('#animalIntakeType').text(response.intakeType);
                    $('#animalIntakeDate').text(response.intakeDate);
                    $('#animalDescription').text(response.description);
                    $('#animalCondition').text(response.conditions);
                    $('#animalAntiRabies').text(response.antiRabies);
                    $('#animalVaccine').text(response.vaccine);
                    $('#animalNeutered').text(response.neutered);
                    $('#animalDeticked').text(response.deticked);
                    $('#animalDewormed').text(response.dewormed);


                    $('#animalModal').modal('show'); // Show the modal
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching animal details:', error);
                    alert('Error fetching animal details.');
                }
            });
        }


        $(document).ready(function(){
    
        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        
 $(".next").click(function () {
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    // Validate all required inputs in the current fieldset
    var isValid = true;

    current_fs.find("input[required], select[required], textarea[required]").each(function () {
        var inputVal = $(this).val().trim();

        // Highlight empty fields
        if ($(this).is(":checkbox") && !$(this).is(":checked")) {
            isValid = false;
            $(this).focus();
            return false;
        } else if (!inputVal) {
            $(this).css("border", "2px solid red");
            isValid = false;
            $(this).focus();
            return false;
        } else {
            $(this).css("border", ""); // Reset border
        }

        // ✅ Philippine Contact Number validation
        if ($(this).attr("name") === "contactNumber") {
            var phRegex = /^(09\d{9}|\+639\d{9})$/;
            if (!phRegex.test(inputVal)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Contact Number',
                    text: 'Please enter a valid Philippine mobile number (e.g. 09171234567 or +639171234567).'
                });
                $(this).css("border", "2px solid red");
                $(this).focus();
                isValid = false;
                return false;
            }
        }
    });

    if (!isValid) {
        // Generic alert (used only if SweetAlert above wasn't triggered)
        return false; // Stop if validation fails
    }

    // Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    // Show the next fieldset
    next_fs.show();

    // Hide the current fieldset with animation
    current_fs.animate({ opacity: 0 }, {
        step: function (now) {
            opacity = 1 - now;
            current_fs.css({ 'display': 'none', 'position': 'relative' });
            next_fs.css({ 'opacity': opacity });
        },
        duration: 600
    });
});

        
        $(".previous").click(function(){
            
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();
            
            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            
            //show the previous fieldset
            previous_fs.show();
        
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;
        
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                }, 
                duration: 600
            });
        });
        
        $('.radio-group .radio').click(function(){
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });
        
        $(".submit").click(function(){
            return false;
        })
            
        });


        // Function to show loading wheel
        function showLoading() {
        document.querySelector('.loading-wrapper').style.display = 'block';
        }

        // Function to hide loading wheel
        function hideLoading() {
        document.querySelector('.loading-wrapper').style.display = 'none';
        }

        // Function to handle homepage link click event
        function handleHomepageLinkClick(event) {
        // Prevent the default action (i.e., following the link immediately)
        event.preventDefault();

        // Show loading wheel
        showLoading();

        // Redirect to the homepage after a delay (simulated redirect)
        setTimeout(function() {
            // Hide loading wheel
            hideLoading();

            // Get the href attribute of the clicked link and navigate to that URL
            window.location.href = event.target.href;
        }, 2000); // Change 2000 to the desired delay in milliseconds
        }

        // Attach click event listener to the homepage link
        document.getElementById('homepageLink').addEventListener('click', handleHomepageLinkClick);



  document.getElementById('validId').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('idPreview').src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      document.getElementById('idPreview').src = '';
    }
  });


        
    </script>



</body>
</html>