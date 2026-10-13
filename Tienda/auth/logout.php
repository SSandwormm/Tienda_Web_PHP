<?php

// 1. INCLUSIÓN DE CONFIG: El archivo está en 'auth/'. Debe subir un nivel (../) y entrar en 'db/'.
// ANTES: include 'config.php';
include '../db/config.php';

session_start();
session_unset();
session_destroy();

// 2. REDIRECCIÓN A LA RAÍZ: La página principal 'index.php' está en la raíz. Debe subir un nivel (../).
// ANTES: header('location:index.php');
header('location:../index.php');
