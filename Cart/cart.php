<?php
session_start();
require '../Login/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT c.id, p.name, p.price, c.quantity FROM cart c
          JOIN products p ON c.product_id = p.id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-2xl font-semibold text-gray-800">Your Cart 🛒</h2>

        <?php if ($result->num_rows > 0): ?>
            <ul class="mt-4 space-y-3">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="flex justify-between items-center p-3 bg-gray-200 rounded">
                        <span><?php echo htmlspecialchars($row['name']); ?> (<?php echo $row['quantity']; ?>)</span>
                        <span class="font-semibold">$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></span>
                        <form method="post" action="remove_from_cart.php" class="inline">
                            <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>
            <div class="mt-6 text-center">
                <a href="checkout.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p class="mt-4 text-gray-500">Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
