<?php
    session_start();
    include 'connection.php';

    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        header('location: loginV2.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>User Profile</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            /* margin: 10px; */
            /* text-align: center; */
        }
    
        .modal-title {
            text-align: center;
            width: 100%;
        }

        .custom-modal-lg {
            max-width: 40%;     
            margin: auto;
            margin-top: 40px !important;
        }

        /* Media query for medium-sized screens (tablets) */
        @media (max-width: 992px) {
            .custom-modal-lg {
                max-width: 600px; /* Adjust max-width for medium screens */
            }
        }

        /* Media query for small-sized screens (phones) */
        @media (max-width: 768px) {
            .custom-modal-lg {
                max-width: 90%; /* Set modal width to 90% of viewport width */
            }
        }

        .center-btn {
            display: flex;
            justify-content: center;
        }

        .sidepanel {
            width: 0; 
            position: fixed;
            z-index: 1;
            height: 100vh;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            text-align: center;
        }

        .sidepanel a {
            padding: 8px 8px 8px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidepanel a:hover {
            color: #f1f1f1;
        }

        .sidepanel a.active {
            background-color: yellow; /* Change to desired active link background color */
        }

        .sidepanel .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: black;
            color: white;
            padding: 15px; 
            margin: 0;
            border: none;
            height: 8vh; 
            position: fixed;
            top: 0; 
            left: 0; 
            display: inline-block;
            transition: transform 0.3s ease; 
        }

        .openbtn:hover {
            background-color: #444;
        }

        .header {
            width: 100%;
            background-color: black;
            height: 8vh;
            display: flex;
            justify-content: flex-end; /* Aligns children to the right */            
            box-sizing: border-box; 
            position: fixed;
            z-index: 1;
        }

        .dropbtn {
            background-color: #3498DB;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 100px;
            cursor: pointer;
            z-index: 999;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #2980B9;
        }

        .dropdown {
            position: fixed;
            display: inline-block;
            margin: 10px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
            text-align: center;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {background-color: #ddd;}

        .show {display: block;}

        .dropdown i {
            padding: 0px;
        }

        h3 {
            color: white;
            margin-top: 20px !important;
            margin: 10px;   
            font-size: 16px;
            position: fixed;
            display: inline-block;
        }

        .user-name {
            font-size: 18px;
            color: white;
            font-weight: bold;
        }

        .profileBtn {
            padding: 5px 10px !important;
            margin-top: 7px;
            margin-left: 48px;
            font-size: 12px !important;
            background-color: none; 
            color: #fff; 
            text-decoration: none; 
            border-radius: 20px; 
            border: 1px solid white;
            font-weight: none;
            width: 60%;
            transition: background-color 0.3s ease; 
        }

        .profileBtn:hover {
            background-color: #0056b3; /* Darker blue on hover */
            color: white;
        }

        .userNav .profileBtn {
            text-align: center !important;
        }
        
    </style>
</head>
<body>
    <div class="header">
        <h3>hi, <span class=""><?php echo $firstName; ?></span></h3>
        <button class="openbtn" onclick="toggleNav()">☰</i></button>
                <!-- <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn"><i class="fa-solid fa-user"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="#home">Home</a>
                        <a href="#about">About</a>
                        <a href="#contact">Contact</a>
                    </div>
                </div> -->
            <!-- </div> -->

        <div id="mySidepanel" class="sidepanel">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                
            <div class="userNav">
                <span class="user-name">
                    <i class="fas fa-user"></i><br>
                    <?php echo $firstName . ' ' . $lastName; ?>

                    <a href="userProfile.php" class="profileBtn">Manage Profile</a><br><br>
                </span>
            </div>


            <a href="dashboard.php" onclick="setActiveLink(this)">Home</a>
            <a href="adoptionPage.php" onclick="setActiveLink(this)">Adopt</a>
            <a href="#" onclick="setActiveLink(this)">Clients</a>
            <a href="#" onclick="setActiveLink(this)">Contact</a>
            <a href="" onclick="setActiveLink(this)">Logout</a>   
        </div>
    </div>
    
<!-- Profile image container with default avatar icon -->
<div class="profile-image-container">
    <!-- Profile image (hidden by default) -->
    <img id="profileImage" class="profile-image" src="placeholder.jpg" alt="Profile Image">

    <!-- Avatar icon (visible when no image is displayed) -->
    <i id="avatarIcon" class="avatar-icon fas fa-user-circle"></i>
</div>
    <!-- user profile  -->
        <?php
            include 'connection.php';
            // session_start();

            // Check if all required session variables are set
            if(!isset($_SESSION['userId']))
            {
                header('location:loginV2.php');
                exit(); // Ensure to exit after redirection
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
            <div class="card mb-4">
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
                <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Follow</button>
                <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Message</button>
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



            <!-- <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 mb-md-0">
                <div class="card-body">
                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                    </p>
                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                    <div class="progress rounded mb-2" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                </div> -->
            </div>
            <!-- <div class="col-md-6">
                <div class="card mb-4 mb-md-0">
                <div class="card-body">
                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                    </p>
                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                    <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                    <div class="progress rounded mb-2" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                </div>
            </div> -->
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg custom-modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update <strong><?php echo $_SESSION['user_name'] ?></strong>'s Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    <form action="updateInsert.php" method="POST">
                        <label for="firstName"><strong>First Name</strong></label>
                        <input type="text" name="firstName" class="form-control" value="<?php echo htmlspecialchars($firstName); ?>"><br>

                        <label for="lastName"><strong>Last Name</strong></label>
                        <input type="text" name="lastName" class="form-control" value="<?php echo htmlspecialchars($lastName); ?>"><br>

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
    
    <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
                }
            }
        }
        function toggleNav() {
            var sidePanel = document.getElementById("mySidepanel");
            if (sidePanel.style.width === "250px") {
                sidePanel.style.width = "0";
            } else {
                sidePanel.style.width = "250px";
            }
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        function setActiveLink(clickedLink) {
            // Add active class to the clicked link
            var links = document.getElementsByTagName("a");
            for (var i = 0; i < links.length; i++) {
                links[i].classList.remove("active");
            }
            clickedLink.classList.add("active");
        }

        // Set active link when the page loads
        window.onload = function () {
            var currentUrl = window.location.href;
            var links = document.getElementsByTagName("a");

            for (var i = 0; i < links.length; i++) {
                if (links[i].href === currentUrl) {
                    links[i].classList.add("active");
                    break; // Stop after finding the current link
                }
            }
            
        };
    </script>



</body>
</html>
