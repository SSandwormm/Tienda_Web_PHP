<?php
include '../db/config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Guardar mensaje en BD (tabla correcta: message)
    $query = mysqli_query(
        $conn,
        "INSERT INTO message (user_id, name, email, number, message) 
         VALUES ('$user_id', '$name', '$email', '$number', '$message')"
    ) or die("Error al enviar el mensaje: " . mysqli_error($conn));

    // Redirección con mensaje de éxito
    header("Location: contact.php?sent=1");
    exit;
}
