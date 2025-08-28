<?php
// get_cart_count.php

include 'connection.php';
session_start();

if (!isset($_SESSION['userId'])) {
    echo json_encode(['cart_count' => 0, 'cart_details' => []]);
    exit();
}

$userId = $_SESSION['userId'];
$query = "SELECT productName, productColor, SUM(productQuantity) as totalQuantity 
          FROM addtocart 
          WHERE userId = ? 
          GROUP BY productName, productColor";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartCount = 0;
$cartDetails = [];

while ($row = $result->fetch_assoc()) {
    $cartCount += $row['totalQuantity'];
    $cartDetails[$row['productName']][] = [
        'productColor' => $row['productColor'],
        'productQuantity' => $row['totalQuantity']
    ];
}

echo json_encode(['cart_count' => $cartCount, 'cart_details' => $cartDetails]);

$stmt->close();
$conn->close();
?>
