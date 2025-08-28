<?php
    include "connection.php";

// Retrieve post data
$text = $_POST['text'];
$images = $_FILES['images'];

// Insert post
$sql = "INSERT INTO post (text) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $content);
$stmt->execute();
$post_id = $stmt->insert_id;

// Insert images
$sql = "INSERT INTO images (postId, imagePath) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

foreach ($images['name'] as $index => $name) {
    $target_directory = "uploads/";
    $target_file = $target_directory . basename($images["name"][$index]);
    move_uploaded_file($images["tmp_name"][$index], $target_file);
    $stmt->bind_param("is", $postId, $target_file);
    $stmt->execute();
}

echo "Post and images uploaded successfully!";
$conn->close();
?>
