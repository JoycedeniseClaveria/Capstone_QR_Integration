<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Modal -->
        <div class="modal fade" id="animalModal" tabindex="-1" role="dialog" aria-labelledby="animalModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="animalModalLabel">Animal Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="animalModalBody">
                        <!-- Animal details will be loaded here dynamically -->
                    </div>
                </div>
            </div>
        </div>

<?php
include 'connection.php';

function displayAnimalsBySpecies($conn, $species, $statusFilter) {
    $sql = "SELECT * FROM animal WHERE species = ?";
    if (!empty($statusFilter)) {
        $sql .= " AND status = ?";
    }

    $stmt = $conn->prepare($sql);
    if (!empty($statusFilter)) {
        $stmt->bind_param("ss", $species, $statusFilter);
    } else {
        $stmt->bind_param("s", $species);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h4 class='mt-5'>" . htmlspecialchars($species) . "s</h4>";
    echo "<div class='row'>";

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="card h-100">';
            echo '<img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top" style="height: 30vh; object-fit: cover;">';
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title mb-2" style="font-weight: bold;">' . $row["animalName"] . '</h5>';
            echo '<p class="card-text mb-1">' . $row["gender"] . '</p>';
            echo '<p class="card-text"><span class="badge badge-warning">' . $row["status"] . '</span></p>';
            echo '<button class="btn btn-primary view-details-btn" data-animal-id="' . $row["animalId"] . '">View Details</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="col-12"><p class="text-muted">No ' . $species . ' records found.</p></div>';
    }

    echo "</div>";
    $stmt->close();
}

// Filter from URL
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Dog Section
displayAnimalsBySpecies($conn, 'Dog', $statusFilter);

// Cat Section
displayAnimalsBySpecies($conn, 'Cat', $statusFilter);

$conn->close();
?>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.view-details-btn').click(function() {
                var animalId = $(this).data('animalId');

                // AJAX request to fetch animal details
                $.ajax({
                    url: 'getAnimalDetails.php',
                    method: 'GET',
                    data: { animalId: animalId },
                    success: function(response) {
                        $('#animalModalBody').html(response);
                        $('#animalModal').modal('show');
                    },
                    error: function() {
                        alert('Error fetching animal details.');
                    }
                });
            });
        });
    </script>
</body>
</html>
