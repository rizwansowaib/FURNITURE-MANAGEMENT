<?php
include('../Login/config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    $query = "DELETE FROM bookings WHERE id='$booking_id'";

    if (mysqli_query($conn, $query)) {
        header("Location: admin-bookings.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
