<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone']; // Updated to 'phone'

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Email already registered. Please use another email.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql_insert = "INSERT INTO users (username, email, password, phone) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $username, $email, $hashed_password, $phone);

        if ($stmt_insert->execute()) {
            echo "Registration successful. You can now <a href='login.html'>login</a>.";
        } else {
            echo "Error: " . $stmt_insert->error;
        }
    }
}
?>
