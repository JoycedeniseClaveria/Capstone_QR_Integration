<?php
    include 'connection.php';

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);

    // Fetch user data
    $sql = "SELECT * FROM users WHERE userId = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $gender = $row["gender"] == 0 ? "Male" : "Female";
        $maritalStatus = $row["maritalStatus"] == 0 ? "Single" : ($row["maritalStatus"] == 1 ? "Married" : "Widowed");
        // echo "<p><strong>ID:</strong> " . $row["id"] . "</p>";
        echo "<p><strong>FirstName:</strong> " . $row["firstName"] . "</p>";
        echo "<p><strong>LastName:</strong> " . $row["lastName"] . "</p>";
        echo "<p><strong>Gender:</strong> " . $gender . "</p>";
        echo "<p><strong>Birthday:</strong> " . $row["birthday"] . "</p>";
        echo "<p><strong>Email Address:</strong> " . $row["emailAddress"] . "</p>";
        echo "<p><strong>Contact No:</strong> " . $row["contactNo"] . "</p>";
        echo "<p><strong>Marital Status:</strong> " . $maritalStatus . "</p>";
        echo "<p><strong>Citizenship:</strong> " . $row["citizenship"] . "</p>";
        echo "<p><strong>Location:</strong> " . $row["location"] . "</p>";
    } else {
        echo "No data found";
    }
}

$conn->close();
?>
