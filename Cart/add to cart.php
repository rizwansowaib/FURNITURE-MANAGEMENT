<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

// Check if product exists in cart
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
<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

// Check if product exists in cart
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
<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

// Check if product exists in cart
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
<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

// Check if product exists in cart
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
<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

// Check if product exists in cart
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
