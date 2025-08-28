<?php 
include 'connection.php'; 
include 'dashboardV1.php'; 
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fc;
        margin: 0;
        padding: 0;
    }
    
.navbar {
    margin: 0 !important;
}
    h2 {
        color: #36b9cc;
        margin-top: 30px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 28px;
    }
    .section-container {
        max-width: 1100px;
        margin: auto;
        padding: 20px;
    }

    /* Featured + Events Card Shared Style */
    .card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        margin-bottom: 20px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    .card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .card-content {
        padding: 18px;
    }
    .card-content h3 {
        font-size: 20px;
        margin-bottom: 8px;
    }
    .card-content p {
        font-size: 14px;
        color: #555;
    }

    /* Highlighted Date */
    .event-date-highlight {
        background: linear-gradient(135deg, #36b9cc, #1d8fa5);
        color: white;
        font-size: 13px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 8px;
        white-space: nowrap;
         width: 100px;
         margin-bottom: 8px;
    }


.event-date-highlight.bg-danger {
    background: #ffe0e0;
    color: #dc3545;
}


    /* Featured Animals */
    .featured-card {
        max-width: 900px;
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        height: 100%;
    }
    .featured-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .object-fit-cover {
        object-fit: cover;
    }

    /* Responsive (tablet/mobile) */
    @media (max-width: 768px) {
        .carousel-item .row,
        .event-card .row {
            flex-direction: column;
        }
        .carousel-item .col-md-5,
        .carousel-item .col-md-7,
        .event-card .col-md-5,
        .event-card .col-md-7 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .carousel-item img,
        .event-card img {
            height: auto;
        }
    }
    
    .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 225px;
    z-index: 1000;
    overflow: hidden;
}

#content-wrapper {
    margin-left: 225px;
    height: 100vh;
    overflow-y: auto;
}

@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }

    #content-wrapper {
        margin-left: 0;
        height: auto;
        overflow-y: visible;
    }
}
</style>

<div class="section-container">
    <h2 class="text-center mb-2">🐾 Featured Animals</h2>
    <p class="text-center text-muted fs-5 mb-4">
        Meet our lovely pets — <span class="fw-semibold text-primary">ready to find their forever home 🏡</span>
    </p>

<?php 
$sql = "SELECT a.animalName,  a.image AS display_image, a.description AS display_description
        FROM featured_animals f
        JOIN animal a ON f.animalId = a.animalId
        ORDER BY f.created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">';
    echo '<div class="carousel-inner">';

    $active = true;
    while ($row = $result->fetch_assoc()) {
        $activeClass = $active ? 'active' : '';
        $active = false;

        // ✅ Ayusin image path
        $imagePath = $row['display_image'];
        if (!str_contains($imagePath, '/')) {
            $imagePath = "uploads/animals/" . $imagePath;
        }

        echo "
        <div class='carousel-item $activeClass'>
            <div class='card shadow-lg mx-auto featured-card'>
                <div class='row g-0 h-100'>
                    <!-- Image Column -->
                    <div class='col-md-5'>
                        <img src='$imagePath' 
                             class='img-fluid h-100 w-100 object-fit-cover' 
                             alt='{$row['animalName']}'>
                    </div>

                    <!-- Text / Info Column -->
                    <div class='col-md-7 d-flex flex-column justify-content-center p-4'>
                        <h3 class='text-primary fw-bold'>{$row['animalName']}</h3>
                        <p class='text-muted'>{$row['display_description']}</p>
                    </div>
                </div>
            </div>
        </div>";
    }

    echo '</div>';
    echo ' <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>';
    echo '</div>';
} else {
    echo "<p class='text-center text-muted'>No featured animals yet.</p>";
}
?>
</div>

<div class="section-container">
    <h2 class="text-center mb-2">📅 Events</h2>
    <p class="text-center text-muted fs-5 mb-4">
        Stay updated with our shelter’s activities and special programs 🐶🐱
    </p>

    <div class="row">
        <!-- Upcoming Events (LEFT) -->
        <div class="col-md-6">
            <h3 class="text-primary text-center mb-3">Upcoming Events</h3>
            <?php
            $sql = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $eventImage = $row['image'] ? "uploads/events/{$row['image']}" : "uploads/events/default-event.jpg";

                    echo "
                    <div class='card shadow-lg event-card'>
                        <div class='row g-0 h-100'>
                            <!-- Image Left -->
                            <div class='col-md-5'>
                                <img src='$eventImage' 
                                     class='img-fluid h-100 w-100 object-fit-cover' 
                                     alt='{$row['title']}'>
                            </div>
                            <!-- Text Right -->
                            <div class='col-md-7 d-flex flex-column justify-content-center p-4'>
                                <span class='event-date-highlight'>
                                    <i class='fas fa-calendar-alt'></i> {$row['event_date']}
                                </span>
                                <h4 class='fw-bold text-primary mb-2'>{$row['title']}</h4>
                                <p class='text-muted'>{$row['description']}</p>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center text-muted'>No upcoming events.</p>";
            }
            ?>
        </div>

        <!-- Ended Events (RIGHT) -->
        <div class="col-md-6">
            <h3 class="text-primary text-center mb-3">Ended Events</h3>
            <?php
            $sql = "SELECT * FROM events WHERE event_date < CURDATE() ORDER BY event_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $eventImage = $row['image'] ? "uploads/events/{$row['image']}" : "uploads/events/default-event.jpg";

                    echo "
                    <div class='card shadow-lg event-card'>
                        <div class='row g-0 h-100'>
                            <!-- Image Left -->
                            <div class='col-md-5'>
                                <img src='$eventImage' 
                                     class='img-fluid h-100 w-100 object-fit-cover' 
                                     alt='{$row['title']}'>
                            </div>
                            <!-- Text Right -->
                            <div class='col-md-7 d-flex flex-column justify-content-center p-4'>
                                <span class='event-date-highlight'>
                                    <i class='fas fa-calendar-alt'></i> {$row['event_date']}
                                </span>
                                <h4 class='fw-bold text-primary mb-2'>{$row['title']}</h4>
                                <p class='text-muted'>{$row['description']}</p>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center text-muted'>No ended events.</p>";
            }
            ?>
        </div>
    </div>
</div>

</div>
