<?php
include 'connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch all users (NO LIMIT)
    $stmt = $conn->prepare("SELECT userId, firstName, lastName, location, emailAddress, contactNo, type FROM users");
    if (!$stmt) {
        die(json_encode(["error" => "Prepare failed: " . $conn->error]));
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $response = [
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
