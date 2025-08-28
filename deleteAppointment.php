<?php
include 'connection.php';

if(isset($_POST['deleteId'])){
    $id = $_POST['deleteId'];
    $stmt = $conn->prepare("DELETE FROM schedule_list WHERE id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}
?>
