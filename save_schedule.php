<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

$userQuery = $conn->prepare("SELECT firstName, lastName FROM users WHERE userId = ?");
$userQuery->bind_param("i", $userId);
$userQuery->execute();
$userQuery->bind_result($firstName, $lastName);
$userQuery->fetch();
$userQuery->close();

$userId = $_SESSION['userId'];
$title = $_POST['title'];
$description = $_POST['description'];
$start = $_POST['start_datetime'];
$end = $_POST['end_datetime'];

// INSERT query (status default Pending)
$query = "INSERT INTO schedule_list (userId, title, description, start_datetime, end_datetime, status) 
          VALUES (?, ?, ?, ?, ?, 'Pending')";
$stmt = $conn->prepare($query);

// Kuhanin lahat ng admin users
$adminQuery = $conn->prepare("SELECT userId FROM users WHERE type = 'admin'");
$adminQuery->execute();
$result = $adminQuery->get_result();

$msg = $firstName . " " . $lastName . " set an appointment request to visit in the shelter for " . $title;

while ($admin = $result->fetch_assoc()) {
    $adminId = $admin['userId'];
    $adminNotif = $conn->prepare("INSERT INTO notifications (userId, type, message) VALUES (?, 'appointment', ?)");
    $adminNotif->bind_param("is", $adminId, $msg);
    $adminNotif->execute();
    $adminNotif->close();
}

$adminQuery->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
if ($stmt) {
    $stmt->bind_param("issss", $userId, $title, $description, $start, $end);
    if ($stmt->execute()) {
        // Success popup
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Schedule Saved!',
                text: 'Your appointment has been submitted.',
                confirmButtonColor: '#237acbff',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location.href = 'appointment.php';
            });
        </script>
        ";
    } else {
        echo "<script>alert('Error saving: " . addslashes($stmt->error) . "'); window.location.href='appointment.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "'); window.location.href='appointment.php';</script>";
}
?>
</body>
</html>
