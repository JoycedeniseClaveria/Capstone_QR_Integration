<?php
require 'connection.php';
session_start(); // Start session if you intend to use session variables elsewhere.

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
  header('location: loginV2.php');
  exit(); // Ensure to exit after redirection
}

// Retrieve user information from session
$userId = $_SESSION['userId'];

// Process form submission to add a new post
if(isset($_POST["submit"])) {
  $username = $_POST["username"];
  $postText = $_POST["postText"];
  $postTime = date('Y-m-d H:i:s'); // Current time, formatted to SQL datetime format

  $uploadedImages = [];
  
  if($_FILES["image"]["error"] == 4){
    // Handle error if no image uploaded
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Image does not exist.',
                showConfirmButton: false,
                timer: 2000
              });
            });
          </script>";
  }
  else{
    // Validate and process the uploaded image
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $imageExtension = strtolower($imageExtension);

    if (!in_array($imageExtension, $validImageExtension)){
      // Handle invalid image extension
      echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Invalid File Extension',
                  text: 'Allowed extensions are .jpg, .jpeg, .png.',
                  showConfirmButton: false,
                  timer: 2000
                });
              });
            </script>";
    }
    else if($fileSize > 10485760){
      // Handle oversized image
      echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                  icon: 'warning',
                  title: 'File Too Large',
                  text: 'Image size should not exceed 10MB.',
                  showConfirmButton: false,
                  timer: 2000
                });
              });
            </script>";
    }
    else{
      // Move uploaded image to directory and insert post into database
      $newImageName = "img/" . uniqid() . '.' . $imageExtension;
      move_uploaded_file($tmpName, $newImageName);
      $query = "INSERT INTO newsfeed (username, postTime, postText, image) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ssss", $username, $postTime, $postText, $newImageName);

      if ($stmt->execute()) {
        $_SESSION['success_message'] = "Your post has been successfully uploaded.";
      } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to insert post into database.',
                    showConfirmButton: false,
                    timer: 2000
                  });
                });
              </script>";
      }
      
      // Redirect to avoid form resubmission
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Facebook Newsfeed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    /* Custom scrollbar styles */
    .scrollable-container {
        width: 50%;
        max-height: 630px;
        overflow-y: auto;
        scrollbar-width: none; /* "auto" for Firefox */
    }

    .scrollable-container::-webkit-scrollbar {
        width: 8px; /* Width of the scrollbar */
    }

    .scrollable-container::-webkit-scrollbar-track {
        background: #f1f1f1; /* Color of the scrollbar track */
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background-color: #888; /* Color of the scrollbar thumb */
        border-radius: 4px; /* Rounded corners of the scrollbar thumb */
    }

    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background-color: #555; /* Color of the scrollbar thumb on hover */
    }
    </style>
</head>
<body>
  <div class="container mt-5">
    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">POST NOW</button>

    <!-- Modal for posting -->
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="postModalLabel">Create Post</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <label for="postText" class="form-label">Post:</label>
                <textarea class="form-control" id="postText" name="postText" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Select image to upload:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="submit" class="btn btn-primary">Post</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <!-- Display posts from the database -->
    <div class="mt-5">
      <h2>Newsfeed</h2>
      <?php
      if (isset($_SESSION['success_message'])) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{$_SESSION['success_message']}',
                    showConfirmButton: false,
                    timer: 2000
                  });
                });
              </script>";
        unset($_SESSION['success_message']); // Clear the session variable after displaying
      }
      
      // Retrieve posts from database to display on the page
      $query = "SELECT * FROM newsfeed ORDER BY postTime DESC";
      $result = $conn->query($query);

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="card mb-3">
                  <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row["username"]) . '</h5>
                    <p class="card-text">' . htmlspecialchars($row["postText"]) . '</p>
                    <img src="' . htmlspecialchars($row["image"]) . '" class="img-fluid" alt="Post Image">
                    <p class="card-text"><small class="text-muted">Posted on ' . htmlspecialchars($row["postTime"]) . '</small></p>
                  </div>
                </div>';
        }
      } else {
        echo '<p>No posts yet.</p>';
      }
      ?>
    </div>
  </div>
</body>
</html>
