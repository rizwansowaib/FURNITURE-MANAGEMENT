
<?php
session_start();
require '../Login/config.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    die("User not logged in or session expired.");
}

$user_id = $_SESSION['user_id'];

// Debugging: Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, product_name, status, created_at FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Prepare Error: " . $conn->error); // Debugging error
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("SQL Execution Error: " . $stmt->error); // Debugging error
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <h2 class="text-2xl font-semibold text-gray-800">My Orders</h2>
        <p class="text-gray-500 mt-2">Your recent purchases</p>

        <?php if ($result->num_rows > 0) { ?>
            <ul class="mt-6 text-left">
                <?php while ($order = $result->fetch_assoc()) { ?>
                    <li class="border-b py-2">
                        <strong><?php echo htmlspecialchars($order['product_name']); ?></strong><br>
                        Status: <span class="text-blue-500"><?php echo htmlspecialchars($order['status']); ?></span><br>
                        Date: <?php echo htmlspecialchars($order['created_at']); ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p class="mt-4 text-gray-600">No orders found for this user.</p>
        <?php } ?>

        <div class="mt-6">
            <a href="../Login/user_dashboard.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>
