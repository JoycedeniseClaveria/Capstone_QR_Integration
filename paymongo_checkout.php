<?php
include 'connection.php';
session_start();

$amount = $_GET['amount'] * 100; 

$secretKey = "sk_test_wirwhEUAwGnx5barPoVDiApG"; 

$data = [
    "data" => [
        "attributes" => [
            "amount" => $amount,
            "description" => "Order Checkout",
            "remarks" => "Payment for order",
            "currency" => "PHP",
        ]
    ]
];


$amount = $_GET['amount'] * 100; // PayMongo uses centavos
$userId = $_SESSION['userId'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/checkout_sessions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Authorization: Basic " . base64_encode("sk_test_wirwhEUAwGnx5barPoVDiApG"),
  "Content-Type: application/json"
]);

$data = [
  "data" => [
    "attributes" => [
      "line_items" => [[
        "currency" => "PHP",
        "amount" => $amount,
        "name" => "Order Payment",
        "quantity" => 1
      ]],
      "payment_method_types" => ["gcash", "card", "grab_pay"],
      "success_url" => "https://secaspicanlubang.com/paymongo_success.php",
      "cancel_url"  => "https://secaspicanlubang.com/shop.php"
    ]
  ]
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
curl_close($ch);

$res = json_decode($response, true);

if (isset($res['data']['attributes']['checkout_url'])) {
    header("Location: " . $res['data']['attributes']['checkout_url']);
    exit;
} else {
    echo "Error creating checkout session.";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

$response = curl_exec($ch);
curl_close($ch);

$res = json_decode($response, true);

if(isset($res['data']['attributes']['checkout_url'])){
    header("Location: " . $res['data']['attributes']['checkout_url']);
    exit;
} else {
    echo "Error creating PayMongo link: <pre>" . print_r($res, true) . "</pre>";
}
