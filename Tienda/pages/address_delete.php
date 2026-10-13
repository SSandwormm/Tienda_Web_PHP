<?php
include '../db/config.php';
session_start();

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) exit;

$stmt = $conn->prepare("DELETE FROM addresses WHERE user_id=?");
$stmt->bind_param("i", $user_id);

echo json_encode(['success' => $stmt->execute()]);
