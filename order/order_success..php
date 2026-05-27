<?php
session_start();
include '../Login/config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    die("<script>alert('Please login to place an order.'); window.location='login.php';</script>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $total_price = $_POST['total_price'];
    $order_date = date('Y-m-d H:i:s');
    $status = 'Processing'; // Default status

    $product_names = [];

    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (user_id, status, order_date, created_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $status, $order_date, $order_date);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert order items
        foreach ($_POST['products'] as $product) {
            $product_id = $product['id'];
            $quantity = $product['quantity'];
            $price = $product['price'];
            $product_names[] = $product['name']; // Collect product names

            $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $stmt_item->execute();
        }

        // Store product names in 'orders' table
        $product_list = implode(", ", $product_names);
        $stmt_update = $conn->prepare("UPDATE orders SET product_name = ? WHERE id = ?");
        $stmt_update->bind_param("si", $product_list, $order_id);
        $stmt_update->execute();

        // Clear cart after order placement
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");

        echo "<script>alert('Order placed successfully!'); window.location='order_success.php?order_id=$order_id';</script>";
    } else {
        echo "<script>alert('Order failed! Try again.'); window.location='cart.php';</script>";
    }
}
?>
