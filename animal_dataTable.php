<?php
include 'connection.php';

// Read parameters sent from DataTable
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];

// Fetch total number of records without filtering
$totalQuery = "SELECT COUNT(*) AS total FROM animal";
$totalResult = $conn->query($totalQuery);
$totalData = $totalResult->fetch_assoc()['total'];

// Fetch filtered records
$query = "
    SELECT * FROM animal
    WHERE 
        animalName LIKE '%$searchValue%' OR
        gender LIKE '%$searchValue%' OR 
        status LIKE '%$searchValue%' 
    LIMIT $start, $length";

$result = $conn->query($query);

// Fetch total number of records after filtering
$filteredQuery = "
    SELECT COUNT(*) AS total 
    FROM animal
    WHERE 
        image LIKE '%$searchValue%' OR 
        animalName LIKE '%$searchValue%' OR 
        gender LIKE '%$searchValue%' OR 
        status LIKE '%$searchValue%'";
$filteredResult = $conn->query($filteredQuery);
$filteredData = $filteredResult->fetch_assoc()['total'];

// Prepare data to send back to DataTable
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Create response array
$response = [
    "draw" => intval($_POST['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($filteredData),
    "data" => $data
];

// Return response in JSON format
echo json_encode($response);

// Close connection
$conn->close();
?>
