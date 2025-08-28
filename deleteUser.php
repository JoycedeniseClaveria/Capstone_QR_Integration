<?php
include 'connection.php';
session_start();

if (isset($_POST['userId']) && isset($_SESSION['userId'])) {
    $userId = $_POST['userId'];
    $query = "DELETE FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
