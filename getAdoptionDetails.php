<?php
include 'connection.php';

// Check if animalId is provided via GET request
if (isset($_GET['adoptionId'])) {
    $adoptionId = $_GET['adoptionId'];
    
    // Fetch animal details based on animalId
    // $sql = "SELECT * FROM adoption WHERE adoptionId = '$adoptionId'";
    $sql = "SELECT a.*, b.image FROM adoption a 
    INNER JOIN animal b ON a.animalName = b.animalName
    WHERE a.adoptionId = '$adoptionId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Prepare animal details as an associative array
        $adoptionDetails = array(
            'image' => htmlspecialchars($row["image"]),
            'animalName' => ($row["animalName"] !== '' && $row["animalName"] !== null) ? htmlspecialchars($row["animalName"]) : 'N/A',
            'applicationDate' => ($row["applicationDate"] !== '' && $row["applicationDate"] !== null) ? htmlspecialchars($row["applicationDate"]) : 'N/A',
            'name' => ($row["name"] !== '' && $row["name"] !== null) ? htmlspecialchars($row["name"]) : 'N/A',
            'age' => ($row["age"] !== '' && $row["age"] !== null) ? htmlspecialchars($row["age"]) : 'N/A',
            'emailAddress' => ($row["emailAddress"] !== '' && $row["emailAddress"] !== null) ? htmlspecialchars($row["emailAddress"]) : 'N/A',
            'location' => ($row["location"] !== '' && $row["location"] !== null) ? htmlspecialchars($row["location"]) : 'N/A',
            'contactNo' => ($row["contactNo"] !== '' && $row["contactNo"] !== null) ? htmlspecialchars($row["contactNo"]) : 'N/A',
            'profession' => ($row["profession"] !== '' && $row["profession"] !== null) ? htmlspecialchars($row["profession"]) : 'N/A',
            'fbName' => ($row["fbName"] !== '' && $row["fbName"] !== null) ? htmlspecialchars($row["fbName"]) : 'N/A',
            'fbLink' => ($row["fbLink"] !== '' && $row["fbLink"] !== null) ? htmlspecialchars($row["fbLink"]) : 'N/A',
            'data1' => ($row["data1"] !== '' && $row["data1"] !== null) ? htmlspecialchars($row["data1"]) : 'N/A',
            'data2' => ($row["data2"] !== '' && $row["data2"] !== null) ? htmlspecialchars($row["data2"]) : 'N/A',
            'data3' => ($row["data3"] !== '' && $row["data3"] !== null) ? htmlspecialchars($row["data3"]) : 'N/A',
            'data4' => ($row["data4"] !== '' && $row["data4"] !== null) ? htmlspecialchars($row["data4"]) : 'N/A',
            'data5' => ($row["data5"] !== '' && $row["data5"] !== null) ? htmlspecialchars($row["data5"]) : 'N/A',
            'data6' => ($row["data6"] !== '' && $row["data6"] !== null) ? htmlspecialchars($row["data6"]) : 'N/A',
            'data7' => ($row["data7"] !== '' && $row["data7"] !== null) ? htmlspecialchars($row["data7"]) : 'N/A',
            'data8' => ($row["data8"] !== '' && $row["data8"] !== null) ? htmlspecialchars($row["data8"]) : 'N/A',
            'data9' => ($row["data9"] !== '' && $row["data9"] !== null) ? htmlspecialchars($row["data9"]) : 'N/A',
            'data10' => ($row["data10"] !== '' && $row["data10"] !== null) ? htmlspecialchars($row["data10"]) : 'N/A',
            'data11' => ($row["data11"] !== '' && $row["data11"] !== null) ? htmlspecialchars($row["data11"]) : 'N/A',
            'data12' => ($row["data12"] !== '' && $row["data12"] !== null) ? htmlspecialchars($row["data12"]) : 'N/A',
            'data13' => ($row["data13"] !== '' && $row["data13"] !== null) ? htmlspecialchars($row["data13"]) : 'N/A',
            'data14' => ($row["data14"] !== '' && $row["data14"] !== null) ? htmlspecialchars($row["data14"]) : 'N/A',
            'data15' => ($row["data15"] !== '' && $row["data15"] !== null) ? htmlspecialchars($row["data15"]) : 'N/A',
            'data16' => ($row["data16"] !== '' && $row["data16"] !== null) ? htmlspecialchars($row["data16"]) : 'N/A',
            'data17' => ($row["data17"] !== '' && $row["data17"] !== null) ? htmlspecialchars($row["data17"]) : 'N/A',
            'data18' => ($row["data18"] !== '' && $row["data18"] !== null) ? htmlspecialchars($row["data18"]) : 'N/A',
            'data19' => ($row["data19"] !== '' && $row["data19"] !== null) ? htmlspecialchars($row["data19"]) : 'N/A',
            'data20' => ($row["data20"] !== '' && $row["data20"] !== null) ? htmlspecialchars($row["data20"]) : 'N/A',
            'data21' => ($row["data21"] !== '' && $row["data21"] !== null) ? htmlspecialchars($row["data21"]) : 'N/A',
            'data22' => ($row["data22"] !== '' && $row["data22"] !== null) ? htmlspecialchars($row["data22"]) : 'N/A',
            'data23' => ($row["data23"] !== '' && $row["data23"] !== null) ? htmlspecialchars($row["data23"]) : 'N/A',
            'data24' => ($row["data24"] !== '' && $row["data24"] !== null) ? htmlspecialchars($row["data24"]) : 'N/A',
            'data25' => ($row["data25"] !== '' && $row["data25"] !== null) ? htmlspecialchars($row["data25"]) : 'N/A',
            'data26' => ($row["data26"] !== '' && $row["data26"] !== null) ? htmlspecialchars($row["data26"]) : 'N/A',
            'data27' => ($row["data27"] !== '' && $row["data27"] !== null) ? htmlspecialchars($row["data27"]) : 'N/A',
            'data28' => ($row["data28"] !== '' && $row["data28"] !== null) ? htmlspecialchars($row["data28"]) : 'N/A',
            'data29' => ($row["data29"] !== '' && $row["data29"] !== null) ? htmlspecialchars($row["data29"]) : 'N/A',
            'data30' => ($row["data30"] !== '' && $row["data30"] !== null) ? htmlspecialchars($row["data30"]) : 'N/A',
            'data31' => ($row["data31"] !== '' && $row["data31"] !== null) ? htmlspecialchars($row["data31"]) : 'N/A',

        );

        // Encode the array as JSON and output it
        echo json_encode($adoptionDetails);
    } else {
        echo json_encode(['error' => 'Adoption details not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid adoptionId.']);
}

// Close database connection
$conn->close();
?>
