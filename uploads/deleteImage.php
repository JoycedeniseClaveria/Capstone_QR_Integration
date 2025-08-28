<?php
include 'connection.php';
$id = $_GET['id'];
$pid = $_GET['pid'];
mysqli_query($conn, "DELETE FROM product_images WHERE image_id='$id'");
header("Location: editProduct.php?id=$pid");
exit;
?>
