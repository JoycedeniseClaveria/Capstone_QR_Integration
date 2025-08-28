<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['userId'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['userId'];

$query = "SELECT message, createdAt FROM notifications WHERE userId = ? ORDER BY createdAt DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);
?>
