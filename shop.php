<?php
include 'connection.php';
include 'dashboardV1.php'; 

// ✅ SECURITY: Check kung user naka-login
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['userId'];

// ---------------------- ADD TO CART ----------------------
if (isset($_POST['addToCart'])) {
    $pid = $_POST['product_id'];
    $designId = $_POST['design_id'];
    $quantity = $_POST['quantity'];

    if (empty($designId) || $quantity <= 0) {
        echo "<script>
            Swal.fire('Oops!', 'Please select a design and valid quantity!', 'warning');
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, design_id, qty) 
                             VALUES ('$userId','$pid','$designId','$quantity')");
        echo "<script>
            Swal.fire('Added!', 'Item added to your cart.', 'success');
        </script>";
    }
}

// ---------------------- UPDATE CART ----------------------
if (isset($_POST['updateCart'])) {
    $cid = $_POST['cart_id'];
    $qty = $_POST['qty'];
    mysqli_query($conn, "UPDATE cart SET qty='$qty' WHERE cart_id='$cid' AND user_id='$userId'");
}

// ---------------------- DELETE CART ----------------------
if (isset($_POST['deleteCart'])) {
    $cid = $_POST['cart_id'];
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id='$cid' AND user_id='$userId'");
}

// ---------------------- CHECKOUT ----------------------
if (isset($_POST['checkout'])) {
    $payment = $_POST['payment_method'];
    $cartItems = mysqli_query($conn, "SELECT c.*, p.price FROM cart c 
                                      JOIN products p ON c.product_id=p.product_id 
                                      WHERE c.user_id='$userId'");
    $total = 0;
    while ($c = mysqli_fetch_assoc($cartItems)) {
        $total += $c['price'] * $c['qty'];
    }

    if ($total > 0) {
        mysqli_query($conn, "INSERT INTO orders (user_id, total, status, payment_method, created_at) 
                             VALUES ('$userId','$total','Pending','$payment',NOW())");
        $orderId = mysqli_insert_id($conn);

        mysqli_data_seek($cartItems, 0);
        while ($c = mysqli_fetch_assoc($cartItems)) {
            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, design_id, qty, price) 
                                 VALUES ('$orderId','{$c['product_id']}','{$c['design_id']}','{$c['qty']}','{$c['price']}')");
            // bawasan stock
            mysqli_query($conn, "UPDATE products SET quantity = quantity - {$c['qty']} WHERE product_id='{$c['product_id']}'");
        }

        mysqli_query($conn, "DELETE FROM cart WHERE user_id='$userId'");

        echo "<script>
            Swal.fire('Success!','Your order has been placed.','success');
        </script>";
    } else {
        echo "<script>
            Swal.fire('Oops!','Your cart is empty.','warning');
        </script>";
    }
}
?>

<style>
body {
    overflow: hidden; 
  }
.shop-container {
    display: grid;
    grid-template-columns: 2fr 1fr; /* left 2/3 shop, right 1/3 order history */
    gap: 25px;
    padding: 20px;
}
.product-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: 0.3s;
}
.product-card:hover {
    transform: translateY(-5px);
}
.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.product-info {
    padding: 15px;
    text-align: center;
}
.product-info h5 {
    margin: 5px 0;
    font-size: 18px;
    color: #333;
}
.product-info p {
    color: #36b9cc;
    font-weight: bold;
}
.designs {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin: 10px 0;
}
.designs img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    border: 2px solid transparent;
}
.designs img.selected {
    border: 2px solid #36b9cc;
}

.shop-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px; /* dagdag space bawat pagitan */
    padding: 30px;
    justify-items: center;
}
.product-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: 0.3s;
    max-width: 320px;
    width: 100%;
}
.product-card:hover {
    transform: translateY(-8px);
}
.designs {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    margin: 15px 0;
}
.designs img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: 0.2s;
}
.designs img:hover {
    transform: scale(1.05);
}

.order-history {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 20px;
    max-height: 80vh;
    overflow-y: auto;
}

