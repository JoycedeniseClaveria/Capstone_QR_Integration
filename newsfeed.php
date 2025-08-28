<?php 
  session_start();
  include 'connection.php';

  try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->query("SELECT * FROM newsfeed ORDER BY postTime DESC");
  $newsfeed = $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // Check for success message in session and then unset it
if (isset($_SESSION['success_message'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: '" . $_SESSION['success_message'] . "',
              showConfirmButton: false,
              timer: 2000
            });
          });
        </script>";
  unset($_SESSION['success_message']); // Unset session variable after displaying message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>NewsFeed</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* Custom scrollbar styles */
    .scrollable-container {
        width: 50%;
        max-height: 630px;
        overflow-y: auto;
        scrollbar-width: none; /* "auto" for Firefox */
    }

    .scrollable-container::-webkit-scrollbar {
        width: 8px; /* Width of the scrollbar */
    }

    .scrollable-container::-webkit-scrollbar-track {
        background: #f1f1f1; /* Color of the scrollbar track */
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background-color: #888; /* Color of the scrollbar thumb */
        border-radius: 4px; /* Rounded corners of the scrollbar thumb */
    }

    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background-color: #555; /* Color of the scrollbar thumb on hover */
    }
</style>

</head>

<body>
  <div class="container mt-5 scrollable-container">
    <?php foreach ($newsfeed as $post): ?>
    <div class="card mb-4" >
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($post['username']) ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?= $post['postTime'] ?></h6>
            <p class="card-text"><?= htmlspecialchars($post['postText']) ?></p>
            <?php
              // Assuming `$post['id']` is the identifier linking to the image
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $stmt = $conn->prepare("SELECT image FROM newsfeed WHERE id = :id"); // Adjust the query to select only the relevant image
              $stmt->execute(['id' => $post['id']]);
              $image = $stmt->fetch(PDO::FETCH_ASSOC);
              if ($image && $image['image']) {
                  echo '<img src="' . htmlspecialchars($image['image']) . '" class="img-fluid">';
              }
            ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>




