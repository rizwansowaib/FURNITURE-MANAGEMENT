<?php
session_start();
include '../Login/config.php'; // Ensure this connects to your MySQL database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $user_id = $_SESSION['user_id']; // Ensure user is logged in

    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if ($password === $hashed_password) { // Use password_verify() if passwords are hashed
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect password."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
    }
    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        .hidden { display: none; }
        #message { color: red; }
    </style>
</head>
<body>
    <h2>Enter Password to Proceed</h2>
    <input type="password" id="password" placeholder="Enter Password">
    <button id="verifyPassword">Verify</button>
    <p id="message"></p>

    <button id="payNow" class="hidden">Proceed to Payment</button>

    <script>
        document.getElementById("verifyPassword").addEventListener("click", function() {
    let password = document.getElementById("password").value;

    fetch("verify_password.php", {  // Ensure this path is correct
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            document.getElementById("payNow").classList.remove("hidden");
            document.getElementById("message").textContent = "Password verified! You can now proceed.";
            document.getElementById("message").style.color = "green";
        } else {
            document.getElementById("message").textContent = data.message;
            document.getElementById("message").style.color = "red";
        }
    });
});


        document.getElementById("payNow").addEventListener("click", function() {
            window.location.href = "payment_success.php"; // Redirect to a success page
        });
    </script>
</body>
</html>