.order-history h4 {
    margin-bottom: 15px;
    color: #36b9cc;
}

.order-card {
    background: #f9f9f9;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: 0.3s;
}
.order-card:hover {
    transform: translateY(-3px);
}

  .modal-body::-webkit-scrollbar {
    display: none; 
  }
  .modal-body {
    -ms-overflow-style: none; 
    scrollbar-width: none;
  }
  
    .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 225px;
    z-index: 1000;
    overflow: hidden;
         margin: 0 !important;
        padding: 0 !important;
}

#content-wrapper {
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

<div class="shop-container position-relative">
    <h1 class="fw-bold text-start mb-5" 
      style="grid-column: 1 / -1; 
             font-size: 42px; 
             color: #022c35; 
             text-transform: uppercase; 
             letter-spacing: 2px; 
             text-shadow: 2px 2px 6px rgba(0,0,0,0.15); 
             margin-left: 30px;">
      🛍️ Shelter Merchandise
  </h1>

  <button class="btn btn-info fw-bold shadow-sm position-absolute"
        style="top: 30px; right: 150px; border-radius: 10px; 
               padding: 5px 28px; font-size: 18px; font-weight: 700;
               min-width: 160px; min-height: 60px;
               z-index: 10;"
        data-bs-toggle="modal" data-bs-target="#orderHistoryModal">
   My Orders
</button>
<?php
$products = mysqli_query($conn, "SELECT * FROM products WHERE quantity > 0");
while ($p = mysqli_fetch_assoc($products)) {
    $pid = $p['product_id'];
?>
    <div class="product-card">
        <img src="<?= $p['main_image'] ?>" alt="<?= $p['name'] ?>">
        <p>₱<?= number_format($p['price'], 2) ?></p>
        <div class="product-info">
            <h5><?= $p['name'] ?></h5>
            
            <!-- Design choices -->
            <div class="designs" id="designs-<?= $pid ?>">
                <?php
                $designs = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$pid'");
                while ($d = mysqli_fetch_assoc($designs)) {
                    echo "<img src='{$d['image_path']}' data-id='{$d['image_id']}' onclick='selectDesign(this, $pid)'>";
                }
                ?>
            </div>

            <form method="POST" onsubmit="return validateCart(<?= $pid ?>)">
                <input type="hidden" name="product_id" value="<?= $pid ?>">
                <input type="hidden" name="design_id" id="designInput-<?= $pid ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?= $p['quantity'] ?>" 
                       class="form-control mb-2" required>
                <button type="submit" name="addToCart" class="btn btn-info w-100">Add to Cart</button>
            </form>

        </div>
    </div>
<?php } ?>

<!--  Design Preview Modal -->
<div class="modal fade" id="designPreviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4 shadow-lg border-0" 
         style="background: #f8fbfc;">
      
      <!-- Header -->
      <div class="modal-header border-0 pb-2">
        <h5 class="modal-title fw-bold text-dark">
          Preview Design
        </h5>
        <button type="button" class="btn-close shadow-sm" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body text-center">
        <div class="p-2 rounded-4 shadow-sm bg-white">
          <img id="previewImage" src="" 
               class="img-fluid rounded-4 shadow-sm" 
               style="max-height:300px; object-fit:contain;">
        </div>

        <p class="mt-3 fw-semibold text-secondary" id="previewName"></p>

<div class="d-flex justify-content-center">
  <button type="button" id="confirmDesign" 
          class="btn fw-bold shadow-sm rounded-pill px-4 py-2"
          style="background-color:#36b9cc; border:none; color:white; transition:0.3s; width:auto;">
    ✅
  </button>
</div>

      </div>
    </div>
  </div>
</div>