<!--Section: Newsfeed-->
<!-- <section>
  <div class="card" style="max-width: 42rem">
    <div class="card-body"> -->
      <!-- Data -->
      <!-- <div class="d-flex mb-3">
        <a href="">
          <img src="https://mdbcdn.b-cdn.net/img/new/avatars/18.webp" class="border rounded-circle me-2"
            alt="Avatar" style="height: 40px" />
        </a>
        <div>
          <a href="" class="text-dark mb-0">
            <strong>Anna Doe</strong>
          </a>
          <a href="" class="text-muted d-block" style="margin-top: -6px">
            <small>10h</small>
          </a>
        </div>
      </div> -->
      <!-- Description -->
      <!-- <div>
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing
          elit. Atque ex non impedit corporis sunt nisi nam fuga
          dolor est, saepe vitae delectus fugit, accusantium qui
          nulla aut adipisci provident praesentium?
        </p>
      </div>
    </div> -->
    <!-- Media -->
    <!-- <div class="bg-image hover-overlay ripple rounded-0" data-mdb-ripple-color="light">
      <img src="https://mdbcdn.b-cdn.net/img/new/standard/people/077.webp" class="w-100" />
      <a href="#!">
        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
      </a>
    </div> -->
    <!-- Media -->
    <!-- Interactions -->
    <!-- <div class="card-body"> -->
      <!-- Reactions -->
      <!-- <div class="d-flex justify-content-between mb-3"> -->
        <!-- <div>
          <a href="">
            <i class="fas fa-thumbs-up text-primary"></i>
            <i class="fas fa-heart text-danger"></i>
            <span>124</span>
          </a>
        </div>
        <div>
          <a href="" class="text-muted"> 8 comments </a>
        </div>
      </div> -->
      <!-- Reactions -->

      <!-- Buttons -->
      <!-- <div class="d-flex justify-content-between text-center border-top border-bottom mb-4">
        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-lg" data-mdb-ripple-color="dark">
          <i class="fas fa-thumbs-up me-2"></i>Like
        </button>
        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-lg" data-mdb-ripple-color="dark">
          <i class="fas fa-comment-alt me-2"></i>Comment
        </button>
        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-lg" data-mdb-ripple-color="dark">
          <i class="fas fa-share me-2"></i>Share
        </button>
      </div> -->
      <!-- Buttons -->

      <!-- Comments -->

      <!-- Input -->
      <!-- <div class="d-flex mb-3">
        <a href="">
          <img src="https://mdbcdn.b-cdn.net/img/new/avatars/18.webp" class="border rounded-circle me-2"
            alt="Avatar" style="height: 40px" />
        </a>
        <div data-mdb-input-init class="form-outline w-100">
          <textarea class="form-control" id="textAreaExample" rows="2"></textarea>
          <label class="form-label" for="textAreaExample">Write a comment</label>
        </div>
      </div> -->
      <!-- Input -->

      <!-- Answers -->

      <!-- Single answer -->
      <!-- <div class="d-flex mb-3">
        <a href="">
          <img src="https://mdbcdn.b-cdn.net/img/new/avatars/8.webp" class="border rounded-circle me-2"
            alt="Avatar" style="height: 40px" />
        </a>
        <div>
          <div class="bg-body-tertiary rounded-3 px-3 py-1">
            <a href="" class="text-dark mb-0">
              <strong>Malcolm Dosh</strong>
            </a>
            <a href="" class="text-muted d-block">
              <small>Lorem ipsum dolor sit amet consectetur,
                adipisicing elit. Natus, aspernatur!</small>
            </a>
          </div>
          <a href="" class="text-muted small ms-3 me-2"><strong>Like</strong></a>
          <a href="" class="text-muted small me-2"><strong>Reply</strong></a>
        </div>
      </div> -->

      <!-- Single answer -->
      <!-- <div class="d-flex mb-3">
        <a href="">
          <img src="https://mdbcdn.b-cdn.net/img/new/avatars/5.webp" class="border rounded-circle me-2"
            alt="Avatar" style="height: 40px" />
        </a>
        <div>
          <div class="bg-body-tertiary rounded-3 px-3 py-1">
            <a href="" class="text-dark mb-0">
              <strong>Rhia Wallis</strong>
            </a>
            <a href="" class="text-muted d-block">
              <small>Et tempora ad natus autem enim a distinctio
                quaerat asperiores necessitatibus commodi dolorum
                nam perferendis labore delectus, aliquid placeat
                quia nisi magnam.</small>
            </a>
          </div>
          <a href="" class="text-muted small ms-3 me-2"><strong>Like</strong></a>
          <a href="" class="text-muted small me-2"><strong>Reply</strong></a>
        </div>
      </div> -->

      <!-- Single answer -->
      <!-- <div class="d-flex mb-3">
        <a href="">
          <img src="https://mdbcdn.b-cdn.net/img/new/avatars/6.webp" class="border rounded-circle me-2"
            alt="Avatar" style="height: 40px" />
        </a>
        <div>
          <div class="bg-body-tertiary rounded-3 px-3 py-1">
            <a href="" class="text-dark mb-0">
              <strong>Marcie Mcgee</strong>
            </a>
            <a href="" class="text-muted d-block">
              <small>
                Officia asperiores autem sit rerum architecto a
                deserunt doloribus obcaecati, velit ab at, ad
                delectus sapiente! Voluptatibus quaerat suscipit
                in nostrum necessitatibus illum nemo quo beatae
                obcaecati quidem optio fugit ipsam distinctio,
                illo repellendus porro sequi alias perferendis ea
                soluta maiores nisi eligendi? Mollitia debitis
                quam ex, voluptates cupiditate magnam
                fugiat.</small>
            </a>
          </div>
          <a href="" class="text-muted small ms-3 me-2"><strong>Like</strong></a>
          <a href="" class="text-muted small me-2"><strong>Reply</strong></a>
        </div>
      </div> -->

      <!-- Single answer -->
      <!-- <div class="d-flex mb-3">
        <a href="">
          <img src="https://mdbcdn.b-cdn.net/img/new/avatars/10.webp" class="border rounded-circle me-2"
            alt="Avatar" style="height: 40px" />
        </a>
        <div>
          <div class="bg-body-tertiary rounded-3 px-3 py-1">
            <a href="" class="text-dark mb-0">
              <strong>Hollie James</strong>
            </a>
            <a href="" class="text-muted d-block">
              <small>Voluptatibus quaerat suscipit in nostrum
                necessitatibus</small>
            </a>
          </div>
          <a href="" class="text-muted small ms-3 me-2"><strong>Like</strong></a>
          <a href="" class="text-muted small me-2"><strong>Reply</strong></a>
        </div>
      </div> -->

      <!-- Answers -->

      <!-- Comments -->
    </div>
    <!-- Interactions -->
  </div>
</section>
<!--Section: Newsfeed-->

<!-- post form  -->
<!-- <form action="post.php" method="POST">
  <div class="mb-3">
    <label for="userName" class="form-label">Username:</label>
    <input type="text" class="form-control" id="userName" name="userName" required>
  </div>
  <div class="mb-3">
    <label for="postText" class="form-label">Post:</label>
    <textarea class="form-control" id="postText" name="postText" rows="3" required></textarea>
  </div> -->
  <!-- <div class="mb-3">
    <label for="image" class="form-label">Image URL (optional):</label>
    <input type="text" class="form-control" id="image" name="image">
  </div> -->
  <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="image" class="form-label">Select image to upload:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</form> -->


<!-- Button to trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">
  POST NOW
</button>

<!-- Modal -->
<form action="post.php" method="POST">
<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="postModalLabel">Create Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form inside modal -->
        <!-- <form action="post.php" method="POST" enctype="multipart/form-data"> -->
          <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="postText" class="form-label">Post:</label>
            <textarea class="form-control" id="postText" name="postText" rows="3" required></textarea>
          </div>
          <!-- <div class="mb-3">
            <label for="image" class="form-label">Select image to upload:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
          </div> -->
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Select image to upload:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
          </form>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Post</button>
          </div>
        <!-- </form> -->
      </div>
    </div>
  </div>
</div>
</form>




<!-- post form end  -->


</body>
</html>