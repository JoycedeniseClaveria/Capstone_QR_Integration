<?php

include 'connection.php';

// Check if the animal ID is provided via GET request
if (isset($_GET['animalId']) && !empty($_GET['animalId'])) {
    $animalId = $_GET['animalId'];

    // Fetch animal details from the database based on the provided animal ID
    $sql = "SELECT animalName, species, gender, status, image FROM animal WHERE animalId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $animalId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $animal = $result->fetch_assoc();

        // Display animal details in the modal body
        echo '<h5>' . htmlspecialchars($animal['animalName']) . '</h5>';
        echo '<p>Species: ' . htmlspecialchars($animal['species']) . '</p>';
        echo '<p>Gender: ' . htmlspecialchars($animal['gender']) . '</p>';
        echo '<p>Status: <span class="badge badge-warning">' . htmlspecialchars($animal['status']) . '</span></p>';
        echo '<img src="' . htmlspecialchars($animal['image']) . '" class="img-fluid" alt="Animal Image" style="max-width: 100%;">';
    } else {
        echo '<p class="text-muted">Animal not found.</p>';
    }


    $stmt->close();
    $conn->close();
} else {
    // Handle case where animal ID is missing or invalid
    echo '<p class="text-danger">Invalid request. Animal ID is required.</p>';
}
?>
