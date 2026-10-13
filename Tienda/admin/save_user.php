<?php
include '../db/config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Sanitizar datos
$name  = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$type  = mysqli_real_escape_string($conn, $_POST['user_type']);


// Si viene ID → ACTUALIZAR
if (isset($_POST['id']) && !empty($_POST['id'])) {

    $id = intval($_POST['id']);

    $query = "UPDATE users SET 
                name='$name',
                email='$email',
                user_type='$type'
              WHERE id='$id'";

    if (!mysqli_query($conn, $query)) {
        die("Error al actualizar usuario: " . mysqli_error($conn));
    }

    header("Location: admin_users.php?updated=1");
    exit;
}

// Si NO viene ID → CREAR
else {

    if (!isset($_POST['password'])) {
        die("La contraseña es obligatoria para crear un usuario.");
    }

    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password, user_type)
              VALUES ('$name', '$email', '$pass', '$type')";

    if (!mysqli_query($conn, $query)) {
        die("ERROR al crear usuario: " . mysqli_error($conn));
    }

    header("Location: admin_users.php?created=1");
    exit;
}
