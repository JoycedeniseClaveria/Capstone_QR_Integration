<?php
include 'connection.php';

$speciesFilter = isset($_GET['species']) ? $_GET['species'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM animal WHERE 1";
if (!empty($speciesFilter)) {
    $sql .= " AND species = '$speciesFilter'";
}
if (!empty($statusFilter)) {
    $sql .= " AND status = '$statusFilter'";
}

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<div class="row">'; // ✅ Bootstrap row wrapper

    while ($row = $result->fetch_assoc()) {

        echo '<div class="col-6 col-md-4 col-lg-2 mb-4">'; // ✅ responsive column
        echo '  <div class="card h-100">';
        echo '      <img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top" alt="Animal Image" style="height: 30vh; object-fit: cover;">';
        echo '      <div class="card-body text-center">';
        echo '          <h5 class="card-title mb-2" style="font-weight: bold; font-size: 17px;">' . $row["animalName"] . '</h5>';
        echo '          <p class="card-text mb-1" style="font-size: 15px;">' . ($row["gender"] == "Male" ? 'Male' : 'Female') . '</p>';
        echo '          <p class="card-text"><span class="badge badge-warning">' . $row["status"] . '</span></p>';
        echo '          <button class="btn btn-primary" onclick="showAnimalDetails(' . $row["animalId"] . ')">View Details</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }

    echo '</div>'; // ✅ close row
} else {
    echo '<p class="text-muted text-center mt-4">No matching records found.</p>';
}

$conn->close();
?>

<html>
<head>
   <style>
        .container-fluid {
            font-family: "Poppins", sans-serif;
            justify-content: justify;
        }

        .modal-body {
            text-align: justify;
        }

        .modal-body p,
        .modal-body span {
            text-align: justify;
        }

        @media (min-width: 576px) {
            .modal-content { width: 100%; }
        }

        @media (max-width: 575.98px) {
            .modal-content { width: 100%; }
        }

        @media (min-width: 481px) {
            .modal-content { width: 100%; }
        }

        @media (max-width: 768px) {
            .modal-content { width: 100%; }
        }

        @media (min-width: 769px) {
            .modal-content { width: 100%; }
        }

        @media (max-width: 1024px) {
            .modal-content { width: 100%; }
        }
        .card-body {
    color: black !important;
}

.modal-body, 
.modal-body p, 
.modal-body span, 
.modal-body strong, 
.modal-body h5 {
    color: black !important;
}


    </style>
</head>
<body>
<!-- Modal HTML for displaying animal details -->
<div class="modal fade" id="animalModal" tabindex="-1" role="dialog" aria-labelledby="animalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="animalModalLabel">
                  Help them find a new home!
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <!-- Image Section -->
            <div class="col-md-4 text-center">
                <img src="" id="animalImage" class="img-fluid rounded mb-3" alt="Animal Image" style="max-height: 300px; width: 100%; object-fit: contain;">
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
            </div>
        </div>

        <br>
        <div class="modal-footer">
            <a href="adopt.php" id="adoptButton" 
   class="btn text-white fw-bold" 
   style="background-color: #36b9cc; border: none;">
   Adopt Now
</a>
        </div> 
    </div>
</div>

        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript to handle modal display and content loading -->
<script>
    function showAnimalDetails(animalId) {
        $.ajax({
            url: 'getAnimalDetails.php',
            type: 'GET',
            data: { animalId: animalId },
            dataType: 'json',
            success: function(response) {
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

                $('#adoptButton').attr('href', 'adopt.php?animalId=' + animalId);

                $('#animalModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching animal details:', error);
                alert('Error fetching animal details.');
            }
        });
    }

    document.getElementById('adoptButton').addEventListener('click', function(event) {
        event.preventDefault(); 
        var href = this.href; 
        
        Swal.fire({
            title: 'Are you sure you want to adopt?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = this.href;
            }
        });
    });
</script>

</body>
</html>
