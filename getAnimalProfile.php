<?php
include 'connection.php';

if (isset($_GET['animalId'])) {
    $animalId = intval($_GET['animalId']);

    $sql = "SELECT * FROM animal WHERE animalId = $animalId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>


<?php
//     include 'connection.php';

// if (isset($_GET['animalId'])) {
//     $animalId = intval($_GET['animalId']);

//     // Fetch user data
//     $sql = "SELECT * FROM animal WHERE animalId = $animalId";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();

//         // $gender = $row["gender"] == 0 ? "Male" : "Female";
//         // $maritalStatus = $row["maritalStatus"] == 0 ? "Single" : ($row["maritalStatus"] == 1 ? "Married" : "Widowed");
//         // echo "<p><strong>ID:</strong> " . $row["id"] . "</p>";
//         echo "<p><strong>:</strong><br><img src='" .$row["image"] . "' alt='Animal Image'/></p>";
//         echo "<p><strong>Animal Name:</strong> " . $row["animalName"] . "</p>";
//         echo "<p><strong>Species:</strong> " . $row["species"] . "</p>";
//         echo "<p><strong>Breed:</strong> " . (isset($row["breed"]) && !empty($row["breed"]) ? htmlspecialchars($row["breed"]) : "N/A") . "</p>";
//         echo "<p><strong>Gender:</strong> " . (isset($row["gender"]) && !empty($row["gender"]) ? htmlspecialchars($row["gender"]) : "N/A") . "</p>";
//         echo "<p><strong>Status:</strong> " . (isset($row["status"]) && !empty($row["status"]) ? htmlspecialchars($row["status"]) : "N/A") . "</p>";
//         echo "<p><strong>Age:</strong> " . (isset($row["age"]) && !empty($row["age"]) ? htmlspecialchars($row["age"]) : "N/A") . "</p>";
//         echo "<p><strong>Birthday:</strong> " . (isset($row["birthday"]) && $row["birthday"] != '0000-00-00' ? htmlspecialchars($row["birthday"]) : "N/A") . "</p>";
//         echo "<p><strong>Intake Type:</strong> " . (isset($row["intakeType"]) && !empty($row["intakeType"]) ? htmlspecialchars($row["intakeType"]) : "N/A") . "</p>";
//         echo "<p><strong>Intake Date:</strong> " . (isset($row["intakeDate"]) && $row["intakeDate"] != '0000-00-00' ? htmlspecialchars($row["intakeDate"]) : "N/A") . "</p>";
//         echo "<p><strong>Condition:</strong> " . (isset($row["conditions"]) && !empty($row["conditions"]) ? htmlspecialchars($row["conditions"]) : "N/A") . "</p>";
//         echo "<p><strong>Description:</strong> " . (isset($row["description"]) && !empty($row["description"]) ? htmlspecialchars($row["description"]) : "N/A") . "</p>";
//         echo "<p><strong>w/ Anti Rabies:</strong> " . (isset($row["antiRabies"]) && !empty($row["antiRabies"]) ? htmlspecialchars($row["antiRabies"]) : "N/A") . "</p>";
//         echo "<p><strong>w/ Vaccine:</strong> " . (isset($row["vaccine"]) && !empty($row["vaccine"]) ? htmlspecialchars($row["vaccine"]) : "N/A") . "</p>";
//         echo "<p><strong>Neutered:</strong> " . (isset($row["neutered"]) && !empty($row["neutered"]) ? htmlspecialchars($row["neutered"]) : "N/A") . "</p>";
//         echo "<p><strong>Deticked:</strong> " . (isset($row["deticked"]) && !empty($row["deticked"]) ? htmlspecialchars($row["deticked"]) : "N/A") . "</p>";
//         echo "<p><strong>Dewormed:</strong> " . (isset($row["dewormed"]) && !empty($row["dewormed"]) ? htmlspecialchars($row["dewormed"]) : "N/A") . "</p>";

//     } else {
//         echo "No data found";
//     }
// }

// $conn->close();
?>
