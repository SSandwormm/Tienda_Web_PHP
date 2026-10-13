<?php
include '../db/config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$user_id = (int) $_SESSION['user_id'];

$query = "UPDATE users 
          SET name=?, last_name=?, cedula=?, genero=?, fecha_nacimiento=?, telefono=?
          WHERE id=?";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "ssssssi",
    $_POST['name'],
    $_POST['last_name'],
    $_POST['cedula'],
    $_POST['genero'],
    $_POST['fecha_nacimiento'],
    $_POST['telefono'],
    $user_id
);

echo json_encode([
    'success' => $stmt->execute()
]);
