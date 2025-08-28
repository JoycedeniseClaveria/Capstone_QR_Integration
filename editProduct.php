<?php
include 'connection.php';
include 'dashboardAdmin.php';

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE product_id='$id'"));
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fc;
        margin: 0;
        padding: 0;
    }

    .edit-container {
        max-width: 700px;
        margin: 40px auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    .edit-container h2 {
        color: #e3896b; /* same accent color */
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        font-size: 15px;
    }

    label {
        font-weight: 500;
        color: #444;
        margin-top: 10px;
        display: block;
    }

    .main-image,
    .design-img {
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        margin-bottom: 8px;
        max-width: 120px;
        height: auto;
    }

    .design-wrapper {
        position: relative;
        display: inline-block;
        margin: 5px;
    }

    /* small X delete button */
    .design-delete {
        position: absolute;
        top: -6px;
        left: -6px;
        background: rgba(227, 93, 91, 0.95);
        color: #fff;
        border-radius: 50%;
        font-size: 12px;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        transition: 0.2s;
    }
    .design-delete:hover {
        background: #c14442;
        transform: scale(1.1);
    }

    .btn {
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 15px;
        transition: 0.2s;
    }
    .btn-success {
        background-color: #e3896b;
        border: none;
    }
    .btn-success:hover {
        background-color: #d16f56;
    }

    /* ✅ Responsive */
    @media (max-width: 768px) {
        .edit-container {
            margin: 20px;
            padding: 20px;
        }
        .design-wrapper {
            margin: 3px;
        }
        .main-image,
        .design-img {
            max-width: 90px;
        }
    }

    @media (max-width: 480px) {
        .edit-container {
            padding: 15px;
        }
        .btn {
            width: 100%;
            text-align: center;
        }
        .main-image,
        .design-img {
            max-width: 100%;
        }
    }
</style>

<div class="edit-container">
    <h2>Edit Product</h2>
    <form method="POST" action="productAdmin.php" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

        <label>Product Name:</label>
        <input type="text" name="name" value="<?= $product['name'] ?>" class="form-control">

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="form-control">

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" class="form-control">
        
        <label>Main Image:</label>
        <img src="<?= $product['main_image'] ?>" class="main-image"><br>
        <input type="file" name="main_image" class="form-control">

        <label>Design Images:</label><br>
        <?php
        $images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$id'");
        while ($img = mysqli_fetch_assoc($images)) {
            echo "<div class='design-wrapper'>
                    <img src='{$img['image_path']}' class='design-img'>
                    <a href='deleteImage.php?id={$img['image_id']}&pid=$id' class='design-delete'>×</a>
                 </div>";
        }
        ?>
        <input type="file" name="design_images[]" multiple class="form-control">

        <button type="submit" name="updateProduct" class="btn btn-success w-100 mt-3">Update Product</button>
    </form>
</div>
