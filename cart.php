<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>Shopping Cart</title> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head> 
<style> 
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

nav {
    background-color: #343a40;
    padding: 20px 0;
}

nav ul {
    margin: 0;
    padding: 0;
    list-style: none;
    text-align: right;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
    font-size: 20px;
}


header {
    color: black;
    padding: 20px 0;
    text-align: center;
}

h1 {
    margin: 0;
}

main {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #333;
    color: #fff;
}

tfoot td {
    font-weight: bold;
}

.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 20px;
    cursor: pointer;
    border-radius: 5px;
}

.button:hover {
    background-color: #45a049;
}

footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
}
</style> 

<body> 
	<nav> 
		<ul>
			<li> 
				<a href="shop.php">Shop</a> 
			</li> 
			<li> 
            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i></a></li> 
			</li> 
		</ul> 
	</nav> 

    <header> 
        <h1> Shopping Cart</h1> 
    </header>
    <main> 
        <section> 
        <div class="card">
                <table> 
                    <tr> 
                        <th>Product Name </th> 
                        <th>Quantity </th> 
                        <th>Price </th> 
                        <th>Total </th> 
                    </tr> 
                <?php 
                $servername = "localhost"; 
                $username = "root";  
                $password = ""; 
                $dbname = "shop_db"; 

                // Create connection 
                $conn = 
                    new mysqli($servername, $username, $password, $dbname); 

                // Check connection 
                if ($conn->connect_error) { 
                    die("Connection failed: " . $conn->connect_error); 
                } 

                $total = 0; 

                // Loop through items in cart and display in table 
                foreach ($_SESSION['cart'] as $product_id => $quantity) { 
                    $sql = "SELECT * FROM products WHERE id = $product_id"; 
                    $result = $conn->query($sql); 
                
                    if ($result->num_rows > 0) { 
                        $row = $result->fetch_assoc(); 
                        $name = $row['name']; 
                        $price = (float) $row['price']; 
                        $quantity = (int) $quantity;    
                        $item_total = $quantity * $price; 
                        $total += $item_total; 
                
                        echo "<tr>"; 
                        echo "<td>$name</td>"; 
                        echo "<td>$quantity</td>"; 
                        echo "<td>₱" . number_format($price, 2) . "</td>"; 
                        echo "<td>₱" . number_format($item_total, 2) . "</td>"; 
                        echo "</tr>"; 
                    } 
                }
                
                // Display total 
                echo "<tr>"; 
                echo "<td colspan='3'>Total:</td>"; 
                echo "<td>₱" . number_format($total, 2) . "</td>"; 
                echo "</tr>"; 
                ?> 
            </table> 
            <form action="checkout.php" method="post"> 
                <input type="submit"
                    value="Checkout"
                    class="button" /> 
            </form> 
            </div>
        </section> 
	</main> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <footer> 
        <p>&copy; 2024 Furever Finder</p> 
    </footer> 
</body> 

</html>