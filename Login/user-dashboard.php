<?php
session_start();
require '../Login/config.php'; // Ensure the correct path to config.php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <h2 class="text-2xl font-semibold text-gray-800">Welcome, <?php echo htmlspecialchars($user_name); ?>! 🎉</h2>
        <p class="text-gray-500 mt-2">You are successfully logged in.</p>

      <!-- User Actions -->
<div class="mt-6 space-y-3">
    <a href="../Dashboard/profile.php" class="block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
        View Profile
    </a>
    <a href="../Dashboard/orders.php" class="block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
        My Orders
    </a>
    <a href="../Dashboard/settings.php" class="block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">
        Settings
    </a>
    <a href="../Cart/cart.php" class="block bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg shadow">
        View Cart 🛒
    </a>
    <a href="logout.php" class="block bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
        Logout
    </a>
</div>


</body>
</html>
