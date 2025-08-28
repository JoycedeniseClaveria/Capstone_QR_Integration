<?php
include 'connection.php';
include 'dashboardAdmin.php';

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Pagination
$limit = 10; // rows per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Count total rows
$countSql = "SELECT COUNT(*) as total 
             FROM schedule_list s
             JOIN users u ON s.userId = u.userId
             WHERE u.firstName LIKE ? OR u.lastName LIKE ?";
$stmt = $conn->prepare($countSql);
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$countResult = $stmt->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);
$stmt->close();

// Fetch data with search + pagination
$sql = "SELECT s.id, s.title, s.description, s.start_datetime, s.end_datetime, s.status,
               u.firstName, u.lastName
        FROM schedule_list s
        JOIN users u ON s.userId = u.userId
        WHERE u.firstName LIKE ? OR u.lastName LIKE ?
        ORDER BY s.start_datetime DESC
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $searchParam, $searchParam, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
/* Main palette */
:root {
    --main-color: #CC7B60;
    --main-dark: #a65f45;
    --main-light: #e6b3a3;
}

body {
    background-color: #fdfaf8;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    background: var(--main-color) !important;
    border: none;
    font-weight: 600;
    font-size: 1.1rem;
}

.card-header h5 {
    margin: 0;
}

.table thead {
    background-color: var(--main-color);
    color: #fff;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody tr:hover {
    background-color: var(--main-light);
    transition: 0.3s ease;
}

.table td, .table th {
    vertical-align: middle;
}

.btn-primary {
    background-color: var(--main-color);
    border: none;
}
.btn-primary:hover {
    background-color: var(--main-dark);
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}
.btn-danger:hover {
    background-color: #b02a37;
}

.modal-header {
    background-color: var(--main-color);
    color: #fff;
}

#updateModal .modal-dialog {
    max-width: 700px;
    width: 90%;
    height: auto;
    min-height: 400px;
    margin: auto;
}

#updateModal .modal-content {
    height: 100%;
    overflow-y: auto;
}

/* --- CENTER Status and Action columns --- */
.table td[data-label="Status"],
.table th:nth-child(5) {
    text-align: center;
    vertical-align: middle;
}

.table td[data-label="Action"],
.table th:nth-child(6) {
    text-align: center;
    vertical-align: middle;
}

/* --- RESPONSIVE: Keep layout, shrink fonts/padding --- */
@media (max-width: 768px) {
    /* Shrink table text & padding */
    .table td, .table th {
        font-size: 0.7rem;
        padding: 0.3rem 0.5rem;
    }

    /* Shrink card header */
    .card-header h5 {
        font-size: 0.9rem;
    }

    /* Shrink search input */
    #searchInput {
        max-width: 100px;
        padding: 4px 3px;
        font-size: 0.75rem;
    }

    /* Shrink badges */
    .badge {
        font-size: 0.65rem;
        padding: 3px 5px;
    }

    /* Shrink modal headers & content */
    .modal-header h5 {
        font-size: 0.9rem;
    }

    .modal-body input, 
    .modal-body select, 
    .modal-body textarea {
        font-size: 0.75rem;
        padding: 4px 6px;
    }

    .modal-footer .btn {
        font-size: 0.75rem;
        padding: 4px 6px;
    }

    /* --- ACTION buttons full-width, spaced, icon-only --- */
    .table td[data-label="Action"] .btn {
        display: block;
        width: 100%;             /* full width of cell */
        margin-bottom: 0.4rem;   /* space between buttons */
        font-size: 0.9rem;
        padding: 8px 0;          /* taller for touch */
        text-align: center;
    }

    /* Keep icons centered and hide text only */
    .table td[data-label="Action"] .btn i {
        margin: 0;
    }
    .table td[data-label="Action"] .btn *:not(i) {
        display: none;           /* icon-only */
    }

    /* Optional: shrink status badge slightly */
    .table td[data-label="Status"] .badge {
        font-size: 0.7rem;
        padding: 3px 6px;
    }
}

/* Right-aligned pagination */
.pagination {
    justify-content: flex-end !important; /* ensure right-align */
    margin-top: 1rem;
}

/* All page links */
.pagination .page-link {
    color: #CC7B60 !important;           /* number color */
    border: 1px solid #CC7B60 !important; /* border color */
    border-radius: 0.375rem;
    margin: 0 2px;
}

/* Active page */
.pagination .page-item.active .page-link {
    background-color: #CC7B60 !important; /* active background */
    color: #fff !important;               /* active text */
    border-color: #CC7B60 !important;
}

/* Disabled page */
.pagination .page-item.disabled .page-link {
    color: #6c757d !important;
    pointer-events: none;
    border-color: #dee2e6 !important;
}

/* Hover effect */
.pagination .page-link:hover {
    background-color: #a65f45 !important; /* darker shade on hover */
    color: #fff !important;
    border-color: #a65f45 !important;
}


