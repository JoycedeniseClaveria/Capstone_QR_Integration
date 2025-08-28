<?php
include 'connection.php';
include 'dashboardAdmin.php';

// Check admin
if (!isset($_SESSION['userId']) || $_SESSION['type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// -----------------------------
// ADD FEATURED ANIMAL
// -----------------------------
if (isset($_POST['featureAnimal'])) {
    $animalId = $_POST['animalId'];
    $sql = "INSERT INTO featured_animals (animalId) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $animalId);
    $stmt->execute();
}

if (isset($_GET['deleteFeatured'])) {
    $id = $_GET['deleteFeatured'];
    $conn->query("DELETE FROM featured_animals WHERE id=$id");
}

// -----------------------------
// ADD EVENT
// -----------------------------
if (isset($_POST['addEvent'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $adminId = $_SESSION['userId'];

    $image = NULL;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/events/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $image);
    }

    $sql = "INSERT INTO events (title, description, event_date, image, adminId) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $event_date, $image, $adminId);
    $stmt->execute();
}

// -----------------------------
// DELETE EVENT
// -----------------------------
if (isset($_GET['deleteEvent'])) {
    $id = $_GET['deleteEvent'];
    $conn->query("DELETE FROM events WHERE eventId=$id");
}
?>

<!-- Custom Styles -->
<style>
    .section-title {
        color: #CC7B60;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    .btn-custom {
        background-color: #E8B5A3;
        border: none;
        color: #5a3b32;
        font-weight: 600;
    }
    .btn-custom:hover {
        background-color: #d89d89;
        color: white;
    }
    .card {
        border-radius: 1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .card-header {
        background: #E8B5A3 !important;
        color: #5a3b32 !important;
        font-weight: bold;
    }
    table th {
        background-color: #E8B5A3;
        color: #5a3b32;
        text-align: center;
    }
    table td {
        vertical-align: middle;
    }
</style>

<div class="container mt-4">
    <h2 class="section-title">🐾 Manage Newsfeed</h2>

    <div class="row">
        <!-- LEFT COLUMN : EVENTS (Add + Manage) -->
        <div class="col-lg-6 mb-4">
            <!-- Add Event -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Add Event</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Event Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="event_date" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Event Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" name="addEvent" class="btn btn-custom w-100">
                                <i class="fas fa-plus-circle"></i> Add Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Manage Events -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Manage Events</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['title']}</td>
                                        <td>{$row['description']}</td>
                                        <td>{$row['event_date']}</td>
                                        <td>";
                                if ($row['image']) {
                                    echo "<img src='uploads/events/{$row['image']}' width='80' class='rounded'>";
                                }
                                echo "</td>
                                        <td>
                                            <button class='btn btn-sm btn-warning mb-1' 
                                                data-bs-toggle='modal' 
                                                data-bs-target='#editEventModal{$row['eventId']}'>
                                            <i class='fas fa-edit'></i> Edit
                                        </button>

                                            <a href='?deleteEvent={$row['eventId']}' 
                                               onclick='return confirm(\"Delete this event?\")' 
                                               class='btn btn-sm btn-danger mb-1'>
                                                <i class='fas fa-trash'></i> Delete
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-muted'>No events available</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN : FEATURED ANIMALS (Add + Manage) -->
        <div class="col-lg-6 mb-4">
            <!-- Feature Animal -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Feature an Animal</h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="row g-2">
                        <div class="col-md-8">
                            <select name="animalId" class="form-select" required>
                                <option value="" disabled selected>Select adoptable animal</option>
                                <?php
                                $animals = $conn->query("SELECT animalId, animalName FROM animal WHERE status='adoptable'");
                                while ($row = $animals->fetch_assoc()) {
                                    echo "<option value='{$row['animalId']}'>{$row['animalName']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="submit" name="featureAnimal" class="btn btn-custom w-100">
                                <i class="fas fa-star"></i> Feature
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Manage Featured Animals -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Manage Featured Animals</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Animal</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $featured = $conn->query("SELECT f.id, a.animalName, a.image, a.description 
                                                  FROM featured_animals f 
                                                  JOIN animal a ON f.animalId = a.animalId");
                        if ($featured->num_rows > 0) {
                            while ($row = $featured->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['animalName']}</td>
                                        <td><img src='{$row['image']}' width='80' class='rounded'></td>
                                        <td>{$row['description']}</td>
                                        <td>
                                            <a href='?deleteFeatured={$row['id']}' 
                                               onclick='return confirm(\"Remove this featured animal?\")' 
                                               class='btn btn-sm btn-danger'>
                                               <i class='fas fa-trash'></i> Remove
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted'>No featured animals yet</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
