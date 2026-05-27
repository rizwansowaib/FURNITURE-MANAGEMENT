<?php
header("Content-Type: application/json");

// eSewa Secret Key (Replace this with your actual key)
$secret_key = "your_esewa_secret_key"; // Update this!

// Read the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["message"])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

// Generate HMAC-SHA256 signature
$signature = hash_hmac("sha256", $data["message"], $secret_key);

// Return the generated signature as JSON
echo json_encode(["signature" => $signature]);
?>
