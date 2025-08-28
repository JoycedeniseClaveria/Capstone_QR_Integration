<?php
include 'connection.php';

$query = "
    SELECT n.id, n.userId, s.title, n.created_at, n.is_read, u.firstName, u.lastName
    FROM notifications n
    JOIN users u ON n.userId = u.userId
    JOIN schedule_list s ON n.schedule_id = s.id
    ORDER BY n.id DESC
";

$result = $conn->query($query);

if($result->num_rows > 0){
    echo '<ul class="list-group">';
    while($row = $result->fetch_assoc()){
        $message = "<strong>{$row['firstName']} {$row['lastName']}</strong> has set an appointment to visit the shelter for <em>{$row['title']}</em>.";
        $created = date("M d, Y h:i A", strtotime($row['created_at']));
        $bgClass = $row['is_read'] == 0 ? "list-group-item-warning" : "";

        echo '<li class="list-group-item '.$bgClass.'">
                <div>'.$message.'</div>
                <small class="text-muted">'.$created.'</small>
              </li>';
    }
    echo '</ul>';
} else {
    echo "<p class='text-center text-muted'>No notifications found.</p>";
}
?>
