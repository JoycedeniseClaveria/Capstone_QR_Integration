<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header('location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Extract data from the POST request and sanitize input
    $userId = $_SESSION['userId'];
    $updatedFirstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $updatedLastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $updatedGender = mysqli_real_escape_string($conn, $_POST['gender']);
    $updatedBirthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $updatedEmailAddress = mysqli_real_escape_string($conn, $_POST['emailAddress']);
    $updatedContactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $updatedMaritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
    $updatedCitizenship = mysqli_real_escape_string($conn, $_POST['citizenship']);
    $updatedLocation = mysqli_real_escape_string($conn, $_POST['location']);

    // Update user data in the database using prepared statements
    $query = "UPDATE users 
              SET firstName = ?, 
                  lastName = ?, 
                  gender = ?, 
                  birthday = ?, 
                  emailAddress = ?, 
                  contactNo = ?, 
                  maritalStatus = ?, 
                  citizenship = ?, 
                  location = ? 
              WHERE userId = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssisssissi", $updatedFirstName, $updatedLastName, $updatedGender, $updatedBirthday, $updatedEmailAddress, $updatedContactNo, $updatedMaritalStatus, $updatedCitizenship, $updatedLocation, $userId);
    
    if (mysqli_stmt_execute($stmt)) {
        // Close statement
        mysqli_stmt_close($stmt);
        // Redirect to profile page after a brief delay
        echo "<script>
                alert('User profile updated successfully!');
                setTimeout(function() {
                    window.location.href = 'userProfileV2.php';
                }, 1000); // 1000 milliseconds delay (1 second)
              </script>";
    } else {
        // Error occurred while updating data
        echo "<script>
                alert('Error updating user profile: " . mysqli_error($conn) . "');
                window.location.href = 'userProfileV2.php'; // Redirect to profile page
              </script>";
    }
} else {
    // Redirect to profile page if form submission is not valid
    header('location: userProfileV2.php');
    exit();
}

// Close connection
mysqli_close($conn);
?>
