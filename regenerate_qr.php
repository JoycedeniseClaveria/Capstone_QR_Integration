
<?php
include 'connection.php';
require 'vendor/phpqrcode/qrlib.php';

$qrDir = "uploads/qr/";
if (!file_exists($qrDir)) {
    mkdir($qrDir, 0777, true);
}

$query = "SELECT animalId FROM animal";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $animalId = $row['animalId'];
    $qrFile = $qrDir . $animalId . "_QR.png";

    // Generate kung wala pa
    if (!file_exists($qrFile)) {
        $qrContent = "https://secaspicanlubang.com/animalProfile.php?animalId=" . $animalId;
        QRcode::png($qrContent, $qrFile, QR_ECLEVEL_L, 10);
        echo "Generated QR for Animal ID: $animalId <br>";
    }
}
?>
