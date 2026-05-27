<?php
session_start();
include '../Login/config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    die("<script>alert('Please login to place an order.'); window.location='login.php';</script>");
}

$user_id = $_SESSION['user_id'];
$order_date = date('Y-m-d H:i:s');
$status = 'Processing';

// Fetch cart items for the user
$cart_query = $conn->prepare("SELECT cart.product_id, cart.quantity, products.name, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$cart_query->bind_param("i", $user_id);
$cart_query->execute();
$cart_result = $cart_query->get_result();

if ($cart_result->num_rows == 0) {
    die("<script>alert('Your cart is empty.'); window.location='cart.php';</script>");
}

$total_price = 0;
$product_names = [];

while ($row = $cart_result->fetch_assoc()) {
    $total_price += $row['price'] * $row['quantity'];
    $product_names[] = $row['name'];
}

// Insert order into database
$stmt = $conn->prepare("INSERT INTO orders (user_id, status, order_date, created_at, product_name) VALUES (?, ?, ?, ?, ?)");
$product_list = implode(", ", $product_names);
$stmt->bind_param("issss", $user_id, $status, $order_date, $order_date, $product_list);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // Insert order items
    $cart_result->data_seek(0); // Reset pointer to reprocess cart items
    while ($row = $cart_result->fetch_assoc()) {
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt_item->bind_param("iiid", $order_id, $row['product_id'], $row['quantity'], $row['price']);
        $stmt_item->execute();
    }

    // Clear cart after order placement
    $conn->query("DELETE FROM cart WHERE user_id = $user_id");

    echo "<script>alert('Order placed successfully!'); window.location='order_success.php?order_id=$order_id';</script>";
} else {
    echo "<script>alert('Order failed! Try again.'); window.location='cart.php';</script>";
}
?>