<!-- ✅ Order History Modal -->
<div class="modal fade" id="orderHistoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg border-0">
      
      <!-- Header -->
      <div class="modal-header text-white" style="background-color: #36b9cc;">
        <h5 class="modal-title fw-bold">📜 Order History</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <?php
        $orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$userId' ORDER BY created_at DESC");
        if (mysqli_num_rows($orders) == 0) {
            echo "<p class='text-muted text-center'>No orders yet.</p>";
        } else {
            while ($o = mysqli_fetch_assoc($orders)) {
                echo "
                <div class='order-card mb-4 p-3 rounded shadow-sm' style='background:#f9f9f9;'>
                  <p class='mb-1'><strong>Order #{$o['order_id']}</strong></p>
                  <p class='mb-1'>Payment: {$o['payment_method']}</p>
                  <p class='mb-2'>Status: <span class='badge bg-info'>{$o['status']}</span></p>
                  <small class='text-muted'>{$o['created_at']}</small>
                  <hr>
                  <div class='table-responsive'>
                    <table class='table table-sm align-middle'>
                      <thead class='table-light'>
                        <tr>
                          <th>Design</th>
                          <th>Product</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>";
                
                // Kunin yung items ng order
                $items = mysqli_query($conn, "SELECT oi.*, p.name, i.image_path 
                                              FROM order_items oi 
                                              JOIN products p ON oi.product_id=p.product_id 
                                              JOIN product_images i ON oi.design_id=i.image_id 
                                              WHERE oi.order_id='{$o['order_id']}'");
                while ($it = mysqli_fetch_assoc($items)) {
                    $lineTotal = $it['price'] * $it['qty'];
                    echo "
                      <tr>
                        <td><img src='{$it['image_path']}' style='width:50px;height:50px;object-fit:cover;border-radius:6px;'></td>
                        <td>{$it['name']}</td>
                        <td>{$it['qty']}</td>
                        <td>₱".number_format($it['price'],2)."</td>
                        <td class='fw-bold'>₱".number_format($lineTotal,2)."</td>
                      </tr>";
                }

                echo "
                      </tbody>
                    </table>
                  </div>
                </div>";
            }
        }
        ?>
      </div>
    </div>
  </div>
</div>




<!-- ✅ Cart Modal -->
<div class="modal fade" id="cartModal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
     
<div class="modal-header text-white" style="background-color: #36b9cc;">
  <h5 class="modal-title fw-bold">🛒 My Cart</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>


      <!-- Body -->
      <div class="modal-body p-4" style="max-height: 85vh; overflow-y: auto;">
        <div class="row g-4">
          
          <!-- LEFT: Cart Table -->
          <div class="col-md-7">
            <div class="table-responsive mb-4">
              <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $cart = mysqli_query($conn, "SELECT c.*, p.name, p.price, i.image_path 
                                             FROM cart c 
                                             JOIN products p ON c.product_id=p.product_id 
                                             JOIN product_images i ON c.design_id=i.image_id 
                                             WHERE c.user_id='$userId'");
                $grand = 0;
                while ($c = mysqli_fetch_assoc($cart)) {
                    $total = $c['price'] * $c['qty'];
                    $grand += $total;
                    echo "<tr>
                      <td>
                        <div class='d-flex align-items-center gap-2'>
                          <img src='{$c['image_path']}' class='rounded shadow-sm' 
                               style='width:55px;height:55px;object-fit:cover;'>
                          <span class='fw-semibold text-dark'>{$c['name']}</span>
                        </div>
                      </td>
                      <td>
                        <form method='POST' class='d-inline'>
                          <input type='hidden' name='cart_id' value='{$c['cart_id']}'>
                          <input type='number' name='qty' value='{$c['qty']}' min='1' 
                                 class='form-control form-control-sm text-center rounded-3 shadow-sm' 
                                 style='width:70px;'>
                        </form>
                      </td>
                      <td class='fw-bold text-primary'>₱".number_format($total,2)."</td>
                      <td>
                        <form method='POST'>
                          <input type='hidden' name='cart_id' value='{$c['cart_id']}'>
                          <button name='deleteCart' class='btn btn-sm btn-outline-danger rounded-pill'>
                            ✖ Remove
                          </button>
                        </form>
                      </td>
                    </tr>";
                }
                ?>
                </tbody>
              </table>
            </div>
            <!-- Total -->
            <div class="text-end">
              <h5 class="fw-bold text-dark">Total: 
                <span class="text-success">₱<?= number_format($grand,2) ?></span>
              </h5>
            </div>
          </div>

          <!-- RIGHT: Checkout Form -->
          <div class="col-md-5">
            <?php
            $userQ = mysqli_query($conn, "SELECT location, contactNo FROM users WHERE userId='$userId'");
            $userData = mysqli_fetch_assoc($userQ);
            $userAddress = htmlspecialchars($userData['location']);
            $userNumber  = htmlspecialchars($userData['contactNo']);
            ?>
            
            <form method="POST" class="bg-light p-4 rounded-4 shadow-sm h-100">
              <h6 class="fw-bold mb-3">Delivery Information</h6>
              <div class="mb-3">
                <label class="form-label">Delivery Address</label>
                <input type="text" name="address" value="<?= $userAddress ?>" 
                       class="form-control shadow-sm rounded-3" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contactNo" value="<?= $userNumber ?>" 
                       class="form-control shadow-sm rounded-3" required>
              </div>
              <small class="text-muted d-block mb-3">You can edit your delivery info here if needed.</small>

              <hr class="my-4">

              <h6 class="fw-bold mb-3">Payment Method</h6>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                <label class="form-check-label" for="cod">💵 Cash on Delivery</label>
              </div>
              <div class="form-check mb-4">
                <input class="form-check-input" type="radio" name="payment_method" id="paymongo" value="paymongo">
                <label class="form-check-label" for="paymongo">📱 Pay via PayMongo <small class="text-muted">(GCash / Card / GrabPay)</small></label>
              </div>

              <button type="submit" name="checkout" id="checkoutBtn"
                    class="btn w-100 py-2 fw-bold shadow-sm rounded-3 d-flex align-items-center justify-content-center gap-2"
                    style="background-color: #03373e; border: none; color: white; font-size: 1.1rem;">
              <i class="bi bi-check-circle-fill"></i> Checkout Now
            </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("checkoutForm").addEventListener("submit", function(e){
    let payMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if(payMethod === "paymongo"){
        e.preventDefault(); 

        // redirect to PayMongo payment session handler
        window.location.href = "paymongo_checkout.php?amount=<?= $grand ?>";
    }
});
</script>
<script>
let selectedImg = null;
let selectedPid = null;

function selectDesign(img, pid) {
    // highlight agad yung pinili
    let designs = document.querySelectorAll("#designs-" + pid + " img");
    designs.forEach(d => d.classList.remove("selected"));
    img.classList.add("selected");

    // set preview data
    selectedImg = img;
    selectedPid = pid;
    document.getElementById("previewImage").src = img.src;
    document.getElementById("previewName").innerText = "Selected Design #" + img.dataset.id;

    // open modal
    let modal = new bootstrap.Modal(document.getElementById('designPreviewModal'));
    modal.show();

    // confirm button click
    document.getElementById("confirmDesign").onclick = function() {
        document.getElementById("designInput-" + selectedPid).value = selectedImg.dataset.id;
        modal.hide();

        Swal.fire({
          icon: 'success',
          title: 'Design Selected!',
          text: 'Your design has been applied.',
          showConfirmButton: false,
          timer: 1500
        });
    }
}
</script>

<script>
document.querySelectorAll('input[name="payment_method"]').forEach(input => {
  input.addEventListener('change', function() {
    document.getElementById('codSection').classList.add('d-none');
    document.getElementById('gcashSection').classList.add('d-none');
    document.getElementById('bankSection').classList.add('d-none');
    
    if (this.value === 'COD') {
      document.getElementById('codSection').classList.remove('d-none');
    } else if (this.value === 'GCash') {
      document.getElementById('gcashSection').classList.remove('d-none');
    } else if (this.value === 'Bank') {
      document.getElementById('bankSection').classList.remove('d-none');
    }
  });
});
</script>
