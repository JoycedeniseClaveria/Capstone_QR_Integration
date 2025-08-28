<?php
header('Content-Type: application/json');
session_start();
require 'connection.php'; // Change this to your actual DB connection file

// Read JSON from fetch()
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!empty($data['name']) && !empty($data['email']) && !empty($data['amount']) && !empty($data['transaction_id'])) {
    
    $name           = $data['name'];
    $email          = $data['email'];
    $amount         = $data['amount'];
    $donation_date  = !empty($data['donation_date']) ? $data['donation_date'] : null;
    $message        = !empty($data['message']) ? $data['message'] : null;
    $transaction_id = $data['transaction_id'];

    // Prepare insert
    $stmt = $conn->prepare("
        INSERT INTO donations (name, email, amount, donation_date, message, transaction_id) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssdsss", $name, $email, $amount, $donation_date, $message, $transaction_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
}
?>
