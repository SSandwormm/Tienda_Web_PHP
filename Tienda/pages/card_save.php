<?php
include '../db/config.php';
session_start();
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false]);
    exit;
}

// ⚠️ SOLO últimos 4 dígitos
$last_four = substr($_POST['card_number'], -4);

$query = "INSERT INTO user_cards
(user_id, card_holder, card_type, last_four, exp_month, exp_year)
VALUES (?,?,?,?,?,?)";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "isssss",
    $user_id,
    $_POST['card_holder'],
    $_POST['card_type'],
    $last_four,
    $_POST['exp_month'],
    $_POST['exp_year']
);

echo json_encode(['success' => $stmt->execute()]);
