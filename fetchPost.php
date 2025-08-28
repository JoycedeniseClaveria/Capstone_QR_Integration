<?php
    include "connection.php";

$sql = "SELECT p.id, p.text, p.created, i.imagePath
        FROM post p
        LEFT JOIN images i ON p.id = i.postId
        ORDER BY p.created DESC";

$result = $conn->query($sql);

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[$row['id']]['text'] = $row['text'];
    $posts[$row['id']]['created'] = $row['created'];
    $posts[$row['id']]['images'][] = $row['imagePath'];
}

echo json_encode(array_values($posts));
$conn->close();
?>
