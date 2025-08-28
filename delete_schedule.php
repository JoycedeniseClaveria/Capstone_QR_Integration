<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $userId = $_SESSION['userId'];

    // Ensure na ang pwede lang i-delete ay appointment ng user mismo
    $query = "DELETE FROM schedule_list WHERE id = ? AND userId = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ii", $id, $userId);
        if ($stmt->execute()) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <title>Deleting Appointment</title>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your appointment has been deleted.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        window.location.href = 'appointment.php';
                    });
                </script>
            </body>
            </html>
            <?php
        } else {
            echo "Error deleting: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    header("Location: appointment.php");
    exit;
}

$conn->close();
?>
