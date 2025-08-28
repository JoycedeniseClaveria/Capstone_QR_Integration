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

// Fetch schedules safely
$sched_res = [];
$stmt = $conn->prepare("SELECT * FROM schedule_list WHERE userId = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
    $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
   
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        .badge {
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .badge-pending {
            background-color: yellow;
            color: black;
        }
        .badge-approved {
            background-color: green;
        }
        .badge-disapproved {
            background-color: red;
        }

        .schedule-message {
            font-size: 1.1rem; 
            font-weight: 300; 
            font-family: 'Poppins', 'Segoe UI', sans-serif; 
            color: #000000ff; 
            text-align: center;
            margin-top: 15px;
        }

        .schedule-message .icon {
            font-size: 1.3rem; 
            margin-left: 8px;
        }
   
     @media (max-width: 768px) {
    #page-container {
        margin-bottom: 80px; /* space sa baba pag mobile */
    }
    #calendar {
        min-height: 400px; /* para readable sa maliit na screen */
    }
}


    </style>
</head>

<body class="page-top">




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
                        <li class="nav-item">
                            <a href="#" class="nav-link position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="fas fa-shopping-cart fa-lg text-dark"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    0
                                </span>
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

   <div class="container-fluid py-4" id="page-container">
    <div class="row align-items-stretch"> <!-- para equal height -->
        
        <!-- Calendar Column -->
        <div class="col-lg-6 col-md-12 mb-4">
    <div class="card shadow border-0 rounded-3 w-100">
        <div class="card-header" style="background-color: #36b9cc; color: white;">
            <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Appointment Calendar</h5>
        </div>
        <div class="card-body p-2">
            <div id="calendar"></div>
        </div>
    </div>
