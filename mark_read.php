<?php
include 'connection.php';
session_start();

if(isset($_POST['notifId'])){
    $id = $_POST['notifId'];
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "success";
}
?>
