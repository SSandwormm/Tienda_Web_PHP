<?php

include '../db/config.php';
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // (mantengo tu lógica)
    $pass = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$pass' LIMIT 1";
    $select_users = mysqli_query($conn, $query);

    if (!$select_users) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($select_users) > 0) {

        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] === 'admin') {

            $_SESSION['admin_name']  = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id']    = $row['id'];

            header('Location: ../admin/admin_page.php');
            exit();
        } elseif ($row['user_type'] === 'user') {

            $_SESSION['user_name']  = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id']    = $row['id'];

            header('Location: ../pages/home.php');
            exit();
        }
    } else {
        // 🔴 LOGIN FALLIDO → VOLVER AL LOGIN CON ERROR
        header("Location: login.php?error=1");
        exit();
    }
}
