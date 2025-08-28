<?php
    include 'connection.php';
    session_start();

    if(isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];

        // Query to fetch user based on username
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if($result) {
            if(mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $stored_hashed_password = $user['password'];

                // Verify entered password with stored hashed password
                if(password_verify($password, $stored_hashed_password)) {
                    if($user['type'] == 'admin') {
                        $_SESSION['admin_name'] = $user['firstName'];
                        header('Location: admin_page.php');
                        exit();
                    } elseif($user['type'] == 'user') {
                        $_SESSION['user_name'] = $user['firstName'];
                        $_SESSION['firstName'] = $user['firstName'];
                        $_SESSION['lastName'] = $user['lastName'];
                        $_SESSION['userId'] = $user['userId'];
                        header('Location: dashboard.php');
                        exit();
                    }
                } else {
                    $error[] = 'Incorrect password!';
                }
            } else {
                $error[] = 'User not found!';
            }
        } else {
            // Display SQL query error for debugging
            $error[] = 'Error executing SQL query: ' . mysqli_error($conn);
        }
    }
?>

<?php
include 'connection.php';


if(isset($_POST['submit'])) {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $emailAddress = mysqli_real_escape_string($conn, $_POST['emailAddress']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
    $citizenship = mysqli_real_escape_string($conn, $_POST['citizenship']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $type = $_POST['type'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];

    // Check if passwords match
    if($password !== $cPassword) { console.log(password);
        $error[] = 'Passwords do not match!';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $select = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $select);

        if(mysqli_num_rows($result) > 0) {
            $error[] = 'Username already exists!';
        } else {
            // Insert new user into database
            $insert = "INSERT INTO users(firstName, lastName, gender, birthday, emailAddress, contactNo, maritalStatus, citizenship, location, username, type, password) VALUES('$firstName', '$lastName', '$gender', '$birthday', '$emailAddress', '$contactNo', '$maritalStatus', '$citizenship', '$location', '$username', '$type', '$hashed_password')";
            
            if(mysqli_query($conn, $insert)) {
                echo "Registration successful!";
                header('Location: loginV2.php');
                exit();
            } else {
                $error[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="css/style.css">
   <style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 75%;
        height: 550px;
        background: url('background.jpg') no-repeat;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        border: 2px solid black;
        margin-top: 20px;
    }

    .container .logreg-box {
        position: absolute;
        background-color: black;
        top: 0;
        right: 0;
        width: calc(100% - 65%);
        height: 100%;
        overflow: hidden;
    }

    .logreg-box .form-box {
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        background: transparent;
        backdrop-filter: blur(30px);
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        color: white; 
        text-shadow: 3px 3px 10px black;
    }

    .logreg-box .form-box.login {
        transform: translateX(0);
        transition: transform .6s ease;
        transition-delay: .7s;
    }

    .logreg-box.active .form-box.login {
        transform: translateX(430px);
        transition-delay: 0s;
    }

    .form-box .input-box {
        position: relative;
        width: 340px;
        height: 50px;
        border-bottom: 2px solid white;
        margin: 30px 0;
    }

    .input-box input {
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        font-size: 16px;
        color: white;
        font-weight: 500;
        padding-right: 28px;
    }

    .input-box label {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        font-size: 16px;
        font-weight: 500;
        pointer-events: none;
        transition: .5s ease;
    }

    .input-box input:focus~label,
    .input-box input:valid~label {
        top: -5px;
    }

    .input-box .icon {
        position: absolute;
        top: 13px;
        right: 0;
        font-size: 19px;
    }

    .btn {
        width: 100%;
        height: 45px;
        background: #c4103d;
        border: none;
        outline: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        color: #e4e4e4;
        font-weight: 500;
        box-shadow: 0 0 10px rgba(0, 0, 0, .5);
    }

    .form-box .login-register {
        font-size: 14.5px;
        font-weight: 500;
        text-align: center;
        margin-top: 25px;
    }

    .login-register p a {
        color: #e4e4e4;
        font-weight: 600;
        text-decoration: none;
    }

    .login-register p a:hover {
        text-decoration: underline;
    }

    .dropdown {
        background-color: none;
    }

    .dropdown select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        appearance: none; /* Removes default styles (for modern browsers) */
        -webkit-appearance: none; /* Removes default styles (for older webkit browsers) */
        background-color: #fff;
        cursor: pointer;
    }
  
    .dropdown select:focus {
        outline: none;
        border-color: dodgerblue; /* Change border color when focused */
    }

    .logreg-box .form-box.register {
        transform: translateX(430px);
        transition: transform .6s ease;
        transition-delay: 0s;
    }

    .logreg-box.active .form-box.register {
        transform: translateX(0);
        transition-delay: .7s;
    }

    .logreg-box {
        width: 70%;
        overflow-y: scroll !important;
    }
    
   </style>
</head>
<body>
    <div class="container">
        <div class="logreg-box">
            <div class="form-box login">
                <form action="" method="post">
                    <h3>Login</h3>

                    <?php
                    if(isset($error)) {
                        foreach($error as $err) {
                            echo '<span class="error-msg">'.$err.'</span>';
                        }
                    }
                    ?>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input type="text" name="username" required>
                        <label>Username</label>
                    </div>

                    <div class="input-box">
						<span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="password" required>
						<label>Password</label>
					</div>


                    <input type="submit" name="submit" value="Login Now" class="btn" onclick="auth()" /><br><br>

                    <div class="login-register">
						<p>Don't have an account? <a href="#" class="register-link">Signup</a></p>
					</div>

                        
                        <!-- <input type="submit" name="submit" value="Login Now" class="form-btn"> -->
                        <!-- <p>Don't have an account? <a href="registration.php">Register Now</a></p> -->
                    
                </form>
            </div>

            <div class="form-box register">
                <form action="" method="post">
                    <h3>Register Now</h3>

                    <?php
                        if(isset($error)) {
                            foreach($error as $err) {
                                echo '<span class="error-msg">'.$err.'</span>';
                            }
                        }
                    ?>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <div class="input-box">
						<span class="icon"><i class='bx bxs-user-circle'></i></span>
						<input type="text" name="firstName" required>
						<label>First Name</label>
					</div>

                    <div class="input-box">
						<span class="icon"><i class='bx bxs-user-circle'></i></span>
						<input type="text" name="lastName" required>
						<label>Last Name</label>
					</div>

                    <div class="dropdown">
                        <select name="gender">
                            <option value="" disabled selected>Select</option>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                        </select>
                    </div>

                    <!-- <div class="input-box"> -->
						<input type="date" name="birthday" max="9999-12-31" required>
						<label>Birthday</label>
					<!-- </div> -->

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
						<input type="email" name="emailAddress" required>
						<label>Email Address</label>
					</div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
						<input type="tel" name="contactNo" required>
						<label>Contact No.</label>
					</div>

                    <select name="maritalStatus">
                        <option value="" disabled selected>Select</option>
                        <option value="0">Single</option>
                        <option value="1">Married</option>
                        <option value="2">Widowed</option>
                    </select>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
						<input type="text" name="citizenship" required>
						<label>Citizenship</label>
					</div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
						<input type="text" name="location" required>
						<label>Location</label>
					</div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
						<input type="text" name="username" required>
						<label>Username</label>
					</div>

                    <select name="type">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
						<input type="password" name="password" required>
						<label>Password</label>
					</div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
						<input type="password" name="cPassword" required>
						<label>Confirm Your Password</label>
					</div>

        
        <input type="submit" name="submit" value="Register Now" class="btn">
        <p>Already have an account? <a href="login.php">Login now</a></p>

        <div class="login-register">
			<p>Already have an account? <a href="#" class="login-link">Login</a></p>
		</div>
    </form>    



        </div>
    </div>

    <script>
        const logregBox = document.querySelector('.logreg-box');
        const loginLink = document.querySelector('.login-link');
        const registerLink = document.querySelector('.register-link');


        registerLink.addEventListener('click', () => {
            logregBox.classList.add('active');
        });

        loginLink.addEventListener('click', () => {
            logregBox.classList.remove('active');
        });
    </script>

</body>
</html>
