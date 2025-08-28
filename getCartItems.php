<?php
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

// SQL query to fetch cart items added by the current user
$sql = "SELECT productName, productColor, productQuantity, productPrice 
        FROM addtocart 
        WHERE userId = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Fetch all rows and store in an array
        $cartItems = array();
        while($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error executing SQL statement: " . $stmt->error;
        exit();
    }
} else {
    echo "Error preparing SQL statement: " . $conn->error;
    exit();
}

// Close connection
$conn->close();

// Return cart items
echo json_encode($cartItems);
?>
