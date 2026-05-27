/* add_to_cart.php */
<?php
session_start();
include '../Login/config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

$query = "SELECT id FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $update = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    $stmt->execute();
} else {
    $insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
}

echo "Product added to cart!";
?>

/* cart.php */
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT cart.id, products.name, cart.quantity, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div>
            <h3>{$row['name']}</h3>
            <p>Price: \${$row['price']} (x{$row['quantity']})</p>
            <a href='cart_remove.php?id={$row['id']}'>Remove</a>
          </div>";
}
?>

/* checkout.php */
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$order_date = date('Y-m-d H:i:s');
$status = 'Processing';

$insert_order = "INSERT INTO orders (user_id, status, order_date, created_at) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insert_order);
$stmt->bind_param("isss", $user_id, $status, $order_date, $order_date);
$stmt->execute();
$order_id = $stmt->insert_id;

$cart_query = "SELECT product_id, quantity FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $insert_items = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_item = $conn->prepare($insert_items);
    $stmt_item->bind_param("iii", $order_id, $row['product_id'], $row['quantity']);
    $stmt_item->execute();
}

$conn->query("DELETE FROM cart WHERE user_id = $user_id");

echo "<script>alert('Order placed successfully!'); window.location='order_success.php?order_id=$order_id';</script>";
?>
