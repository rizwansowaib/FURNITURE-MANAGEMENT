/* cart_action.php */
<?php
session_start();
require '../Login/config.php';

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

// Check if item already exists in the cart
$sql = "SELECT id FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $update = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    if ($stmt->execute()) {
        echo "Cart updated successfully";
    } else {
        echo "Error updating cart";
    }
} else {
    $insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    if ($stmt->execute()) {
        echo "Item added to cart successfully";
    } else {
        echo "Error adding item to cart";
    }
}
?>
