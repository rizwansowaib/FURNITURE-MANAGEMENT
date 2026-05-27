<?php
include('config1.php');

// Replace these with the admin's details
$name = "Admin Name";
$email = "admin@example.com";
$password = password_hash("adminpassword", PASSWORD_DEFAULT);

// Insert the admin user into the database
$sql = "INSERT INTO admin_users (name, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);
if (mysqli_stmt_execute($stmt)) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
?>
