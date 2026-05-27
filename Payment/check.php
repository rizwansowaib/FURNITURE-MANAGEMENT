<?php
// Store the actual hashed password from the database
$hashed_password = '$2y$10$HghM2e9yVm7Lg5L9HRNR8O5vJvDAguBPCxkPDoRfRAdP...';

// The password entered by the user
$input_password = 'Sashank@9841';

// Verify the password
if (password_verify($input_password, $hashed_password)) {
    echo "Password is correct";
} else {
    echo "Password is incorrect";
}
?>
