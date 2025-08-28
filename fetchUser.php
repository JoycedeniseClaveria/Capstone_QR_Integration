<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $draw = intval($_POST['draw']);
    $start = intval($_POST['start']);
    $length = intval($_POST['length']);
    $searchValue = $_POST['search']['value'];

    // Count total user records only (exclude admins)
    $totalQuery = $conn->query("SELECT COUNT(*) as total FROM users WHERE type='user'");
    $totalRecords = $totalQuery->fetch_assoc()['total'];

    // Base query for users only
    $query = "SELECT firstName, lastName, emailAddress, contactNo, location FROM users WHERE type='user'";

    // Filtering
    if (!empty($searchValue)) {
        $query .= " AND (firstName LIKE '%$searchValue%' 
                    OR lastName LIKE '%$searchValue%' 
                    OR emailAddress LIKE '%$searchValue%' 
                    OR contactNo LIKE '%$searchValue%' 
                    OR location LIKE '%$searchValue%')";
    }

    // Get filtered count
    $filterQuery = $conn->query($query);
    $totalFiltered = $filterQuery->num_rows;

    // Pagination
    $query .= " LIMIT $start, $length";

    $data = [];
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            $row['firstName'],
            $row['lastName'],
            $row['emailAddress'],
            $row['contactNo'],
            $row['location']
        ];
    }

    $response = [
        "draw" => $draw,
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $totalFiltered,
        "data" => $data
    ];

    echo json_encode($response);
}
