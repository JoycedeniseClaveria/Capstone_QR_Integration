<?php
include 'connection.php';
session_start();

if(!isset($_SESSION['userId'])) {
    exit;
}

$adminId = $_SESSION['userId'];

$query = "
    SELECT n.id, n.userId, n.title, n.created_at, n.is_read, u.firstName, u.lastName
    FROM notifications n
    JOIN users u ON n.userId = u.userId
    WHERE n.receiverId = ?
    ORDER BY n.id DESC
    LIMIT 5
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
$unreadCount = 0;

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $message = "<strong>{$row['firstName']} {$row['lastName']}</strong> has set an appointment to visit in the shelter for <em>{$row['title']}</em>.";
        $created = date("M d, Y h:i A", strtotime($row['created_at']));
        $bgClass = $row['is_read'] == 0 ? "bg-light" : "";

        if($row['is_read'] == 0) $unreadCount++;

        $notifications[] = '
            <a href="visitationManagement.php" class="dropdown-item d-flex align-items-center '.$bgClass.'" data-id="'.$row['id'].'">
                <div class="me-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="notif-message">'.$message.'</div>
                    <div class="notif-time">'.$created.'</div>
                </div>
            </a>
        ';
    }
} else {
    $notifications[] = '<span class="dropdown-item small text-gray-500">No new notifications</span>';
}

// Output JSON with both unread count and notifications HTML
echo json_encode([
    'unreadCount' => $unreadCount,
    'notificationsHTML' => implode("", $notifications)
]);
