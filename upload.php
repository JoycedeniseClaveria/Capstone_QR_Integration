<?php

include 'connection.ph';

// Path settings
$networkPath = "C:\\xampp\\htdocs\\capstone\\uploads\\"; // Local filesystem path for saving files
$webPath = "http://localhost/capstone/uploads/"; // Web path for accessing files

// Check if a file has been uploaded
if (isset($_POST["submit"])) {
    $fileName = basename($_FILES["image"]["name"]);
    $target_file = $networkPath . $fileName;
    $webFileUrl = $webPath . urlencode($fileName);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) { // 500KB size limit
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Attempt to upload file if checks pass
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars($fileName) . " has been uploaded.<br>";

            // Insert the web accessible URL into your database
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("INSERT INTO newsfeed (image) VALUES (:image)");
                $stmt->bindParam(':image', $webFileUrl);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}

// Display all images from the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT image FROM newsfeed");
    $stmt->execute();

    // Set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($stmt->fetchAll() as $row) {
        echo '<img src="' . $row['image'] . '" style="width:200px;"><br>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
