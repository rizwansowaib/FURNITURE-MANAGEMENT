<?php
// Include database connection
include('../Login/config.php');

// Check if required parameters are received from eSewa
if (isset($_GET['amount']) && isset($_GET['total_amount']) && isset($_GET['transaction_uuid'])) {
    $amount = $_GET['amount'];
    $total_amount = $_GET['total_amount'];
    $transaction_uuid = $_GET['transaction_uuid'];

    // Generate a unique order ID
    $order_id = "ORD" . time();

    // Store transaction details in the database
    $sql = "INSERT INTO transactions (order_id, transaction_uuid, amount, status, created_at)
            VALUES (?, ?, ?, 'Success', NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $order_id, $transaction_uuid, $total_amount);

    if ($stmt->execute()) {
        echo "<h2>Payment Successful!</h2>";
        echo "<p>Thank you for your purchase. Your order has been placed successfully.</p>";
        echo "<p><strong>Order ID:</strong> $order_id</p>";
        echo "<p><strong>Transaction ID:</strong> $transaction_uuid</p>";
        echo "<p><strong>Amount Paid:</strong> NPR $total_amount</p>";
    } else {
        echo "<h2>Payment Failed!</h2>";
        echo "<p>There was an issue processing your payment. Please contact support.</p>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "<h2>Invalid Request</h2>";
    echo "<p>Missing payment details. Please try again.</p>";
}
?>
