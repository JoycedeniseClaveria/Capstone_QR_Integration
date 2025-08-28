<?php
session_start();
include 'connection.php';



if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query to fetch user based on username
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $stored_hashed_password = $user['password'];

            // Verify entered password with stored hashed password
            if (password_verify($password, $stored_hashed_password)) {
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['userId'] = $user['userId'];

                if ($user['type'] == 'admin') {
                    $_SESSION['admin_name'] = $user['firstName'];
                    $_SESSION['type'] = 'admin';
                    header('Location: adminHomepage.php');
                    exit();
                } elseif ($user['type'] == 'user') {
    $_SESSION['user_name'] = $user['firstName'];
    $_SESSION['type'] = 'user';

    if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $redirect = $_GET['redirect'];

    // Optional animalId passed
    if (isset($_GET['animalId'])) {
        $animalId = intval($_GET['animalId']);
        header("Location: $redirect?animalId=" . urlencode($animalId));
    } else {
        header("Location: $redirect");
    }
} else {
    // No redirect passed, go to default user dashboard
    header("Location: dashboardV2.php");
}
exit();

}


            } else {
                $error[] = 'Incorrect password!';
            }
        } else {
            $error[] = 'User not found!';
        }
    } else {
        $error[] = 'Error executing SQL query: ' . mysqli_error($conn);
    }
}

// Check if registration success flag is set
$registration_success = isset($_SESSION['registration_success']) ? $_SESSION['registration_success'] : false;
unset($_SESSION['registration_success']); // Clear registration success flag after use
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Include SweetAlert library and custom JavaScript -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            margin: 0px;
            text-align: center;
            background-image: url('pic6.jpg');
            backdrop-filter: blur(8px); 
            background-color: rgba(255, 255, 255, 0.5); 
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

        .register-link {
            color: #393f81;
            text-decoration: underline; /* Underline the link */
        }

        .login {
            background-color: #cc7b60;
        }

        .login:hover{
            background-color: #885240;
        }

        .containerAbi {
          background-color: #fcf3f0;
        }
    </style>
</head>
<body>

<script>
    // Script to handle registration success message
    <?php if($registration_success): ?>
        swal({
            icon: 'success',
            title: 'Welcome User!',
            text: 'You can now login',
            timer: 2500,
            showConfirmButton: false
        }).then(() => {
            window.location = "login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>";
        });
    <?php endif; ?>
</script>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card containerAbi" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="dog.jpg"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; height: 100%;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form action="" method="post">

                  <div class="d-flex justify-content-center align-items-center mb-3 pb-1">
                    <i class="f" style="color: #ff6219;"></i>
                    <img src="img/logo-modified.png" style="width: 80px; height: 90px; margin-bottom:20px;">
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="margin-top: -40px; font-weight: bold !important; text-transform: uppercase; font-size: 16px !important;">Sign into your account<br>
                    <?php
                    if(isset($error)) {
                        foreach($error as $err) {
                            echo '<span class="error-msg" style="color: red; font-size: 16px;">'.$err.'</span>';
                        }
                    }
                    ?>
                    </h5>

              
                  <div data-mdb-input-init class="input-group">
                    <label class="">Username</label>
                    <input type="text" name="username" class="" />
                  </div>

                  <div data-mdb-input-init class="input-group">
                    <label class="">Password</label>
                    <input type="password" name="password" class="" />
                  </div>
                  

                  <div class="pt-1 mb-4">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block login" type="submit" name="submit">Login</button>
                  </div>

                  <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="registration.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>"
                      style="color: #393f81;" class="register-link">Register here</a></p>
                  <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a>
                </form>



              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Include SweetAlert library and custom JavaScript -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Script to handle registration success message
    <?php if($registration_success): ?>
        swal({
            icon: 'success',
            title: 'Welcome User!',
            text: 'You can now login',
            timer: 2500,
            showConfirmButton: false
        }).then(() => {
            window.location = "login.php";
        });
    <?php endif; ?>
</script>


</body>
</html>