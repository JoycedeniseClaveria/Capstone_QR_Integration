<?php 
include 'connection.php';
include 'dashboardAdmin.php';

// ✅ Security Check
if (!isset($_SESSION['userId']) || $_SESSION['type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Add Product
if (isset($_POST['addProduct'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $mainImage = $_FILES['main_image']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($mainImage);
    move_uploaded_file($_FILES['main_image']['tmp_name'], $targetFile);

    $sql = "INSERT INTO products (name, price, quantity, main_image) 
            VALUES ('$name', '$price', '$quantity', '$targetFile')";
    mysqli_query($conn, $sql);
    $productId = mysqli_insert_id($conn);

    foreach ($_FILES['design_images']['tmp_name'] as $key => $tmpName) {
        if (!empty($tmpName)) {
            $fileName = $_FILES['design_images']['name'][$key];
            $designTarget = $targetDir . basename($fileName);
            move_uploaded_file($tmpName, $designTarget);
            mysqli_query($conn, "INSERT INTO product_images (product_id, image_path) VALUES ('$productId', '$designTarget')");
        }
    }
    echo "<script>
Swal.fire({
  icon: 'success',
  title: 'Product Added',
  text: 'The product was added successfully!',
  showConfirmButton: false,
  timer: 2000
});
</script>";

}

// ✅ Delete Design Image
if (isset($_POST['deleteDesignImage'])) {
    $imgId = $_POST['deleteImageId'];
    $pid = $_POST['deletePid'];

    // delete from db
    mysqli_query($conn, "DELETE FROM product_images WHERE image_id='$imgId'");

    echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Image Deleted',
      text: 'The design image was removed successfully!',
      showConfirmButton: false,
      timer: 2000
    }).then(() => {
        window.location.href='productAdmin.php';
    });
    </script>";
}


// Update Product
if (isset($_POST['updateProduct'])) {
    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if (!empty($_FILES['main_image']['name'])) {
        $mainImage = $_FILES['main_image']['name'];
        $targetFile = "uploads/" . basename($mainImage);
        move_uploaded_file($_FILES['main_image']['tmp_name'], $targetFile);
        mysqli_query($conn, "UPDATE products SET main_image='$targetFile' WHERE product_id='$id'");
    }

    mysqli_query($conn, "UPDATE products SET name='$name', price='$price', quantity='$quantity' WHERE product_id='$id'");

    foreach ($_FILES['design_images']['tmp_name'] as $key => $tmpName) {
        if (!empty($tmpName)) {
            $fileName = $_FILES['design_images']['name'][$key];
            $designTarget = "uploads/" . basename($fileName);
            move_uploaded_file($tmpName, $designTarget);
            mysqli_query($conn, "INSERT INTO product_images (product_id, image_path) VALUES ('$id', '$designTarget')");
        }
    }
echo "<script>
Swal.fire({
  icon: 'success',
  title: 'Product Updated',
  text: 'The product was updated successfully!',
  showConfirmButton: false,
  timer: 2000
});
</script>";


// Delete Product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE product_id='$id'");
    // After Delete
echo "<script>
Swal.fire({
  icon: 'success',
  title: 'Product Deleted',
  text: 'The product was deleted successfully!',
  showConfirmButton: false,
  timer: 2000
});
</script>";

}
}
?>

<style>
    html, body {
    max-width: 100%;
    overflow-x: 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #fdfaf8;
    margin: 0;
    padding: 0;
}

.container {
    width: 100%;
    padding: 15px;
    box-sizing: border-box;
}

/* Images shrink properly */
img {
    max-width: 100%;
    height: auto;
}

    h2 {
        color: #CC7B60 ;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Buttons */
    .btn-success, .btn-primary {
        background-color: #e3896b !important;
        border: none;
    }
    .btn-success:hover, .btn-primary:hover {
        background-color: #c86f55 !important;
    }

    .btn-danger {
        background-color: #e35d5b !important;
        border: none;
    }
    .btn-danger:hover {
        background-color: #c14442 !important;
    }

    /* Table */
    table {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    table th {
        background-color: #E8B5A3;
        color: #000000;
        text-align: center;
    }

    table td {
        vertical-align: middle;
        text-align: center;
    }

    table img {
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    /* Modal */
    .modal-content {
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: #E8B5A3;
        color: black;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .modal-footer .btn-secondary {
        background: #ddd;
        color: #333;
    }
    .modal-footer .btn-secondary:hover {
        background: #bbb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        table img {
            width: 60px;
        }
        .modal-dialog {
            margin: 10px;
        }
    }

    @media (max-width: 576px) {
        table, table thead, table tbody, table th, table td, table tr {
            display: block;
            width: 100%;
        }
        table thead {
            display: none;
        }
        table tr {
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding: 10px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        table td {
            text-align: left;
            padding: 5px 10px;
        }
        table td::before {
            content: attr(data-label);
            font-weight: bold;
            display: block;
            color: #e3896b;
        }
    }
    
    /* --- ACTION BUTTONS --- */
.table .btn {
    min-width: 90px;       /* same width */
    min-height: 38px;      /* same height */
    margin: 2px;           /* spacing between buttons */
    font-size: 14px;
    border-radius: 8px;
}

.table .btn-primary {
    background-color: #e3896b !important;
    border: none;
}
.table .btn-primary:hover {
    background-color: #c86f55 !important;
}

.table .btn-danger {
    background-color: #e35d5b !important;
    border: none;
}
.table .btn-danger:hover {
    background-color: #c14442 !important;
}

/* --- RESPONSIVE TABLE --- */
@media (max-width: 992px) { /* Tablet */
    table img {
        width: 70px;
    }
    .table .btn {
        min-width: 75px;
        font-size: 13px;
    }
}

@media (max-width: 576px) { /* Mobile */
    table, table thead, table tbody, table th, table td, table tr {
        display: block;
        width: 100%;
    }
    table thead {
        display: none;
    }
    table tr {
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding: 12px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    table td {
        text-align: left;
        padding: 6px 10px;
    }
    table td::before {
        content: attr(data-label);
        font-weight: bold;
        display: block;
        margin-bottom: 4px;
        color: #e3896b;
    }
    .table .btn {
        width: 100%;   /* full width buttons on small screens */
        margin-top: 5px;
    }
}

.design-wrapper {
    position: relative;
    display: inline-block;
    margin: 4px;
}

.design-img {
    width: 80px;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.design-wrapper {
    position: relative;
    display: inline-block;
    margin: 4px;
}

.design-img {
    width: 80px;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* --- ACTION BUTTONS (Edit, Delete sa Actions column) --- */
.table .btn {
    min-width: 90px;
    min-height: 38px;
    margin: 2px;
    font-size: 14px;
    border-radius: 8px;
}

/* ✅ Maliit na X Button sa Design Images */
.design-delete {
    position: absolute;
    top: 2px;
    left: 2px;
    background: rgba(227, 93, 91, 0.9);
    color: #fff;
    border-radius: 50%;
    font-size: 10px;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    line-height: 1;
    transition: 0.2s;
    cursor: pointer;
}

.design-delete:hover {
    background: #c14442;
    transform: scale(1.1);
}

.design-delete:hover {
    background: #c14442;
    transform: scale(1.1);
}

</style>


<div class="container mt-5">
    <h2>Product Management</h2>

 <!-- Wrapper for button -->
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
        + Add Product
    </button>
</div>


    <!-- ✅ Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" placeholder="Product Name" required class="form-control mb-2">
                        <input type="number" step="0.01" name="price" placeholder="Price" required class="form-control mb-2">
                        <input type="number" name="quantity" placeholder="Quantity" required class="form-control mb-2">
                        
                        <label>Main Image:</label>
                        <input type="file" name="main_image" required class="form-control mb-2" 
                               onchange="previewImage(this, 'addPreview')">
                        <img id="addPreview" src="" width="120" style="display:none; margin-top:5px;">
                        
                        <label>Design Images:</label>
                        <input type="file" name="design_images[]" multiple class="form-control mb-2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="addProduct" class="btn btn-success">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Display Products -->
    <table class="table table-bordered mt-3">
        <tr>
            <th>Main Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Designs</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['product_id'];
            ?>
            <tr>
                <td><img src="<?= $row['main_image'] ?>" width="100"></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>
                    <div style="display:flex; flex-wrap:wrap; gap:10px;">
                        <?php
                        $images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$id'");
                        while ($img = mysqli_fetch_assoc($images)) {
                            echo "
                                <div class='design-wrapper'>
                                    <img src='{$img['image_path']}' class='design-img'>
                                    <a href='#' class='design-delete' data-id='{$img['image_id']}' data-pid='$id'>×</a>
                                </div>
                            ";
                        }
                        ?>
                    </div>
                </td>

                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $id ?>">
                        Edit
                    </button>
                    <a href="productAdmin.php?delete=<?= $id ?>" class="btn btn-danger delete-btn" data-id="<?= $id ?>">Delete</a>
                </td>
            </tr>
            
            <!-- ✅ Delete Design Image Modal -->
<div class="modal fade" id="deleteDesignModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to remove this design image?</p>
          <input type="hidden" name="deleteImageId" id="deleteImageId">
          <input type="hidden" name="deletePid" id="deletePid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="deleteDesignImage" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>


            <!-- ✅ Edit Modal -->
            <div class="modal fade" id="editModal<?= $id ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="product_id" value="<?= $id ?>">
                                <input type="text" name="name" value="<?= $row['name'] ?>" required class="form-control mb-2">
                                <input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" required class="form-control mb-2">
                                <input type="number" name="quantity" value="<?= $row['quantity'] ?>" required class="form-control mb-2">

                                <label>Current Main Image:</label><br>
                                <img src="<?= $row['main_image'] ?>" width="120" style="margin-bottom:10px;"><br>

                                <label>New Main Image (optional):</label>
                                <input type="file" name="main_image" class="form-control mb-2" 
                                       onchange="previewEditImage(this, 'editPreview<?= $id ?>')">
                                <img id="editPreview<?= $id ?>" src="" width="120" style="display:none; margin-top:5px;">

                                <label>Add More Design Images:</label>
                                <input type="file" name="design_images[]" multiple class="form-control mb-2">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="updateProduct" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ✅ Live preview for Add Product
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = "block";
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = "none";
    }
}

// ✅ Live preview for Edit Product
function previewEditImage(input, previewId) {
    previewImage(input, previewId);
}
</script>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    let url = this.getAttribute('href');

    Swal.fire({
      title: 'Are you sure?',
      text: "This product will be permanently deleted.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e35d5b',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  });
});
</script>

<script>
document.querySelectorAll('.design-delete').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    let imageId = this.dataset.id;
    let pid = this.dataset.pid;

    document.getElementById('deleteImageId').value = imageId;
    document.getElementById('deletePid').value = pid;

    let deleteModal = new bootstrap.Modal(document.getElementById('deleteDesignModal'));
    deleteModal.show();
  });
});
</script>


