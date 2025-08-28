post.php
<?php
    session_start();
    include 'connection.php';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert the post into the database
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        move_uploaded_file($tmpName, 'img/' . $newImageName);
        $sql = "INSERT INTO newsfeed (username, postText, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['username'],
            $_POST['postText'],
            $_POST['image']
        ]);
        
        // Set success message in session
        $_SESSION['success_message'] = "Post successfully uploaded!";

        // Redirect to newsfeed or show success message
        header("Location: newsfeed.php");
        exit();
    }
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>