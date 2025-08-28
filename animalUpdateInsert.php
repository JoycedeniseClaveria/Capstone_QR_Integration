<?php
include 'connection.php';

$speciesFilter = isset($_GET['species']) ? $_GET['species'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Fetch data from the database
$sql = "SELECT * FROM animal WHERE 1";

// Add WHERE condition for species if filter is provided
if (!empty($speciesFilter)) {
    $sql .= " AND species = '$speciesFilter'";
}

if (!empty($statusFilter)) {
    $sql .= " AND status = '$statusFilter'";
}

$result = $conn->query($sql);

?>
<!-- 
if ($result && $result->num_rows > 0) {
  
    while ($row = $result->fetch_assoc()) {

        echo '<div class="card">';
        echo '<img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top" alt="Animal Image" style="height: 30vh;">';
        echo '<div class="card-body text-center">';
        echo '<h5 class="card-title mb-2" style="font-weight: bold; font-size: 17px;">' . $row["animalName"] . '</h5>';
        echo '<p class="card-text mb-1" style="font-size: 15px;"> ' . ($row["gender"] == "Male" ? 'Male' : 'Female') . '</p>';
        echo '<p class="card-text"><span class="badge badge-warning">' . $row["status"] . '</span></p>';
        echo '<button class="btn btn-primary" onclick="showAnimalDetails(' . $row["animalId"] . ')">Update</button>'; // Button to trigger modal
        echo '</div>';
        echo '</div>';

    }
} else {
    echo '<p class="text-muted" style="text-align: center; margin-top: 20px; color: #6c757d;">No matching records found.</p>';
}




// Close database connection
$conn->close();
?> -->
<html>
<head>
    <!-- Include Bootstrap CSS -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .container-fluid {
            font-family: "Poppins", sans-serif;
            justify-content: justify;
        }

        .modal-body {
            text-align: justify;
        }

        .modal-body p,
        .modal-body span {
            text-align: justify;
        }

        @media (min-width: 576px) {
            /* Small devices (sm) and up */
            .modal-content {
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {
            /* Extra small devices (xs) */
            .modal-content {
                width: 100%;
            }
        }

        @media (min-width: 481px) {
            /* Small devices (sm) and up */
            .modal-content {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            /* Extra small devices (xs) */
            .modal-content {
                width: 100%;
            }
        }

        @media (min-width: 769px) {
            /* Small devices (sm) and up */
            .modal-content {
                width: 100%;
            }
        }

        @media (max-width: 1024px) {
            /* Extra small devices (xs) */
            .modal-content {
                width: 100%;
            }
        }

        th {
            text-align: center;
        }

        tr {
            text-align: center;
        }

        .table {
            width: 1200px;
            /* border: 2px solid gray; */
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <div class="container" style="height: 250px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Animal Image</th>
                        <th>Animal Name</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($row["image"]); ?>" class="card-img-top" alt="Animal Image" style="height: 15vh; width: 150px;"></td>
                                <td><?php echo $row["animalName"]; ?></td>
                                <td><?php echo ($row["gender"] == "Male" ? 'Male' : 'Female'); ?></td>
                                <td><span class="badge badge-warning"><?php echo $row["status"]; ?></span></td>
                                <td><button class="btn btn-primary" onclick="showAnimalDetails(<?php echo $row["animalId"]; ?>)">Update</button></td>
                            </tr>
                            <?php 
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-muted" style="text-align: center;">No matching records found.</td>
                        </tr>
                        <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>





<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




</script>
</body>
</html>
