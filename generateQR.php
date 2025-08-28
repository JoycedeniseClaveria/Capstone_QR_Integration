<?php
include 'connection.php';
include 'vendor/phpqrcode/qrlib.php'; // QR Code library

if (!isset($_GET['animalId'])) {
    die("No animal ID provided.");
}

$animalId = intval($_GET['animalId']);

$query = "SELECT animalName, gender, status, description, image FROM animal WHERE animalId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $animalId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Animal not found.");
}

$animal = $result->fetch_assoc();


$profileUrl = "https://secaspicanlubang.com/animalProfile.php?animalId=" . $animalId;

// QR file path (auto save sa uploads/qr/)
$qrDir = "uploads/qr/";
if (!file_exists($qrDir)) {
    mkdir($qrDir, 0777, true);
}
$qrFile = $qrDir . $animal['animalName'] . "_QR.png";

// Generate QR kung wala pa
if (!file_exists($qrFile)) {
    QRcode::png($profileUrl, $qrFile, QR_ECLEVEL_L, 6);
}

// Output QR image sa browser
header('Content-Type: image/png');
readfile($qrFile);
exit;
?>
