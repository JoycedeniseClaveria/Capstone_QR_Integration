<?php 
    include 'connection.php';
    include 'dashboardAdmin.php';

    if(!isset($_SESSION['userId'])){
        header('location:login.php');
        exit();
    }

    // Kunin pangalan ng admin
    $firstName = $lastName = $type = '';
    $userId = $_SESSION['userId'];
    $query = "SELECT firstName, lastName, type FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $firstName, $lastName, $type);
            mysqli_stmt_fetch($stmt);
            $welcomeMessage = ($type === 'admin') ? 
                "Welcome Admin, $firstName $lastName!" : 
                "Welcome $firstName $lastName!";
        }
        mysqli_stmt_close($stmt);
    }

    // Analytics queries
    $totalAnimals   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal"))['count'];
    $totalDogs      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal WHERE species='Dog'"))['count'];
    $totalCats      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal WHERE species='Cat'"))['count'];
    $totalAdoptable = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal WHERE status='Adoptable'"))['count'];
    $totalAdopted   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal WHERE status='Adopted'"))['count'];
    $totalPending   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal WHERE status='Pending'"))['count'];
    $maleAnimals    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal WHERE gender='Male'"))['count'];
    $femaleAnimals  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM animal WHERE gender='Female'"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; 
        background-color: #fff8f7; 
        margin:0; 
        padding:0;
        padding-bottom: 40px; 
        }
      
        .alert-success {
            background-color: #FFD1C1; 
            color: #8B4A3A; 
            border: 2px solid #E8A891; 
            font-weight: 600; 
            border-radius: 12px; 
            padding: 12px 18px; 
            text-align: center;}
        
        .row { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .col { flex: 1 1 calc(33.333% - 20px); min-width: 220px; }

        @media (max-width: 992px) {
            .col { flex: 1 1 calc(50% - 20px); }
        }
        @media (max-width: 576px) {
            .col { flex: 1 1 calc(50% - 20px); }
        }

        .card { border-radius: 20px; box-shadow: 0 6px 12px rgba(0,0,0,0.08); transition: all .3s ease; background: #ffffff; }
        .card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 10px 18px rgba(0,0,0,0.12); }
        .card .card-body { text-align: center; padding: 20px; }
        .text-title { color: #CC7B60; font-weight: 600; font-size: 1.2rem; }
        .h5 { color: #333; font-size: 1.9rem; font-weight: bold; }

        /* Charts layout */
        .charts-row { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; }
        .chart-container { background: #fff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .status-col { flex: 2; min-width: 300px; }
        .small-charts { flex: 1; display: flex; flex-direction: column; gap: 20px; min-width: 200px; }

        #statusChartContainer { height: 420px; }
        #genderChartContainer, #speciesChartContainer { height: 200px; }

        canvas { height: 100% !important; width: 100% !important; }

        /* Responsive: stack charts on smaller screens */
        @media (max-width: 768px) {
            .charts-row { flex-direction: column; }
            .status-col, .small-charts { flex: 1 1 100%; }
            .small-charts { flex-direction: row; }
            #genderChartContainer, #speciesChartContainer { flex: 1; height: 250px; }
        }
        @media (max-width: 576px) {
            .small-charts { flex-direction: column; }
            #genderChartContainer, #speciesChartContainer { height: 200px; }
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <?php if (!empty($welcomeMessage)) : ?>
        <div class="alert-success"><?php echo $welcomeMessage; ?></div>
    <?php endif; ?>
</div>

<div class="container-fluid">
    <div class="row mt-4">
        <!-- Cards -->
        <div class="col"><div class="card"><div class="card-body"><div class="text-title">Total Animals</div><div class="h5"><?php echo $totalAnimals; ?></div></div></div></div>
        <div class="col"><div class="card"><div class="card-body"><div class="text-title">Total Dogs</div><div class="h5"><?php echo $totalDogs; ?></div></div></div></div>
        <div class="col"><div class="card"><div class="card-body"><div class="text-title">Total Cats</div><div class="h5"><?php echo $totalCats; ?></div></div></div></div>
        <div class="col"><div class="card"><div class="card-body"><div class="text-title">Adoptable</div><div class="h5"><?php echo $totalAdoptable; ?></div></div></div></div>
        <div class="col"><div class="card"><div class="card-body"><div class="text-title">Adopted</div><div class="h5"><?php echo $totalAdopted; ?></div></div></div></div>
        <div class="col"><div class="card"><div class="card-body"><div class="text-title">Pending</div><div class="h5"><?php echo $totalPending; ?></div></div></div></div>
    </div>

    <!-- Charts -->
    <div class="charts-row">
        <!-- Status Chart (wider) -->
        <div class="status-col">
            <div class="chart-container" id="statusChartContainer">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <!-- Gender & Species (smaller stacked) -->
        <div class="small-charts">
            <div class="chart-container" id="genderChartContainer">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="chart-container" id="speciesChartContainer">
                <canvas id="speciesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const genderChart = new Chart(document.getElementById('genderChart'), {
    type: 'doughnut',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [<?php echo $maleAnimals; ?>, <?php echo $femaleAnimals; ?>],
            backgroundColor: ['#E8A891','#CC7B60']
        }]
    },
    options: { 
        responsive: true, 
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Gender Distribution',
                font: { size: 16, weight: 'bold' },
                color: '#333'
            }
        }
    }
});

const speciesChart = new Chart(document.getElementById('speciesChart'), {
    type: 'pie',
    data: {
        labels: ['Dogs', 'Cats'],
        datasets: [{
            data: [<?php echo $totalDogs; ?>, <?php echo $totalCats; ?>],
            backgroundColor: ['#FFD1C1','#E8A891']
        }]
    },
    options: { 
        responsive: true, 
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Species Distribution',
                font: { size: 16, weight: 'bold' },
                color: '#333'
            }
        }
    }
});

const statusChart = new Chart(document.getElementById('statusChart'), {
    type: 'bar',
    data: {
        labels: ['Adoptable', 'Adopted', 'Pending'],
        datasets: [{
            data: [<?php echo $totalAdoptable; ?>, <?php echo $totalAdopted; ?>, <?php echo $totalPending; ?>],
            backgroundColor: ['#CC7B60','#E8A891','#FFD1C1']
        }]
    },
    options: { 
        responsive: true, 
        maintainAspectRatio: false, 
        plugins: { 
            legend: { display: false },
            title: {
                display: true,
                text: 'Adoption Status',
                font: { size: 16, weight: 'bold' },
                color: '#333'
            }
        },
        scales: { y: { beginAtZero: true } }
    }
});

</script>

</body>
</html>
