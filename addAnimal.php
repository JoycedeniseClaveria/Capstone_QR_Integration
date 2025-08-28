<?php
require 'connection.php';
session_start(); 

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
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="insertAnimal.php">
            <div class="form-group">
                Animal Name : <input type="text" name="animalName"><br><br>
            </div>
                
            <div class="form-group">
                <label for="species">Species:</label>
                <select id="species" name="species">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Dog</option>
                    <option value="1">Cat</option>
                </select>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Adoptable</option>
                    <option value="1">In Foster</option>
                    <option value="2">Pending</option>
                    <option value="3">Adopted</option>
                    <option value="4">Medical Hold</option>
                    <option value="5">Escaped/Lost</option>
                    <option value="6">Pending Adoption</option>
                    <option value="7">Pending Transfer</option>
                </select>
            </div>

            <div class="form-group">
                Age : <input type="text" name="age"><br><br>
            </div>

            <div class="form-group">
                Birthday : <input type="date" name="birthday" max="9999-12-31"><br><br>
            </div>

            <div class="form-group">
                <label for="intakeType">Intake Type:</label>
                <select id="intakeType" name="intakeType">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Stray</option>
                    <option value="1">External Transfer</option>
                    <option value="2">Owner Surrender</option>
                    <option value="3">Born in Care</option>
                    <option value="4">Return to Rescue</option>
                </select>
            </div>

            <div class="form-group">
                Intake Date : <input type="date" name="intakeDate" max="9999-12-31"><br><br>
            </div>

            <div class="form-group">
                <label for="condition">Condition:</label>
                <select id="condition" name="condition">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Healthy</option>
                    <option value="1">Pregnant</option>
                    <option value="2">Injured</option>
                    <option value="3">Sick</option>
                    <option value="4">Feral</option>
                </select>
            </div>

            <div class="form-group">
                Description: <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
            </div>

            <div class="form-group">
                <label for="antiRabies">with Anti Rabies:</label>
                <select id="antiRabies" name="antiRabies">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="vaccine">5-in-1 Vaccine:</label>
                <select id="vaccine" name="vaccine">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="neutered">Neutered:</label>
                <select id="neutered" name="neutered">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deticked">Deticked:</label>
                <select id="deticked" name="deticked">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dewormed">Dewormed:</label>
                <select id="dewormed" name="dewormed">
                    <option value="" disabled selected>Select</option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Select Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

         
            <input type="submit" class="" name="proceed" value="submit">
         
        </form>
    <div>
</body>
</html>