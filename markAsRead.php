<?php
include 'connection.php';
if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo 'success';
}
?>
