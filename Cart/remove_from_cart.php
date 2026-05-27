/* remove_from_cart.php */
<?php
session_start();
require '../Login/config.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['cart_id']) || empty($data['cart_id'])) {
    echo json_encode(["status" => "error", "message" => "Cart ID is required"]);
    exit;
}

$cart_id = (int) $data['cart_id'];
$sql = "DELETE FROM cart WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Item removed successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Item not found or already removed"]);
}
?>
