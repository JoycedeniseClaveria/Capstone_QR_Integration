<?php
include 'connection.php';
include 'vendor/phpqrcode/qrlib.php'; // include QR library

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animalName = $_POST['animalName'];
    $species = $_POST['species'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $intakeType = $_POST['intakeType'];
    $intakeDate = $_POST['intakeDate'];
    $conditions = $_POST['conditions'];
    $description = $_POST['description'];
    $antiRabies = $_POST['antiRabies'];
    $vaccine = $_POST['vaccine'];
    $neutered = $_POST['neutered'];
    $deticked = $_POST['deticked'];
    $dewormed = $_POST['dewormed'];

    // Upload Image
    $imagePath = "";
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $targetDir = "uploads/animals/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath;
        }
    }

    // Insert animal into DB
    $query = "INSERT INTO animals (animalName, species, gender, status, age, birthday, intakeType, intakeDate, conditions, description, antiRabies, vaccine, neutered, deticked, dewormed, image) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssisssssssssss", $animalName, $species, $gender, $status, $age, $birthday, $intakeType, $intakeDate, $conditions, $description, $antiRabies, $vaccine, $neutered, $deticked, $dewormed, $imagePath);

    if ($stmt->execute()) {
        $animalId = $stmt->insert_id; // bagong ID ng animal

        // ✅ Generate QR Code
        $qrDir = "uploads/qr/";
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0777, true);
        }

        // URL na nasa QR (profile page ng animal)
        $profileUrl = "https://secaspicanlubang.com/animalProfile.php?animalId=" . $animalId;

        // ✅ Filename base sa animalId
        $qrFile = $qrDir . $animalId . "_QR.png";

        QRcode::png($profileUrl, $qrFile, QR_ECLEVEL_L, 6);

        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
}
?>
