<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$adminId = $_SESSION['userId'];

// Kunin ang info ng naka-login na admin
$query = "SELECT firstName, lastName FROM users WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$stmt->bind_result($firstName, $lastName);
$stmt->fetch();
$stmt->close();

// Kunin lahat ng notifications para sa admin na naka-login
$stmt = $conn->prepare("
    SELECT n.id, n.title, n.message, n.created_at, n.is_read,
           u.firstName, u.lastName
    FROM notifications n
    JOIN users u ON n.senderId = u.userId
    WHERE n.receiverId = ?
    ORDER BY n.created_at DESC
");
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// ✅ Optional: mark all as read kapag na-view na
$conn->query("UPDATE notifications SET is_read = 1 WHERE receiverId = $adminId");
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
    <style>
        #accordionSidebar {
            background-color: #CC7B60 !important;
            background-image: none !important;
        }

        .dropdown-header {
            background-color: #e3896b !important;
            border: #CC7B60 !important;
        }

       #notifList {
  width: 350px;
  max-height: 400px;
  overflow-y: auto;   /* vertical scroll only */
  white-space: normal; /* no horizontal scroll */
  word-wrap: break-word;
  border-radius: 12px; /* round whole dropdown */
}

#notifList .dropdown-header {
  background-color: #e3896b !important;
  color: white;
  border-radius: 12px 12px 0 0; /* round top corners only */
}

#notifList .notif-item {
  display: block;
  padding: 12px;
  border-bottom: 1px solid #f0f0f0;
  transition: background 0.2s;
  text-decoration: none;
}

#notifList .notif-item:hover {
  background: #f9f9f9;
}

#notifList .notif-message {
  font-size: 14px;
  color: #333;
}

#notifList .notif-time {
  font-size: 12px;
  color: gray;
}

#notifList .empty {
  text-align: center;
  padding: 15px;
  color: gray;
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
                    <!-- <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                        <img class="" style="height: 18vh; width: 160px;" src="img/logo.png" alt="Image">
                    </a> -->
                </div>
                <div class="sidebar-brand-text mx-3" style="color: #ffffff; text-transform: none;">SECASPI</div>

                <!-- <div class="sidebar-brand-text mx-3">Finder</div> -->
            </a>

             <!-- Divider -->
             <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="adminHomepage.php">
                    <i class="fa fa-home"></i>
                    <span>Homepage</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

           

            <!-- User Profile  -->
            <li class="nav-item">
                <a class="nav-link" href="userProfileAdmin.php">
                    <i class="fas fa-user-alt"></i>
                    <span>User Profile</span></a>
            </li>

            <!-- Animal Profile -->
            <li class="nav-item">
                <a class="nav-link" href="animalDetailsAdmin.php">
                    <i class="fas fa-paw"></i>
                    <span>Animal Profile</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="adoptionDetailsAdmin.php">
                    <i class="fas fa-calendar"></i>
                    <span>Adoption Management</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="visitationManagement.php">
                    <i class="fas fa-calendar"></i>
                    <span>Visitation Management</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="donation_admin.php">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Donation Management</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="newsfeedManagement.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m18.13 12l1.26-1.26c.44-.44 1-.68 1.61-.74V9l-6-6H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h6v-1.87l.13-.13H5V5h7v7zM14 4.5l5.5 5.5H14zm5.13 9.33l2.04 2.04L15.04 22H13v-2.04zm3.72.36l-.98.98l-2.04-2.04l.98-.98c.19-.2.52-.2.72 0l1.32 1.32c.2.2.2.53 0 .72"/></svg>
                    <span>Newsfeed Management</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="productAdmin.php">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Shelter Shop Management</span></a>
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
                        <i class="fa fa-bars" style="color: #CC7B60;"></i>
                    </button>

                     <!-- Topbar Navbar -->
                     <ul class="navbar-nav ml-auto">

<li class="nav-item dropdown no-arrow mx-1">
  <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
      <i class="fas fa-bell fa-fw"></i>
      <span class="badge bg-danger badge-counter" id="notifCount">0</span>
  </a>
  <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="alertsDropdown" id="notifList">
      <h6 class="dropdown-header">Notifications</h6>
      <div id="notifItems"></div>
      <a class="dropdown-item text-center small text-gray-500" href="#" data-bs-toggle="modal" data-bs-target="#allNotifModal">View All</a>
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

                        <!-- Nav Item - Messages -->
                    

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
                                <a class="dropdown-item" href="updateAdminDetails.php">
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
<!-- Modal for All Notifications -->
<div class="modal fade" id="allNotifModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">All Notifications</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="allNotifBody">
        <!-- Full list will load here via AJAX -->
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

<script>
function loadNotifications() {
    $.getJSON("fetchNotification.php", function(data) {
        $("#notifCount").text(data.unreadCount);
        $("#notifItems").html(data.notificationsHTML);
    });
}

$(document).on("click", ".dropdown-item[data-id]", function(){
    let notifId = $(this).data("id");
    let $item = $(this);

    $.post("updateNotification.php", {id: notifId}, function(res){
        if(res === "success"){
            $item.removeClass("bg-light"); // remove highlight
            let count = parseInt($("#notifCount").text());
            if(count > 0) {
                $("#notifCount").text(count - 1); // minus once
            }
        }
    });
});

// View All -> load all notifications in modal
$('#allNotifModal').on('show.bs.modal', function () {
    $("#allNotifBody").load("viewAllNotifications.php");
});

setInterval(loadNotifications, 1000); 
loadNotifications();

</script>
</body>
</html>