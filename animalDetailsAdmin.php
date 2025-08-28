<?php 
    include 'connection.php';
    include 'dashboardAdmin.php';
   
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Details</title>
    <!-- Include Bootstrap CSS and JS for table and modal functionality -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        .image-container {
            display: flex;
            justify-content: center;
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

<div class="d-flex justify-content-start mb-3">
    <button class="btn" style="background-color: #e3896b; color: white;" onclick="openAddModal()">
         Add Animal
    </button>
</div>

    <div class="animalTable">
        <table id="animalTableAdmin" class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Animal Image</th>
                    <th>Animal Name</th>
                    <th>Gender</th>
                    <th>Status</th>
                     <th>QR Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <!-- Data will be populated by DataTables via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Modal structure -->
    <div class="modal fade" id="animalModal" tabindex="-1" aria-labelledby="animalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="animalModalLabel">Update Animal Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="animalForm" enctype="multipart/form-data">
                        <input type="hidden" id="animalId" name="animalId">
                        <div class="form-group">
                            <div class="image-container">
                    
<div class="form-group">
    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
</div>

                        
                                <!-- <input type="file" class="form-control" id="image" name="image"> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="animalName">Animal Name</label>
                            <input type="text" class="form-control" id="animalName" name="animalName">
                        </div>
                        <div class="form-group">
                            <label for="species">Species</label>
                            <select class="form-control" id="species" name="species">
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="breed">Breed</label>
                            <input type="text" class="form-control" id="breed" name="breed">
                        </div> -->
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Adoptable">Adoptable</option>
                                <option value="In Foster">In Foster</option>
                                <option value="Pending">Pending</option>
                                <option value="Adopted">Adopted</option>
                                <option value="Medical Hold">Medical Hold</option>
                                <option value="Escaped/Lost">Escaped/Lost</option>
                                <option value="Pending Adoption">Pending Adoption</option>
                                <option value="Pending Transfer">Pending Transfer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" id="age" name="age">
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                        </div>

                        <div class="form-group">
                            <label for="intakeType">Intake Type</label>
                            <select class="form-control" id="intakeType" name="intakeType">
                                <option value="Stray">Stray</option>
                                <option value="External Transfer">External Transfer</option>
                                <option value="Owner Surrender">Owner Surrender</option>
                                <option value="Born in Care">Born in Care</option>
                                <option value="Return to Rescue">Return to Rescue</option>
                                <option value="Abandoned">Abandoned</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="intakeDate">Intake Date</label>
                            <input type="date" class="form-control" id="intakeDate" name="intakeDate">
                        </div>

                        <div class="form-group">
                            <label for="conditions">Condition</label>
                            <select class="form-control" id="conditions" name="conditions">
                                <option value="Healthy">Healthy</option>
                                <option value="Pregnant">Pregnant</option>
                                <option value="Injured">Injured</option>
                                <option value="Sick">Sick</option>
                                <option value="Feral">Feral</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="6" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="antiRabies">w/ Anti Rabies</label>
                            <select name="antiRabies" id="antiRabies" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="vaccine">w/ 5-in-1 Vaccine</label>
                            <select name="vaccine" id="vaccine" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="neutered">Neutered</label>
                            <select name="neutered" id="neutered" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="deticked">Deticked</label>
                            <select name="deticked" id="deticked" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dewormed">Dewormed</label>
                            <select name="dewormed" id="dewormed" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="animalForm"><i class="fa fa-save"></i>  Save changes </button>
                   <!-- <button type="button" class="btn btn-info" id="downloadBtn">Download Application</button> -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#animalTableAdmin').DataTable({
                'processing': true,
                'serverSide': true,
                'ajax': {
                    'url': 'animal_dataTable.php',
                    'type': 'POST'
                },
                'columns': [
    { 
        'data': 'image',
        'render': function(data, type, row, meta) {
            return '<img src="' + data + '" class="card-img-top" style="height: 20vh; width: 160px;" alt="Animal Image">';
        }
    },
    { 'data': 'animalName' },
    { 'data': 'gender' },
    { 'data': 'status' },
    {   
    'data': 'animalId',
    'render': function(data, type, row, meta) {
        return `
           <img src="uploads/qr/${data}_QR.png" 
                 style="width:100px;height:100px;" alt="QR Code"><br>
            <a href="uploads/qr/${data}_QR.png" 
               download="${row.animalName}_QR.png" 
               class="btn btn-sm btn-success mt-1">
                <i class="fa fa-download"></i> Download
            </a>
        `;
    }
},




    {
        'data': 'animalId',
        'render': function(data, type, row, meta) {
            return `<button class="btn btn-primary" onclick="openModal(${data})"><i class="fa fa-eye"></i></button>
                    <button class="btn btn-danger ml-2" onclick="deleteAnimal(${data})"><i class="fa fa-trash"></i></button>`;
        }
    }
],

                'scrollY': 500,
                'scrollCollapse': true,
                'scroller': true
            });

            // Function to open the modal and load user details
            window.openModal = function(animalId) {
                $.ajax({
                    url: 'getAnimalProfile.php',
                    type: 'GET',
                    data: { animalId: animalId },
                    success: function(data) {
                        var animal = JSON.parse(data);
                        $('#animalId').val(animal.animalId);
                        $('#animalImage').attr('src', animal.image);
                        $('#animalName').val(animal.animalName);
                        $('#species').val(animal.species);
                        $('#breed').val(animal.breed);
                        $('#gender').val(animal.gender);
                        $('#status').val(animal.status);
                        $('#age').val(animal.age);
                        $('#birthday').val(animal.birthday);
                        $('#intakeType').val(animal.intakeType);
                        $('#intakeDate').val(animal.intakeDate);
                        $('#conditions').val(animal.conditions);
                        $('#description').val(animal.description);
                        $('#antiRabies').val(animal.antiRabies);
                        $('#vaccine').val(animal.vaccine);
                        $('#neutered').val(animal.neutered);
                        $('#deticked').val(animal.deticked);
                        $('#dewormed').val(animal.dewormed);

                        $('#animalModal').modal('show');
                    }
                });
            };

            // Function to generate PDF
            window.generatePDF = function(animalId) {
                window.open('animalPDF.php?animalId=' + animalId);
            };

            // Handle form submission
            $('#animalForm').submit(function(event) {
    event.preventDefault();
    var form = $('#animalForm')[0];
var formData = new FormData(form);

    var url = $('#animalId').val() ? 'updateAnimal.php' : 'addAnimals.php';

   $.ajax({
    url: $('#animalId').val() ? 'updateAnimal.php' : 'addAnimals.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        $('#animalModal').modal('hide');
        $('#animalTableAdmin').DataTable().ajax.reload();

        swal({
            title: "Success",
            text: $('#animalId').val() ? "Animal updated successfully" : "Animal added successfully",
            icon: "success",
            timer: 2000,
            buttons: false
        });
    },
    error: function() {
        swal({
            title: "Error",
            text: "Something went wrong.",
            icon: "error",
            timer: 2000,
            buttons: false
        });
    }
});

});

        });

        function deleteAnimal(animalId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to retrieve this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'deleteAnimal.php',
                        type: 'POST',
                        data: { animalId: animalId },
                        success: function(response) {
                            Swal.fire('Deleted!', 'Animal has been deleted.', 'success');
                            $('#animalTableAdmin').DataTable().ajax.reload(); // Ensure data reload after delete
                        },
                        error: function() {
                            Swal.fire('Failed!', 'Error deleting animal.', 'error');
                        }
                    });
                }
            });
        }


        function openAddModal() {
    $('#animalForm')[0].reset(); // Clear all fields
    $('#animalId').val(''); // Make sure ID is blank for new insert
    $('#animalImage').attr('src', 'uploads/default.jpg'); // Set default image (if any)
    $('#animalModalLabel').text('Add New Animal');
    $('#animalModal').modal('show');
}


    </script>
</body>
</html>
