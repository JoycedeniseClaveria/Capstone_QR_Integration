<?php
include 'connection.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $update = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $update->bind_param("i", $id);
    $update->execute();
    echo "success";
}
?>
