/* product.php */
<?php
include '../Login/config.php';
session_start();

$query = "SELECT id, name, price FROM products";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>
                <h3>" . htmlspecialchars($row['name']) . "</h3>
                <p>Price: $" . number_format($row['price'], 2) . "</p>
                <form method='post' action='add_to_cart.php'>
                    <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                    <input type='number' name='quantity' value='1' min='1'>
                    <button type='submit'>Add to Cart</button>
                </form>
              </div>";
    }
} else {
    echo "<p>No products available.</p>";
}
?>
