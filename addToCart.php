<?php
// add_to_cart.php

include 'connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    header('location:login.php');
    exit();
}

// Retrieve the user's first name and last name from the database
$userId = $_SESSION['userId'];
$firstName = '';
$lastName = '';

$query = "SELECT firstName, lastName FROM users WHERE userId = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $stmt->bind_result($firstName, $lastName);
        $stmt->fetch();
    } else {
        echo "Error executing SQL statement: " . $stmt->error;
        exit();
    }
    $stmt->close();
} else {
    echo "Error preparing SQL statement: " . $conn->error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $productColor = $_POST['productColor'];
    $productQuantity = $_POST['productQuantity'];
    $productPrice = $_POST['productPrice'];
    $dateAdded = date('Y-m-d H:i:s');

    $query = "INSERT INTO addtocart (userId, firstName, lastName, productName, productColor, productQuantity, productPrice, dateAdded) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issssids', $userId, $firstName, $lastName, $productName, $productColor, $productQuantity, $productPrice, $dateAdded);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
