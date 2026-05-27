<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];

    // Update status to "Confirmed"
    $query = "UPDATE bookings SET status = 'Confirmed' WHERE id = $booking_id";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Order Confirmed!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
