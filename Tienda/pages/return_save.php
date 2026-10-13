<?php
include '../db/config.php';
session_start();
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false]);
    exit;
}

$query = "INSERT INTO order_returns (order_id, user_id, reason)
VALUES (?,?,?)";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "iis",
    $_POST['order_id'],
    $user_id,
    $_POST['reason']
);

echo json_encode(['success' => $stmt->execute()]);
