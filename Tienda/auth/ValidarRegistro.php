<?php

include '../db/config.php';

if (isset($_POST['submit'])) {

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $pass  = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);

    $pass  = mysqli_real_escape_string($conn, $pass);
    $cpass = mysqli_real_escape_string($conn, $cpass);

    // 🔒 Rol por defecto
    $user_type = 'user';

    // Verificar si el email ya existe
    $select_users = mysqli_query(
        $conn,
        "SELECT id FROM users WHERE email = '$email' LIMIT 1"
    ) or die('query failed');

    // ❌ Email duplicado
    if (mysqli_num_rows($select_users) > 0) {
        header("Location: register.php?error=email");
        exit();
    }

    // ❌ Contraseñas diferentes
    if ($pass !== $cpass) {
        header("Location: register.php?error=pass");
        exit();
    }

    // ✅ Registro correcto
    mysqli_query(
        $conn,
        "INSERT INTO users (name, email, password, user_type)
         VALUES ('$name', '$email', '$pass', '$user_type')"
    ) or die('query failed');

    header('Location: login.php');
    exit();
}