</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Appointments</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-end mb-0">
    <input type="text" id="searchInput" class="form-control" 
           placeholder="🔍 Search user..." 
           style="max-width: 150px; border:2px solid #CC7B60; border-radius:10px; padding:8px 5px; margin-right:15px;">
</div>


<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-header text-white">
            <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Appointment Management</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td data-label="Name"><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?></td>
                                    <td data-label="Title"><?= htmlspecialchars($row['title']) ?></td>
                                    <td data-label="Description"><?= htmlspecialchars($row['description']) ?></td>
                                    <td data-label="Schedule">
                                        <?= date("M d, Y h:i A", strtotime($row['start_datetime'])) ?>
                                        <br>to<br>
                                        <?= date("M d, Y h:i A", strtotime($row['end_datetime'])) ?>
                                    </td>
                                    <td data-label="Status">
                                        <span class="badge 
                                            <?php if($row['status']=="Pending") echo "bg-warning text-dark";
                                                  elseif($row['status']=="Approved") echo "bg-success";
                                                  else echo "bg-danger"; ?>">
                                            <?= $row['status'] ?>
                                        </span>
                                    </td>
                                    <td data-label="Action">
                                        <button type="button" 
                                                class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#updateModal" 
                                                data-id="<?= $row['id'] ?>" 
                                                data-name="<?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?>" 
                                                data-title="<?= htmlspecialchars($row['title']) ?>">
                                            <i class="fas fa-edit"></i> Update
                                        </button>

                                        <form method="POST" class="deleteForm" style="display:inline;">
                                            <input type="hidden" name="deleteId" value="<?= $row['id'] ?>">
                                            <button type="submit" name="deleteAppointment" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>


                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No appointments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Pagination -->
<div class="d-flex justify-content-end mt-3">
    <nav>
        <ul class="pagination mb-0">
            <!-- Previous -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">Prev</a>
            </li>

            <!-- Page numbers -->
            <?php
            $visiblePages = 5; // max number of pages to show
            $startPage = max(1, $page - floor($visiblePages/2));
            $endPage = min($totalPages, $startPage + $visiblePages - 1);

            for($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

            </div>
        </div>
    </div>
</div>
<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="margin:0; position:absolute; top: 80px;; right:100px;">
    <form method="POST" id="updateForm">
      <div class="modal-content shadow-lg border-0 rounded-4">
        <div class="modal-header text-white" style="background-color:#CC7B60;">
          <h5 class="modal-title fw-bold" id="updateModalLabel">
            <i class="fas fa-calendar-check me-2"></i> Update Appointment
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4" style="background-color:#fdfaf8;">
          <input type="hidden" name="id" id="updateId">

          <div class="mb-3">
            <label for="status" class="form-label fw-semibold text-dark">Select Status</label>
            <select class="form-select border-2" name="status" id="status" required>
              <option value="">-- Choose --</option>
              <option value="Approved">Approved</option>
              <option value="Disapproved">Disapproved</option>
            </select>
          </div>

          <div class="mb-3 d-none" id="reasonGroup">
            <label for="reason" class="form-label fw-semibold text-dark">Reason (required if disapproved)</label>
            <textarea class="form-control border-2" name="reason" id="reason" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#f3e3dd;">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="updateStatus" class="btn text-white rounded-pill px-4" style="background-color:#CC7B60;">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>



<script src="vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.deleteForm').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // stop auto submit
            let formData = new FormData(form);

            Swal.fire({
                title: 'Are you sure?',
                text: "This appointment will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CC7B60',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request para i-delete
                    fetch('deleteAppointment.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        if(data == 'success'){
                            Swal.fire('Deleted!', 'Appointment has been deleted.', 'success');
                            form.closest('tr').remove(); // alisin sa table
                        } else {
                            Swal.fire('Error!', 'Failed to delete.', 'error');
                        }
                    })
                    .catch(err => console.error(err));
                }
            });
        });
    });
});


</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var title = button.getAttribute('data-title');

        document.getElementById('updateId').value = id;
        document.getElementById('updateName').textContent = name;
        document.getElementById('updateTitle').textContent = title;
    });

    // Show reason box only if status == Disapproved
    var statusSelect = document.getElementById('status');
    statusSelect.addEventListener('change', function() {
        var reasonGroup = document.getElementById('reasonGroup');
        var reason = document.getElementById('reason');

        if (this.value === "Disapproved") {
            reasonGroup.classList.remove('d-none');
            reason.setAttribute('required', 'required');
        } else {
            reasonGroup.classList.add('d-none');
            reason.removeAttribute('required');
        }
    });
});

</script>

<script>
$(document).ready(function(){
    $("#searchInput").on("keyup", function(){
        var search = $(this).val();

        $.ajax({
            url: "searchAppointments.php", // hiwalay na PHP file para sa search
            method: "GET",
            data: { search: search },
            success: function(data){
                $("tbody").html(data); // palitan ang laman ng table body
            }
        });
    });
});
</script>

</body>
</html>
