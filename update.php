<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header('location: loginV2.php');
    exit(); // Ensure to exit after redirection
}

// Retrieve user information from session
$userId = $_SESSION['userId'];
// $firstName = $_SESSION['firstName'];
// $lastName = $_SESSION['lastName'];

// Fetch user data based on the logged-in user's information
$query = "SELECT * FROM users WHERE userId = '$userId'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Initialize variables for user data
$row = mysqli_fetch_assoc($result); // Fetch user data

// Extract user data for form input values
$firstName = $row['firstName'];
$lastName = $row['lastName'];
$gender = $row['gender']; // Assuming 'gender' column in database (0 for Male, 1 for Female)
$birthday = $row['birthday'];
$emailAddress = $row['emailAddress'];
$contactNo = $row['contactNo'];
$maritalStatus = $row['maritalStatus'];
$citizenship = $row['citizenship'];
$location = $row['location'];

// Determine checked status for gender radio buttons
$checkedMale = ($gender == 0) ? 'checked' : '';
$checkedFemale = ($gender == 1) ? 'checked' : '';

// check status for maritalStatus 
$checkedSingle = ($maritalStatus == 0) ? 'checked' : '';
$checkedMarried = ($maritalStatus == 1) ? 'checked' : '';
$checkedWidowed = ($maritalStatus == 2) ? 'checked' : '';

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>
<h1>UPDATE TABLE</h1>
	<form action="updateInsert.php" method="POST">
			
        <label for="firstName">FirstName: </label>
        <input type="text" name="firstName" value="<?php echo $row['firstName'];?>"><br>

        <label for="lastName">LastName: </label>
        <input type="text" name="lastName" value="<?php echo $row['lastName'];?>"><br>

        <label for="gender">Gender:</label><br>
        <input type="radio" name="gender" value="0" <?php echo $checkedMale; ?>> Male
        <input type="radio" name="gender" value="1" <?php echo $checkedFemale; ?>> Female<br>

        <label for="birthday">Birthday: </label>
        <input type="date" name="birthday" value="<?php echo $row['birthday'];?>"><br>

        <label for="emailAddress">Email Address: </label>
        <input type="email" name="emailAddress" value="<?php echo $row['emailAddress'];?>"><br>

        <label for="contactNo">Contact No: </label>
        <input type="text" name="contactNo" value="<?php echo $row['contactNo'];?>"><br>

        <label for="maritalStatus">Marital Status:</label><br>
        <input type="radio" name="maritalStatus" value="0" <?php echo $checkedSingle; ?>> Single
        <input type="radio" name="maritalStatus" value="1" <?php echo $checkedMarried; ?>> Married<br>
        <input type="radio" name="maritalStatus" value="2" <?php echo $checkedWidowed; ?>> Widowed<br>

        <label for="citizenship">Citizenship: </label>
        <input type="text" name="citizenship" value="<?php echo $row['citizenship'];?>"><br>

        <label for="location">Location: </label>
        <input type="text" name="location" value="<?php echo $row['location'];?>"><br>


        <input type="submit" name="update">
    </form>
