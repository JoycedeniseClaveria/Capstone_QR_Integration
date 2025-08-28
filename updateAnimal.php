<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $animalId = intval($_POST['animalId']);
    $animalName = trim($_POST['animalName']);
    $species = trim($_POST['species']);
    $gender = trim($_POST['gender']);
    $status = trim($_POST['status']);
    $age = trim($_POST['age']);
    $birthday = trim($_POST['birthday']);
    $intakeType = trim($_POST['intakeType']);
    $intakeDate = trim($_POST['intakeDate']);
    $conditions = trim($_POST['conditions']);
    $description = trim($_POST['description']);
    $antiRabies = trim($_POST['antiRabies']);
    $vaccine = trim($_POST['vaccine']);
    $neutered = trim($_POST['neutered']);
    $deticked = trim($_POST['deticked']);
    $dewormed = trim($_POST['dewormed']);

    // SQL statement with placeholders
    $sql = "UPDATE animal SET 
            animalName = ?, 
            species = ?,
            gender = ?,
            status = ?,
            age = ?,
            birthday = ?,
            intakeType = ?,
            intakeDate = ?,
            conditions = ?,
            description = ?,
            antiRabies = ?,
            vaccine = ?,
            neutered = ?,
            deticked = ?,
            dewormed = ?
            WHERE animalId = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssssssssi", $animalName, $species, $gender, $status, $age, $birthday, $intakeType, $intakeDate, $conditions, $description, $antiRabies, $vaccine, $neutered, $deticked, $dewormed, $animalId);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_stmt_error($stmt)]);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
}

$conn->close();
?>
