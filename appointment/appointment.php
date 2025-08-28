<?php
include 'connection.php';

session_start();

// Check if all required session variables are set
if (!isset($_SESSION['userId'])) {
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

// Fetch schedules for the current user
$schedules = $conn->query("SELECT * FROM `schedule_list` WHERE userId = $userId");
$sched_res = [];
foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
    $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}

// Close the database connection
if (isset($conn)) {
    $conn->close();
}
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: Apple Chancery, cursive;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                    Open Schedule Form
                </button>
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
                    <!-- <button class="btn btn-default border" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <span id="badge" class="badge rounded-pill" style="margin-bottom: 20px; font-size: 14px; margin-left: -5px;">
                            <!-- Badge will be positioned at the top left corner -->
                        </span>
                        <dl>
                            <dt class="text-muted status-label visually-hidden">Status</dt>
                            <dd id="status" class="visually-hidden"></dd>
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <!-- <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button> -->
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <!-- <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

<?php 
// $schedules = $conn->query("SELECT * FROM `schedule_list`");
// $sched_res = [];
// foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
//     $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
//     $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
//     $sched_res[$row['id']] = $row;
// }
?>
<?php 
// if(isset($conn)) $conn->close();
?>
</body>


<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script>
        // Function to set badge and status text based on event status
        function setBadgeAndStatus(status) {
            var badge = document.getElementById('badge');
            var statusText = document.getElementById('status');
            
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

</html>