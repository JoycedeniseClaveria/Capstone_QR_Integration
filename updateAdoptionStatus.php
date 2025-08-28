<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adoptionId = $_POST['adoptionId'];
    $newStatus = $_POST['status'];

    // 1. Update adoption status
    $updateQuery = "UPDATE adoption SET status = ? WHERE adoptionId = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $newStatus, $adoptionId);

    if ($stmt->execute()) {
        // 2. Get userId from adoption table
        $userQuery = "SELECT userId FROM adoption WHERE adoptionId = ?";
        $userStmt = $conn->prepare($userQuery);
        $userStmt->bind_param("i", $adoptionId);
        $userStmt->execute();
        $userStmt->bind_result($userId);
        $userStmt->fetch();
        $userStmt->close();

        // 3. Insert notification
        $message = "Your adoption status has been updated to: $newStatus";
        $notifQuery = "INSERT INTO notifications (userId, message, createdAt) VALUES (?, ?, NOW())";
        $notifStmt = $conn->prepare($notifQuery);
        $notifStmt->bind_param("is", $userId, $message);
        $notifStmt->execute();
        $notifStmt->close();

        echo "Status updated and notification sent.";
    } else {
        echo "Failed to update status.";
    }

    $stmt->close();
}
?>
