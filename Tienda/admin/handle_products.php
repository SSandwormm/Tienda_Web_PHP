<?php
include '../db/config.php';
session_start();

/* =========================
      AGREGAR PRODUCTO
========================= */
if (isset($_POST['add_product'])) {

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $talla = $_POST['talla'];
    $color = $_POST['color'];
    $categoria = $_POST['categoria'];
    $material = $_POST['material'];
    $stock = $_POST['stock'];

    // Imagen
    $imagen = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];

    $ruta_guardado = "../assets/uploaded_img/" . $imagen;
    move_uploaded_file($imagen_tmp, $ruta_guardado);

    mysqli_query($conn, "INSERT INTO products(nombre, precio, imagen, talla, color, categoria, material, stock)
        VALUES('$nombre','$precio','$imagen','$talla','$color','$categoria','$material','$stock')")
        or die(mysqli_error($conn));

    header("Location: ../admin/admin_products.php");
    exit();
}


/* =========================
      ELIMINAR PRODUCTO
========================= */
if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];

    $select = mysqli_query($conn, "SELECT imagen FROM products WHERE id = '$delete_id'");
    $row = mysqli_fetch_assoc($select);

    $imagen_path = "../assets/uploaded_img/" . $row['imagen'];
    if (file_exists($imagen_path)) unlink($imagen_path);

    mysqli_query($conn, "DELETE FROM products WHERE id = '$delete_id'")
        or die(mysqli_error($conn));

    header("Location: ../admin/admin_products.php");
    exit();
}


/* =========================
      ACTUALIZAR PRODUCTO
========================= */
if (isset($_POST['update_product'])) {

    $id = $_POST['update_p_id'];
    $nombre = $_POST['update_nombre'];
    $precio = $_POST['update_precio'];
    $talla = $_POST['update_talla'];
    $color = $_POST['update_color'];
    $categoria = $_POST['update_categoria'];
    $material = $_POST['update_material'];
    $stock = $_POST['update_stock'];

    $old_image = $_POST['update_old_image'];
    $new_image = $_FILES['update_image']['name'];
    $new_image_tmp = $_FILES['update_image']['tmp_name'];

    if (!empty($new_image)) {

        $old_path = "../assets/uploaded_img/" . $old_image;
        if (file_exists($old_path)) unlink($old_path);

        move_uploaded_file($new_image_tmp, "../assets/uploaded_img/" . $new_image);

        $imagen_final = $new_image;
    } else {
        $imagen_final = $old_image;
    }

    mysqli_query($conn, "UPDATE products SET 
        nombre='$nombre',
        precio='$precio',
        imagen='$imagen_final',
        talla='$talla',
        color='$color',
        categoria='$categoria',
        material='$material',
        stock='$stock'
        WHERE id='$id'")
        or die(mysqli_error($conn));

    header("Location: ../admin/admin_products.php");
    exit();
}