</div>


        <!-- Right Side Column (Add Schedule + Table) -->
        <div class="col-lg-6 col-md-12 mb-4 d-flex flex-column">
            
            <!-- Add Schedule Section -->
            <div class="card shadow border-0 rounded-3 mb-4">
                <div class="card-header" style="background-color: #36b9cc; color: white;">
                    <h6 class="mb-0"><i class="fas fa-plus-circle"></i> Add Schedule</h6>
                </div>
                <div class="card-body">
                    <p class="schedule-message">
                        Set your schedule today and drop by the shelter — your future furbaby might be waiting! 
                        <span class="icon">🐶🐱</span>
                    </p>
                    <button type="button" 
                        class="btn mb-3 shadow-sm border-0 d-block mx-auto"  
                        style="background-color: #04505aff; color: #fff;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#scheduleModal">
                        <i class="fas fa-calendar-plus"></i> Create New Schedule
                    </button>
                </div>
            </div>

            <!-- Schedule Table -->
            <div class="card shadow border-0 rounded-3 flex-grow-1">
                <div class="card-header" style="background-color: #36b9cc; color: white;">
                    <h6 class="mb-0"><i class="fas fa-list"></i> My Schedules</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped mb-0">
                            <thead style="background-color: #f8f9fc;">
                                <tr>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sched_res)): ?>
                                    <?php foreach ($sched_res as $schedule): ?>
                                        <tr>
                                            <td>
                                        
                                                <?php 
                                                if ($schedule['status'] == 'Approved') {
                                                    echo '<span class="badge bg-success">Approved</span>';
                                                } elseif ($schedule['status'] == 'Disapproved') {
                                                    echo '<span class="badge bg-danger">Disapproved</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                }
                                                ?>

                                            </td>
                                            <td><?php echo htmlspecialchars($schedule['title']); ?></td>
                                            <td><?php echo htmlspecialchars($schedule['sdate']); ?></td>
                                            <td><?php echo htmlspecialchars($schedule['edate']); ?></td>
                                            <td><a href="delete_schedule.php?id=<?php echo $schedule['id']; ?>" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirmDelete(event)">
                                                <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No schedules found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


    <!-- Schedule Form Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="save_schedule.php" method="post" id="schedule-form">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                        <div class="form-group mb-2">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="control-label">Description</label>
                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="start_datetime" class="control-label">Start</label>
                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="end_datetime" class="control-label">End</label>
                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
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
        <script src="js/main.js"></script>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>

<script>
        // Function to set badge and status text based on event status
        function setBadgeAndStatus(status) {
            var badge = document.getElementById('badge');
  
            badge.classList.remove('bg-success', 'bg-danger', 'bg-warning');
            
            if (status === "Approved") {
                badge.textContent = "Approved";
                badge.classList.add('bg-success');
                statusText.textContent = "Approved";
            } else if (status === "Disapproved") {
                badge.textContent = "Disapproved";
                badge.classList.add('bg-danger');
                statusText.textContent = "Disapproved";
            } else {
                badge.textContent = "Pending";
                badge.classList.add('bg-warning');
                statusText.textContent = "Pending";
            }
        }


        var calendar;
        var Calendar = FullCalendar.Calendar;
        var events = [];
        $(function() {
            if (!!scheds) {
                Object.keys(scheds).map(k => {
                    var row = scheds[k]
                    events.push({ id: row.id, title: row.title, start: row.start_datetime, end: row.end_datetime });
                })
            }
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            calendar = new Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    right: 'dayGridMonth,dayGridWeek,list',
                    center: 'title',
                },
                selectable: true,
                themeSystem: 'bootstrap',
                //Random default events
                events: events,
                eventClick: function(info) {
                    var _details = $('#event-details-modal')
                    var id = info.event.id
                    if (!!scheds[id]) {
                        setBadgeAndStatus(scheds[id].status); // Set badge and status text
                        _details.find('#title').text(scheds[id].title)
                        _details.find('#description').text(scheds[id].description)
                        _details.find('#start').text(scheds[id].sdate)
                        _details.find('#end').text(scheds[id].edate)
                        _details.find('#edit,#delete').attr('data-id', id)
                        _details.modal('show')
                    } else {
                        alert("Event is undefined");
                    }
                },
                eventDidMount: function(info) {
                    // Do Something after events mounted
                },
                editable: true
            });

            calendar.render();

            // Form reset listener
            $('#schedule-form').on('reset', function() {
                $(this).find('input:hidden').val('')
                $(this).find('input:visible').first().focus()
            })

            // Edit Button
            $('#edit').click(function() {
                var id = $(this).attr('data-id')
                if (!!scheds[id]) {
                    var _form = $('#schedule-form')
                    console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"))
                    _form.find('[name="id"]').val(id)
                    _form.find('[name="userId"]').val(userId)
                    _form.find('[name="title"]').val(scheds[id].title)
                    _form.find('[name="description"]').val(scheds[id].description)
                    _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"))
                    _form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"))
                    $('#event-details-modal').modal('hide')
                    _form.find('[name="title"]').focus()
                } else {
                    alert("Event is undefined");
                }
            })

            // Delete Button / Deleting an Event
            $('#delete').click(function() {
                var id = $(this).attr('data-id')
                if (!!scheds[id]) {
                    var _conf = confirm("Are you sure to delete this scheduled event?");
                    if (_conf === true) {
                        location.href = "./delete_schedule.php?id=" + id;
                    }
                } else {
                    alert("Event is undefined");
                }
            })
        })


</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(event) {
    event.preventDefault();
    var url = event.currentTarget.getAttribute('href');

    Swal.fire({
        title: 'Are you sure?',
        text: "This appointment will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

function loadNotifications(){
    $.ajax({
        url: 'fetchNotifications.php',
        method: 'GET',
        dataType: 'json',
        success: function(data){
            $('#notifList').html(data.html);
            $('#notifCount').text(data.count);
            if(data.count == 0) $('#notifCount').hide();
            else $('#notifCount').show();
        }
    });
}

// Load every 10 seconds
setInterval(loadNotifications, 10000);
loadNotifications(); // initial load


$(document).on('click', '#notifList a', function(){
    var href = $(this).attr('href');
    var notifId = href.split('#')[1]; // get notification ID from URL
    if(notifId){
        $.post('markAsRead.php', {id: notifId}, function(){
            loadNotifications();
        });
    }
});

</script>



</body>
</html>