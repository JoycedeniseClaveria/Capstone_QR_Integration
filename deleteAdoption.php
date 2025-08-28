<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = "DELETE FROM adoption WHERE adoptionId = '$id'";
    if (mysqli_query($conn, $delete)) {
        header("Location: adoptionDetailsAdmin.php?deleted=1");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
