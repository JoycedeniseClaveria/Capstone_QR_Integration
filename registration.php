<?php session_start(); 
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
$type = 'user';
$password = $_POST['password'];
$cPassword = $_POST['cPassword'];

    // Check if passwords match
    if ($password !== $cPassword) {
    $error[] = 'Passwords do not match!';
} else {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $select = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'Username already exists!';
    } else {
        // Insert new user into database
        $insert = "INSERT INTO users(firstName, lastName, gender, birthday, emailAddress, contactNo, maritalStatus, citizenship, location, username, type, password)
        VALUES('$firstName', '$lastName', '$gender', '$birthday', '$emailAddress', '$contactNo', '$maritalStatus', '$citizenship', '$location', '$username', '$type', '$hashed_password')";

        if (mysqli_query($conn, $insert)) {
            // Set registration success flag
            $_SESSION['registration_success'] = true;

// Redirect to login.php, preserving the redirect if available
if (isset($_GET['redirect'])) {
    $redirect = $_GET['redirect']; // no urlencode here
    header("Location: login.php?redirect=" . urlencode($redirect));
} else {
    header("Location: login.php");
}

        } else {
            $error[] = 'Registration failed. Please try again.';
        }
    }
}
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
   

    <style>
        body {
            font-family: "Poppins", sans-serif;
            margin: 0px;
            text-align: center;
            /* background-color: yellow; */
        }

        @media (min-width: 1025px) {
            .h-custom {
            height: 100vh !important;
            }
        }

        .input-group {
            margin: 10px 0px;
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            text-align: left;
            margin-bottom: 5px;
        }

        .input-group input {
            height: 30px;
            padding: 5px 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid gray;
            /* Ensure input takes full width */
            width: 100%;
            box-sizing: border-box; /* Include padding and border in width */
        }

        .submit {
            background-color: #e3896b;
        }

        .submit:hover{
            background-color: #885240;
        }
        
        .containerAbi {
          background-color: #fcf3f0;
        }

        .register-link {
            color: #393f81;
            text-decoration: underline; /* Underline the link */
        }
        

    </style>
</head>
<body>

<script>
        <?php if($registration_success): ?>
            // Display SweetAlert upon successful registration
            Swal.fire({
                icon: 'success',
                title: 'Registration successful!',
                // text: 'You can now login',
                showConfirmButton: false,
                timer: 2500 
            }).then(() => {
                
                window.location = "login.php";
            });
        <?php endif; ?>
    </script>

<section style="background-color:rgb(244, 239, 237); padding-top: 30px; padding-bottom: 100px;">


  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-8 col-xl-6">
        <div class="card rounded-3 containerAbi">
          <img src="pic5.jpg"
            class="w-100" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem; height: 40vh;"
            alt="Sample photo">
            <br>
            
       <div class="d-flex justify-content-center align-items-center mb-3 pb-1">
  <img src="img/logo-modified.png" style="width: 80px; height: 90px;">
</div>

<br><br>
          <div class="card-body p-4 p-md-5">
            <strong><h3 class="fw-normal mb-3 pb-3" style="margin-top: -100px; font-size: 18px; font-weight: bold !important; text-transform: uppercase;">Register Here</h3></strong>

            <form class="px-md-2" action="" method="post">

              <?php
                if(isset($error)) {
                  foreach($error as $err) {
                      echo '<span class="error-msg">'.$err.'</span>';
                  }
                }
              ?>

              <div data-mdb-input-init class="input-group">
                <label class="">Firstname</label>
                <input type="text" name="firstName" class="" required/>
              </div>

              <div data-mdb-input-init class="input-group">
                <label class="">Lastname</label>
                <input type="text" name="lastName" class="" required/>
              </div>

              <div data-mdb-input-init class="input-group">
                  <label for="gender">Gender</label>
                  <select id="gender" name="gender" style="height: 4vh;"required>
                      <option value="" disabled selected></option>
                      <option value="0">Male</option>
                      <option value="1">Female</option>
                  </select>
              </div>

              <div data-mdb-input-init class="input-group">
                <label class="">Birthday</label>
                <input type="date" name="birthday" max="9999-12-31" required>
              </div>

              <div data-mdb-input-init class="input-group">
                <label class="">Email Address</label>
                <input type="email" name="emailAddress" class="" required/>
              </div>

        
              <div data-mdb-input-init class="input-group">
                <label class="">Contact No.</label>
                <input type="text" id="contactNo" name="contactNo" maxlength="11" required placeholder="e.g., 09171234567" pattern="^09\d{9}$" />
<span id="contactError" style="color: red; display: none;">Invalid contact number!</span>
               
              </div>

              <div data-mdb-input-init class="input-group">
                  <label for="maritalStatus">Marital Status</label>
                  <select id="maritalStatus" name="maritalStatus" style="height: 4vh;"required>
                      <option value="" disabled selected></option>
                      <option value="0">Single</option>
                      <option value="1">Married</option>
                      <option value="2">Widowed</option>
                  </select>
              </div>

              <div data-mdb-input-init class="input-group">
                <label class="">Citizenship</label>
                <input type="text" name="citizenship" class="" required/>
              </div>

              <div data-mdb-input-init class="input-group">
                <label class="">Location</label>
                <input type="text" name="location" class="" required/>
              </div>


              <div data-mdb-input-init class="input-group">
                <label class="">Username</label>
                <input type="text" name="username" class="" required/>
              </div>

              <div data-mdb-input-init class="input-group">
                  <label for="type">Type</label>
                  <select id="type" name="type" style="height: 4vh;"required>
                    <option value="user" selected>User</option>
                    <option hidden value="admin" selected>Admin</option>
                  </select>
              </div>

              <div data-mdb-input-init class="input-group">
             
  <label class="">Password</label>
    
  <input
    type="password"
    id="password"
    name="password"
    required
    pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
    title="Password must be at least 6 characters long and contain both letters and numbers"
  />
</div>
 <small style="color: gray; font-size: 13px; margin-top: 4px; display: block;">
  The password must be alphanumeric and at least 6 characters long.
</small>
<!-- Password format error message -->
<div id="formatError" style="color: red; font-size: 14px; margin-bottom: 10px;"></div>

<div data-mdb-input-init class="input-group">
  <label class="">Confirm Your Password</label>
  <input
    type="password"
    id="cPassword"
    name="cPassword"
    class=""
    required
  />
</div>
<!-- Password match error message -->
<div id="passwordError" style="color: red; font-size: 14px; margin-bottom: 10px;"></div>

<button
  type="submit"
  name="submit"
  value="Register Now"
  data-mdb-button-init
  data-mdb-ripple-init
  class="btn btn-success btn-lg mb-1 submit"
  style="margin-bottom: 20px !important;"
>
  Submit
</button>

<p>Already have an account? <a href="login.php" class="register-link">Login now</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>


  // Philippine contact validation (client-side fallback)
  $('#contact').on('input', function () {
    this.value = this.value.replace(/[^0-9\+]/g, '').slice(0, this.value.startsWith('+63') ? 13 : 11);
  });

  $(document).ready(function () {
  // Validate contact number
  $('#contactNo').on('input', function () {
    const contact = $(this).val();
    const isValid = /^09\d{9}$/.test(contact);

    if (!isValid && contact.length > 0) {
      $('#contactError').show();
    } else {
      $('#contactError').hide();
    }
  });
});



</script>


</body>
</html>