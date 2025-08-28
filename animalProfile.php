<?php
include 'connection.php';

if (!isset($_GET['animalId'])) {
    die("No animal ID provided.");
}

$animalId = intval($_GET['animalId']);
$query = "SELECT * FROM animal WHERE animalId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $animalId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Animal not found.");
}

$animal = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($animal['animalName']); ?> - Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
        }
        .profile-card {
            border-radius: 15px;
            overflow: hidden;
        }
        .profile-img {
            height: 300px;
            object-fit: cover;
            width: 100%;
        }
        .adopt-banner {
            background: linear-gradient(135deg, #ff9966, #ff5e62);
            color: white;
            text-align: center;
            padding: 40px 20px;
            border-radius: 15px;
            margin-top: 30px;
        }
        .adopt-banner h3 {
            font-weight: 600;
        }
        .adopt-banner p {
            font-size: 1.1rem;
        }
        .btn-adopt {
            background: white;
            color: #ff5e62;
            font-weight: 600;
            border-radius: 30px;
            padding: 12px 30px;
            transition: 0.3s;
        }
        .btn-adopt:hover {
            background: #ff5e62;
            color: white;
            transform: scale(1.05);
        }
        .btn-view {
            background: white;
            color: #333;
            font-weight: 600;
            border-radius: 30px;
            padding: 12px 30px;
            transition: 0.3s;
        }
        .btn-view:hover {
            background: #333;
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container my-5">

    <!-- Animal Profile Card -->
    <div class="card profile-card shadow-lg">
        <img src="<?php echo htmlspecialchars($animal['image']); ?>" class="profile-img" alt="Animal Image">
        <div class="card-body">
            <h2 class="card-title text-center mb-3"><?php echo htmlspecialchars($animal['animalName']); ?></h2>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($animal['gender']); ?></p>
                </div>
                <div class="col-md-6 mb-2">
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($animal['status']); ?></p>
                </div>
            </div>
            <p class="mt-3"><strong>Description:</strong><br>
                <?php echo nl2br(htmlspecialchars($animal['description'])); ?>
            </p>
        </div>
    </div>

    <!-- Adoption Banner -->
    <div class="adopt-banner shadow-lg">
    <?php if (strtolower($animal['status']) === 'adoptable') { ?>
        <h3>🐾 Looking for a Forever Home 🐾</h3>
        <p>Give <strong><?php echo htmlspecialchars($animal['animalName']); ?></strong> the love and care they deserve.  
        Be the reason they find a happy home today!</p>

        <?php if (isset($_SESSION['userId'])) { ?>
            <!-- ✅ Kapag naka-login, diretso sa adopt page -->
            <a href="adopt.php?animalId=<?php echo $animal['animalId']; ?>" class="btn btn-adopt mt-3">
                Adopt <?php echo htmlspecialchars($animal['animalName']); ?>
            </a>
        <?php } else { ?>
            <!-- ❌ Kapag hindi naka-login, redirect muna sa login at may dalang redirect param -->
            <a href="login.php?redirect=adopt.php&animalId=<?php echo $animal['animalId']; ?>" class="btn btn-adopt mt-3">
                Adopt <?php echo htmlspecialchars($animal['animalName']); ?>
            </a>
        <?php } ?>

    <?php } else { ?>
        <h3>🐾 Meet Our Lovely Pet 🐾</h3>
        <p><strong><?php echo htmlspecialchars($animal['animalName']); ?></strong> is currently 
        <em><?php echo htmlspecialchars($animal['status']); ?></em>.  
        But don’t worry, we have more pets waiting for a family like yours!</p>
        <a href="animalProfileV2.php" class="btn btn-view mt-3">
            View Other Pets
        </a>
    <?php } ?>
</div>


</div>

</body>
</html>
