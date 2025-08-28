<?php
include 'connection.php';
session_start();

if (isset($_POST['animalId'])) {
    $animalId = $_POST['animalId'];
    $query = "DELETE FROM animal WHERE animalId = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $animalId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "Deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
