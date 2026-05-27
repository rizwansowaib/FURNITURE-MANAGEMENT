<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: users.php');
        exit();
    } else {
        echo "Error deleting user.";
    }
}
?>
