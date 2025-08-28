<?php
include 'connection.php';
session_start();

$userId = $_SESSION['userId'];

// kunin ulit yung cart
$cartItems = mysqli_query($conn, "SELECT c.*, p.price FROM cart c 
                                  JOIN products p ON c.product_id=p.product_id 
                                  WHERE c.user_id='$userId'");
$total = 0;
while ($c = mysqli_fetch_assoc($cartItems)) {
    $total += $c['price'] * $c['qty'];
}

if ($total > 0) {
    mysqli_query($conn, "INSERT INTO orders (user_id, total, status, payment_method, created_at) 
                         VALUES ('$userId','$total','Paid','paymongo',NOW())");
    $orderId = mysqli_insert_id($conn);

    mysqli_data_seek($cartItems, 0);
    while ($c = mysqli_fetch_assoc($cartItems)) {
        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, design_id, qty, price) 
                             VALUES ('$orderId','{$c['product_id']}','{$c['design_id']}','{$c['qty']}','{$c['price']}')");
        mysqli_query($conn, "UPDATE products SET quantity = quantity - {$c['qty']} WHERE product_id='{$c['product_id']}'");
    }

    mysqli_query($conn, "DELETE FROM  WHERE user_id='$userId'");

    echo "<script>
        Swal.fire('Payment Successful!','Your payment has been confirmed.','success')
            .then(() => window.location.href='shop.php');
    </script>";
}
