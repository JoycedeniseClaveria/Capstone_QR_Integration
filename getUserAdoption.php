<?php
include 'connection.php';

if (isset($_GET['adoptionId'])) {
    $adoptionId = intval($_GET['adoptionId']);

    $sql = "SELECT *, adoption.age FROM adoption 
            INNER JOIN animal ON adoption.animalName = animal.animalName
            WHERE adoption.adoptionId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $adoptionId);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <style>
    .modal-body {
        color: black; 
    }
    .question {
        font-weight: bold;
    }
</style>

                <div class="container-fluid">
                    <div class="row">
                        <!-- Left Side: Image + Info -->
                        <div class="col-md-4 mb-3 text-center">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                                 class="img-fluid rounded shadow-sm mb-3" 
                                 alt="Animal Image" style="max-height:250px; object-fit:cover;">

                            <h4 class="fw-bold"><?php echo htmlspecialchars($row['animalName']); ?></h4>

                            <div class="card shadow-sm text-start">
                                <div class="card-body text-start">
                                    <p><strong>Application Date:</strong> <?php echo htmlspecialchars($row['applicationDate']); ?></p>
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                                    <p><strong>Age:</strong> <?php echo htmlspecialchars($row['age']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['emailAddress']); ?></p>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                                    <p><strong>Contact No:</strong> <?php echo htmlspecialchars($row['contactNo']); ?></p>
                                    <p><strong>Profession:</strong> <?php echo htmlspecialchars($row['profession']); ?></p>
                                    <p><strong>Facebook Name:</strong> <?php echo htmlspecialchars($row['fbName']); ?></p>
                                    <p><strong>Facebook Link:</strong> <?php echo htmlspecialchars($row['fbLink']); ?></p>
                                </div>

                            </div>
                        </div>

                        <!-- Right Side: Questions -->
                        <div class="col-md-8">
                            <div class="row">
                                <?php 
                                $questions = [
                                    1 => "Why did you decide to adopt an animal?",
                                    2 => "Have you adopted from us before?",
                                    3 => "If YES, when? (N/A if otherwise)",
                                    4 => "What type of residence do you live in?",
                                    5 => "Is the residence for RENT?",
                                    6 => "Who do you live with? Please be specific.",
                                    7 => "How long have you lived in the address registered here?",
                                    8 => "Are you planning to move in the next six (6) months?",
                                    9 => "If YES, where? (N/A if otherwise)",
                                    10 => "Will the whole family be involved in the care of the animal?",
                                    11 => "If NO, please explain. (N/A if otherwise)",
                                    12 => "Is there anyone in your household who has objection(s)?",
                                    13 => "If YES, please explain. (N/A if otherwise)",
                                    14 => "Are there any children who visit your home frequently?",
                                    15 => "Are there any other regular visitors?",
                                    16 => "Are there any member of your household who has an allergy?",
                                    17 => "If YES, who? (N/A if otherwise)",
                                    18 => "What will happen to this animal if you move unexpectedly?",
                                    19 => "What kind of behavior(s) of the dog you cannot accept?",
                                    20 => "How many hours will your pet spend without a human?",
                                    21 => "What will happen to your pet if you go on vacation?",
                                    22 => "Do you have a regular veterinarian?",
                                    23 => "If YES, provide info (N/A if otherwise)",
                                    24 => "Do you have other companion animals?",
                                    25 => "If YES, specify what type and number (N/A if otherwise)",
                                    26 => "In which part of the house will the animal stay?",
                                    27 => "Where will the animal be kept (day/night)?",
                                    28 => "Do you have a fenced yard? (Height and type, N/A if otherwise)",
                                    29 => "If NO fence, how will you handle dog's exercise/toilet?",
                                    30 => "If adopting a cat, where will the litter box be kept? (N/A if otherwise)"
                                ];
                            
                                for ($i = 1; $i <= 30; $i++) {
                                    $dataField = "data" . $i;
                                    echo '<div class="col-md-6 mb-3 d-flex">';
                                    echo '  <div class="w-100">';
                                  
                                    echo "      <p class='fw-bold text-black mb-1'>$i. {$questions[$i]}</p>";
                                   
                                    echo '      <div class="border rounded p-2 bg-white shadow-sm" style="min-height:80px; color:#000; font-weight:normal;">';
                                    echo            !empty($row[$dataField]) ? htmlspecialchars($row[$dataField]) : '';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                                                            ?>
                            </div>

                        </div>
                    </div>
                </div>

                <?php
            } else {
                echo "No data found";
            }
        } else {
            echo "Error executing SQL statement: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing SQL statement: " . mysqli_error($conn);
    }
}
$conn->close();
?>
