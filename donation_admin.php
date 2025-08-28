<?php  
session_start();
include 'connection.php'; // adjust path to your db connection
include 'dashboardAdmin.php';

$sql = "SELECT * FROM donations ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Donations</title>
    <!-- SB Admin 2 / Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        /* Match sidebar color */
        .card-header {
            background-color: #C4704E;
            color: #fff;
            font-weight: bold;
            font-size: 1.25rem;
        }

        .table thead th {
            background-color: #C4704E !important;
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }

        /* Highlight row hover */
        .table tbody tr:hover {
            background-color: #f8e6df;
        }

        /* Style DataTables search & pagination */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #C4704E;
            border-radius: 6px;
            padding: 4px 8px;
        }
        /* hide "Show entries" */
        .dataTables_length {
            display: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #fff;
            border: 1px solid #C4704E;
            color: #C4704E !important;
            border-radius: 6px;
            margin: 2px;
            padding: 4px 10px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #C4704E !important;
            color: #fff !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.9rem;
            }
            .card-header {
                font-size: 1rem;
                text-align: center;
            }
            .dataTables_wrapper .dataTables_filter {
                text-align: left !important;
            }
        }
    </style>
</head>
<body class="p-4">

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                Donation Records
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="donationsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Donor Name</th>
                                <th>Email</th>
                                <th>Amount</th>
                                <th>Donation Date</th>
                                <th>Message</th>
                                <th>Transaction ID</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td>₱<?= number_format($row['amount'], 2) ?></td>
                                        <td><?= $row['donation_date'] ?></td>
                                        <td><?= htmlspecialchars($row['message']) ?></td>
                                        <td><?= htmlspecialchars($row['transaction_id']) ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="8" class="text-center">No donations found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery + DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#donationsTable').DataTable({
            "pageLength": 10,
            "responsive": true,
            "lengthChange": false // disables the dropdown (show entries)
        });
    });
    </script>

</body>
</html>
