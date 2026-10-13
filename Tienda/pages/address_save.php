<?php
include '../db/config.php';
session_start();

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) exit;

$check = $conn->prepare("SELECT id FROM addresses WHERE user_id=?");
$check->bind_param("i", $user_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $query = "UPDATE addresses SET pais=?, departamento=?, municipio=?, calle=?, 
              info_adicional=?, barrio=?, destinatario=? WHERE user_id=?";
} else {
    $query = "INSERT INTO addresses 
              (pais, departamento, municipio, calle, info_adicional, barrio, destinatario, user_id)
              VALUES (?,?,?,?,?,?,?,?)";
}

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "sssssssi",
    $_POST['pais'],
    $_POST['departamento'],
    $_POST['municipio'],
    $_POST['calle'],
    $_POST['info_adicional'],
    $_POST['barrio'],
    $_POST['destinatario'],
    $user_id
);

echo json_encode(['success' => $stmt->execute()]);
