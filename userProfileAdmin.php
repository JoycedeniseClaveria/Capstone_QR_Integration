<?php 
include 'connection.php';
include 'dashboardAdmin.php';

if(!isset($_SESSION['userId'])){
    header('location:login.php');
    exit();
}
?>
<style>
/* General table style */
#usersTable {
    border: 1px solid #CC7B60;
    border-radius: 10px;
    overflow: hidden;
    background-color: #fff;
}

/* Table header */
#usersTable thead {
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Row hover effect */
#usersTable tbody tr:hover {
    background-color: rgba(204, 123, 96, 0.1); /* soft #CC7B60 hover */
    transition: 0.2s ease-in-out;
}

/* Zebra stripe rows */
#usersTable tbody tr:nth-child(even) {
    background-color: #f9f2f0;
}

/* Search bar alignment - always right */
.dataTables_filter {
    text-align: right !important;
    width: 100%;
}
.dataTables_filter label {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 8px;
}
.dataTables_filter input {
    margin-left: 5px;
    border-radius: 5px;
    padding: 5px 10px;
    border: 1px solid #ccc;
    max-width: 200px;
}

/* Add margin below the whole card */
.card {
    margin-bottom: 40px; /* adjust as needed */
}
</style>

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header" style="background-color: #CC7B60; color: white;">
            <h3 class="mb-0">User Profile</h3>
        </div>
        <div class="card-body">
            <!-- Responsive wrapper -->
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover align-middle nowrap" style="width:100%">
                    <thead style="background-color: #313030ff; color: white;">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Contact No</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#usersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "fetchUser.php",
            "type": "POST"
        },
        "pageLength": 10,
        "language": {
            "search": "🔍 Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ users"
        },
        "order": [[0, "asc"]],
        "responsive": true,
        // Custom layout: length menu left, search bar right
        "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rtip'
    });
});
</script>
