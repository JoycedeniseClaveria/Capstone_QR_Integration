<?php
session_start();

// Example: adjust this to your actual login session key
if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login page with a redirect back
    header("Location: login.php?redirect=animalProfileV2.php");
    exit();
}

// User is logged in
header("Location: animalProfileV2.php");
exit();
?>
