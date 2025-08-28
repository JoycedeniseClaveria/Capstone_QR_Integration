<?php 
    include 'connection.php';
    include 'dashboardAdmin.php';

    // session_start();

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
<html>
<head>
    <title>Adoption</title>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .dataTables_length {
            display: none;
        }

        th {
            text-align: center;
        }

        #tbody {
            align-items: center;
            text-align: center;
        }

        .modal-header {
            background-color: #e3896b;
            color: white;
        }
    </style>
</head>
<body>
    
<div class="container mt-3">
    <div class="adoptionTable">
        <table id="adoptionTableAdmin" class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Animal Image</th>
                    <th>Application Date</th>
                    <th>Adopter's Name</th>
                    <th>Animal Name</th>
                    <th>Location</th>
                    <th>Contact No</th>
                    <th>Age</th>
                    <th>View Application</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <!-- Data will be populated by DataTables via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Adoption Details Modal -->
<div class="modal fade" id="adoptionModal" tabindex="-1" aria-labelledby="adoptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adoptionModalLabel">Adoption Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="adoptionDetails">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Left: Animal Image -->
                        <div class="col-md-4 text-center mb-3">
                            <img src="" id="animalImage" class="img-fluid rounded shadow" alt="Animal Image" style="max-height: 350px; object-fit: cover;">
                            <h4 class="mt-3 text-dark font-weight-bold" id="animalName">Animal Name</h4>
                        </div>

                        <!-- Right: Details -->
                        <div class="col-md-8">
                            <div class="card p-3 shadow-sm mb-3 rounded-lg">
                                <h5 class="text-primary mb-3">Application Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-2"><strong>Application Date:</strong> <span id="applicationDate"></span></div>
                                    <div class="col-md-6 mb-2"><strong>Status:</strong> <span id="applicationStatus" class="badge badge-info"></span></div>
                                </div>
                            </div>

                            <div class="card p-3 shadow-sm rounded-lg">
                                <h5 class="text-primary mb-3">Adopter's Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-2"><strong>Name:</strong> <span id="adopterName"></span></div>
                                    <div class="col-md-6 mb-2"><strong>Age:</strong> <span id="adopterAge"></span></div>
                                    <div class="col-md-6 mb-2"><strong>Location:</strong> <span id="adopterLocation"></span></div>
                                    <div class="col-md-6 mb-2"><strong>Contact No:</strong> <span id="adopterContact"></span></div>
                                    <div class="col-md-12 mb-2"><strong>Facebook:</strong> <a href="#" id="adopterFacebook" target="_blank">View Profile</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white" style="background-color: #4e73df;" id="downloadBtn">
                    <i class="fa fa-download"></i> Download Application
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editStatusForm">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editStatusModalLabel">Update Adoption Status</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="adoptionId" id="editAdoptionId">
          <div class="form-group">
            <label for="adoptionStatus">Status</label>
            <select name="status" id="adoptionStatus" class="form-control" required>
              <option value="">-- Select Status --</option>
              <option value="Approved">Approved</option>
              <option value="Pending">Pending</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Status</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#adoptionTableAdmin').DataTable({
                'processing': true,
                'serverSide': true,
                'ajax': {
                    'url': 'adoption_dataTable.php',
                    'type': 'POST'
                },
                'columns': [
                    { 
                        'data': 'image',
                        'render': function(data, type, row, meta) {
                            return '<img src="' + data + '" class="card-img-top" style="height: 20vh;" alt="Animal Image">';
                        }
                    },
                    { 'data': 'applicationDate' },
                    { 'data': 'name' },
                    { 'data': 'animalName' },
                    { 'data': 'location' },
                    { 'data': 'contactNo' },
                    { 'data': 'age' },
                    {
                        'data': 'adoptionId',
                        'render': function(data, type, row, meta) {                  
                            return `
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary mr-1" onclick="openModal(${data})"><i class="fa fa-eye"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${data}"><i class="fa fa-trash"></i></button>
                                    <button class="btn btn-primary btn-sm" onclick="editApplication('${data}')"><i class="fa fa-edit"></i> </button>
                                </div>
                            `;
                        }
                    }
                ],
                'scrollY': 470,
                'scrollCollapse': true,
                'scroller': true
            });

            // Function to open the modal and load user details
            window.openModal = function(adoptionId) {
                $.ajax({
                    url: 'getUserAdoption.php',
                    type: 'GET',
                    data: { adoptionId: adoptionId },
                    success: function(data) {
                        $('#adoptionDetails').html(data);
                        $('#adoptionModal').modal('show');
                        $('#downloadBtn').attr('onclick', 'generatePDF(' + adoptionId + ')');
                    }
                });
            };

            // Function to generate PDF
            window.generatePDF = function(adoptionId) {
                window.open('adoptionPDF.php?adoptionId=' + adoptionId);
            };
        });

// Handle delete button click
$('#adoptionTableAdmin').on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: '', // Remove or change this to your preferred wording
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'deleteAdoption.php?id=' + id;
        }
    });
});





window.editApplication = function(adoptionId) {
    $('#editAdoptionId').val(adoptionId);
    $('#adoptionStatus').val('');
    $('#editStatusModal').modal('show');
};

$('#editStatusForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: 'updateAdoptionStatus.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Status Updated!',
                showConfirmButton: false,
                timer: 1500
            });
            $('#editStatusModal').modal('hide');
            $('#adoptionTableAdmin').DataTable().ajax.reload(); // refresh table
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: 'Please try again.'
            });
        }
    });
});



    </script>

    
</body>
</html>
