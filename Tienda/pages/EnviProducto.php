<?php
include '../db/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {

    $product_id     = $_POST['product_id'];
    $product_name   = $_POST['product_name'];
    $product_price  = $_POST['product_price'];
    $product_image  = $_POST['product_image'];
    $product_talla  = $_POST['product_talla'];
    $product_qty    = $_POST['product_quantity'];

    // STOCK
    $product_stock  = $_POST['product_stock'];

    // 1️⃣ VALIDAR QUE LA CANTIDAD PEDIDA NO SUPERE EL STOCK
    if ($product_qty > $product_stock) {
        header("Location: shop.php?error=stock");
        exit();
    }

    // 2️⃣ VERIFICAR SI YA EXISTE EN EL CARRITO
    $check_cart = mysqli_query(
        $conn,
        "SELECT * FROM `cart` 
         WHERE user_id = '$user_id' 
         AND name = '$product_name'
         AND talla = '$product_talla'"
    );

    if (mysqli_num_rows($check_cart) > 0) {

        $cart_item = mysqli_fetch_assoc($check_cart);
        $current_qty = $cart_item['quantity'];
        $new_qty = $current_qty + $product_qty;

        // 3️⃣ IMPEDIR QUE LA SUMA SUPERE EL STOCK
        if ($new_qty > $product_stock) {
            header("Location: shop.php?error=stock");
            exit();
        }

        mysqli_query(
            $conn,
            "UPDATE `cart` 
             SET quantity = '$new_qty' 
             WHERE id = '{$cart_item['id']}'"
        );
    } else {

        // 4️⃣ VALIDAR STOCK EN PRODUCTOS NUEVOS
        if ($product_qty > $product_stock) {
            header("Location: shop.php?error=stock");
            exit();
        }

        mysqli_query(
            $conn,
            "INSERT INTO `cart` (user_id, name, price, image, quantity, talla)
             VALUES ('$user_id', '$product_name', '$product_price', '$product_image', '$product_qty', '$product_talla')"
        );
    }

    // 5️⃣ SIGUE EN LA TIENDA (NO VA AL CARRITO)
    header('Location: shop.php?added=1');
    exit();
}
