<?php
require 'connection.php';
// session_start();

function alert($title, $text, $icon, $timer = 2000) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{$icon}',
                    title: '{$title}',
                    text: '{$text}',
                    showConfirmButton: false,
                    timer: {$timer}
                });
            });
          </script>";
}

if (isset($_POST["submitAnimal"])) {
    // Validate and sanitize form inputs
    $animalName = $_POST["animalName"] ?? '';
    $species = $_POST["species"] ?? '';
    $gender = $_POST["gender"] ?? '';
    $status = $_POST["status"] ?? '';
    $age = $_POST["age"] ?? '';
    $birthday = $_POST["birthday"] ?? '';
    $intakeType = $_POST["intakeType"] ?? '';
    $intakeDate = $_POST["intakeDate"] ?? '';
    $conditions = $_POST["conditions"] ?? '';
    $description = $_POST["description"] ?? '';
    $antiRabies = $_POST["antiRabies"] ?? '';
    $vaccine = $_POST["vaccine"] ?? '';
    $neutered = $_POST["neutered"] ?? '';
    $deticked = $_POST["deticked"] ?? '';
    $dewormed = $_POST["dewormed"] ?? '';

    $newImageName = null;

    // Handle image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== 4) {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];
        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $validImageExtensions)) {
            alert('Invalid File Extension', 'Allowed extensions are .jpg, .jpeg, .png.', 'error');
        } else if ($fileSize > 10485760) {
            alert('File Too Large', 'Image size should not exceed 10MB.', 'warning');
        } else {
            $newImageName = "animals/" . uniqid() . '.' . $imageExtension;
            if (move_uploaded_file($tmpName, $newImageName)) {
                // Prepare and execute the database insertion
                $stmt = $conn->prepare("INSERT INTO animal (animalName, species, gender, status, age, birthday, intakeType, intakeDate, conditions, description, image, antiRabies, vaccine, neutered, deticked, dewormed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssssssssss", $animalName, $species, $gender, $status, $age, $birthday, $intakeType, $intakeDate, $conditions, $description, $newImageName, $antiRabies, $vaccine, $neutered, $deticked, $dewormed);

                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Successfully inserted new animal.";
                    echo "<script>window.location = '{$_SERVER['PHP_SELF']}';</script>";
                    exit; // Redirect after successful insertion
                } else {
                    alert('Oops...', 'Failed to insert post into database.', 'error');
                }
            } else {
                alert('Oops...', 'Failed to upload image.', 'error');
            }
        }
    } else {
        alert('Oops...', 'Image is required.', 'error');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .addButton {
            position: absolute;
            margin-top: 200px;
        }

        .modal-header {
            background-color: #e3896b;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <button type="button" class="btn btn-secondary addButton" data-bs-toggle="modal" data-bs-target="#animalModal">Add Animal</button>

        <!-- Modal for adding animal -->
        <div class="modal fade" id="animalModal" tabindex="-1" aria-labelledby="animalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="animalModalLabel">Add Animal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="animalForm" action="" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Image Preview -->
                                <div class="col-lg-4 mb-3">
                                    <div class="center-image mb-3">
                                        <img id="previewImage" src="https://via.placeholder.com/200" class="img-fluid rounded mb-3" alt="Preview Image">
                                    </div>
                                    <input type="file" name="image" id="animalImage" accept="image/*" class="form-control mb-3">
                                </div>
                            
                            <!-- Animal Details Section -->
                            <div class="col-lg-4">
                                <!-- <h4>Animal Details</h4> -->
                                <div class="mb-3">
                                    <label for="animalName" class="form-label">Animal Name</label>
                                    <input type="text" name="animalName" id="animalName" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="species" class="form-label">Species</label>
                                    <select name="species" id="species" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Adoptable">Adoptable</option>
                                        <option value="In Foster">In Foster</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Adopted">Adopted</option>
                                        <option value="Medical Hold">Medical Hold</option>
                                        <option value="Escaped/Lost">Escaped/Lost</option>
                                        <option value="Pending Adoption">Pending Adoption</option>
                                        <option value="Pending Transfer">Pending Transfer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" name="age" id="age" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" name="birthday" id="birthday" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="intakeType" class="form-label">Intake Type</label>
                                    <select name="intakeType" id="intakeType" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Stray">Stray</option>
                                        <option value="External Transfer">External Transfer</option>
                                        <option value="Owner Surrender">Owner Surrender</option>
                                        <option value="Born in Care">Born in Care</option>
                                        <option value="Return to Rescue">Return to Rescue</option>
                                        <option value="Abandoned">Abandoned</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="intakeDate" class="form-label">Intake Date</label>
                                    <input type="date" name="intakeDate" id="intakeDate" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            <!-- Medical Records Section -->
                            <div class="col-lg-4">
                                <!-- <h4>Medical Records</h4> -->
                                <div class="mb-3">
                                    <label for="conditions" class="form-label">Condition</label>
                                    <select name="conditions" id="conditions" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Healthy">Healthy</option>
                                        <option value="Pregnant">Pregnant</option>
                                        <option value="Injured">Injured</option>
                                        <option value="Sick">Sick</option>
                                        <option value="Feral">Feral</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="antiRabies" class="form-label">w/ Anti Rabies</label>
                                    <select name="antiRabies" id="antiRabies" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="vaccine" class="form-label">5-in-1 Vaccine</label>
                                    <select name="vaccine" id="vaccine" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="neutered" class="form-label">Neutered</label>
                                    <select name="neutered" id="neutered" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="deticked" class="form-label">Deticked</label>
                                    <select name="deticked" id="deticked" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dewormed" class="form-label">Dewormed</label>
                                    <select name="dewormed" id="dewormed" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submitAnimal" class="btn btn-secondary">Add Animal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    // Display success message if set in session
    if (isset($_SESSION['success_message'])) {
        alert('Success', $_SESSION['success_message'], 'success');
        unset($_SESSION['success_message']); // Clear the success message after displaying
    }
    ?>

 
    <script>
        // JavaScript to handle image preview
        document.getElementById('animalImage').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>
