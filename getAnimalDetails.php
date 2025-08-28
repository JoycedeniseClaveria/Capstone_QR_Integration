<?php 
include 'connection.php';
require_once 'vendor/phpqrcode/qrlib.php'; // make sure naka-install ang phpqrcode

if (isset($_GET['animalId'])) {
    $animalId = intval($_GET['animalId']);
    
    $sql = "SELECT * FROM animal WHERE animalId = '$animalId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Make sure QR code folder exists
        $qrDir = "uploads/qr_codes/";
        if (!is_dir($qrDir)) {
            mkdir($qrDir, 0777, true);
        }

        // URL ng profile ng hayop
        $profileUrl = "http://localhost/capstone1/viewAnimal.php?animalId=" . $row['animalId'];
        $qrFile = $qrDir . "animal_" . $row['animalId'] . ".png";

        // Generate QR if not existing yet
        if (!file_exists($qrFile)) {
            QRcode::png($profileUrl, $qrFile, QR_ECLEVEL_L, 4);
        }

        // Prepare animal details as an associative array
        $animalDetails = array(
            'image' => htmlspecialchars($row["image"]),
            'animalName' => ($row["animalName"] !== '' && $row["animalName"] !== null) ? htmlspecialchars($row["animalName"]) : 'N/A',
            'species' => ($row["species"] !== '' && $row["species"] !== null) ? htmlspecialchars($row["species"]) : 'N/A',
            'gender' => ($row["gender"] !== '' && $row["gender"] !== null) ? htmlspecialchars($row["gender"]) : 'N/A',
            'status' => ($row["status"] !== '' && $row["status"] !== null) ? htmlspecialchars($row["status"]) : 'N/A',
            'age' => ($row["age"] !== '' && $row["age"] !== null) ? htmlspecialchars($row["age"]) : 'N/A',
            'birthday' => ($row["birthday"] != '0000-00-00') ? htmlspecialchars($row["birthday"]) : 'N/A',
            'intakeType' => ($row["intakeType"] !== '' && $row["intakeType"] !== null) ? htmlspecialchars($row["intakeType"]) : 'N/A',
            'intakeDate' => ($row["intakeDate"] != '0000-00-00') ? htmlspecialchars($row["intakeDate"]) : 'N/A',
            'description' => ($row["description"] !== '' && $row["description"] !== null) ? htmlspecialchars($row["description"]) : 'N/A',
            'conditions' => ($row["conditions"] !== '' && $row["conditions"] !== null) ? htmlspecialchars($row["conditions"]) : 'N/A',
            'antiRabies' => ($row["antiRabies"] !== '' && $row["antiRabies"] !== null) ? htmlspecialchars($row["antiRabies"]) : 'N/A',
            'vaccine' => ($row["vaccine"] !== '' && $row["vaccine"] !== null) ? htmlspecialchars($row["vaccine"]) : 'N/A',
            'neutered' => ($row["neutered"] !== '' && $row["neutered"] !== null) ? htmlspecialchars($row["neutered"]) : 'N/A',
            'deticked' => ($row["deticked"] !== '' && $row["deticked"] !== null) ? htmlspecialchars($row["deticked"]) : 'N/A',
            'dewormed' => ($row["dewormed"] !== '' && $row["dewormed"] !== null) ? htmlspecialchars($row["dewormed"]) : 'N/A',
            
            // ✅ Add QR Code path
            'qr_code' => $qrFile
        );

        echo json_encode($animalDetails);
    } else {
        echo json_encode(['error' => 'Animal details not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid animalId.']);
}

$conn->close();
?>
