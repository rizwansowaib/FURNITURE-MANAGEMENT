<?php
session_start();
require '../Login/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_phone = $_POST['phone'];

    $sql = "UPDATE users SET phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Prepare Error (Updating Phone): " . $conn->error);
    }

    $stmt->bind_param("si", $new_phone, $user_id);

    if ($stmt->execute()) {
        $message = "✅ Phone number updated!";
    } else {
        $message = "❌ Error updating phone: " . $stmt->error;
    }
}

// Fetch current user data
$sql = "SELECT username, email, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Prepare Error (Fetching User): " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <h2 class="text-2xl font-semibold text-gray-800">Settings</h2>
        <p class="text-gray-500 mt-2">Update your details</p>

        <?php if (!empty($message)) { ?>
            <p class="mt-4 text-gray-600"><?php echo $message; ?></p>
        <?php } ?>

        <form method="POST" class="mt-6 text-left">
            <label class="block">Username:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" class="w-full border p-2 rounded bg-gray-200" readonly>

            <label class="block mt-4">Email:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" class="w-full border p-2 rounded bg-gray-200" readonly>

            <label class="block mt-4">Phone Number:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="w-full border p-2 rounded">

            <button type="sub\mit" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
                Save Changes
            </button>
        </form>

        <div class="mt-6">
            <a href="../Login/user_dashboard.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>
