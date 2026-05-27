<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit;
}

// Include Database Connection
include 'config1.php';

// Fetch Data from Database
$total_orders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
$total_products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$delivered_orders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE status='Delivered'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">

    <!-- Sidebar -->
    <div class="flex">
        <aside class="w-64 bg-red-600 text-white min-h-screen p-5 hidden md:block">
            <h2 class="text-2xl font-bold uppercase mb-6">Furniture</h2>
            <ul class="space-y-4">
                <li><a href="admin-dashboard.php" class="block py-2 px-4 hover:bg-red-500 rounded">Dashboard</a></li>
                <li><a href="" class="block py-2 px-4 hover:bg-red-500 rounded">Brand</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-red-500 rounded">Category</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-red-500 rounded">Products</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-red-500 rounded">Orders</a></li>
                <li><a href="../users/user.php" class="block py-2 px-4 hover:bg-red-500 rounded">Users</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-red-500 rounded">Reports</a></li>
                <li><a href="../Login/logout.php" class="block py-2 px-4 hover:bg-red-700 rounded">Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <header class="flex justify-between items-center bg-white dark:bg-gray-800 shadow-md p-4 rounded-lg">
                <h2 class="text-2xl font-semibold dark:text-white">Admin Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <button id="darkModeToggle" class="bg-gray-200 dark:bg-gray-700 p-2 rounded-full">
                        <i class="fas fa-moon dark:text-white"></i>
                    </button>
                    <span class="text-gray-600 dark:text-white">
                        <?php echo $_SESSION['admin_name']; ?> <i class="fas fa-user"></i>
                    </span>
                </div>
            </header>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow flex items-center">
                    <i class="fas fa-shopping-cart text-red-500 text-3xl"></i>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold dark:text-white">Total Orders</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-white"><?php echo $total_orders; ?></p>
                    </div>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow flex items-center">
                    <i class="fas fa-box-open text-green-500 text-3xl"></i>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold dark:text-white">Total Products</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-white"><?php echo $total_products; ?></p>
                    </div>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow flex items-center">
                    <i class="fas fa-users text-blue-500 text-3xl"></i>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold dark:text-white">Total Users</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-white"><?php echo $total_users; ?></p>
                    </div>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow flex items-center">
                    <i class="fas fa-truck text-purple-500 text-3xl"></i>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold dark:text-white">Delivered Orders</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-white"><?php echo $delivered_orders; ?></p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-8 text-center text-gray-500 dark:text-gray-400">
                © 2025 Furniture Store Management System
            </footer>
        </div>
    </div>

    <script>
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById("darkModeToggle");
        darkModeToggle.addEventListener("click", () => {
            document.body.classList.toggle("dark");
        });
    </script>

</body>
</html>
