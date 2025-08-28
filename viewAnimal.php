<?php
include 'connection.php';

if (!isset($_GET['id'])) {
    echo "Animal not found!";
    exit;
}

$animalId = intval($_GET['id']);
$query = "SELECT * FROM animals WHERE animalId = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $animalId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo "<h1>" . $row['name'] . "</h1>";
    echo "<img src='uploads/animal_images/" . $row['image'] . "' width='200'>";
    echo "<p>Species: " . $row['species'] . "</p>";
    echo "<p>Status: " . $row['status'] . "</p>";
    echo "<p>Description: " . $row['description'] . "</p>";
} else {
    echo "Animal not found!";
}
?>
