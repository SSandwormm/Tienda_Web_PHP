<?php
// 1. INCLUSIÓN DE CONFIG
include '../db/config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

// Validar sesión
if (!isset($admin_id)) {
    header('location:../auth/login.php');
    exit();
}
?>

<?php include '../includes/headerA.php'; ?>

<body>

    <?php include '../admin/admin_header.php'; ?>

    <!-- FORMULARIO AGREGAR PRODUCTOS -->
    <section class="add-products">

        <form action="../admin/handle_products.php" method="post" enctype="multipart/form-data">
            <h3>Agregar Productos</h3>

            <input type="text" name="nombre" class="box" placeholder="Nombre del producto" required>
            <input type="number" min="0" name="precio" class="box" placeholder="Precio del producto" required>
            <input type="text" name="talla" class="box" placeholder="Talla (S, M, L, etc.)">
            <input type="text" name="color" class="box" placeholder="Color">
            <input type="text" name="categoria" class="box" placeholder="Categoría">
            <input type="text" name="material" class="box" placeholder="Material">
            <input type="number" min="0" name="stock" class="box" placeholder="Stock disponible">

            <!-- IMPORTANTE: EL NOMBRE DEBE COINCIDIR CON LA BD (imagen) -->
            <input type="file" name="imagen" accept="image/jpg, image/jpeg, image/png" class="box" required>

            <input type="submit" value="Agregar producto" name="add_product" class="btn">
        </form>

    </section>

    <!-- MOSTRAR PRODUCTOS -->
    <section class="show-products">

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="box">
                        <img src="../assets/uploaded_img/<?php echo $fetch_products['imagen']; ?>" alt="">

                        <div class="info">
                            <div class="name"><?php echo $fetch_products['nombre']; ?></div>
                            <div class="price">$<?php echo $fetch_products['precio']; ?> COP</div>

                            <p>Talla: <?php echo $fetch_products['talla']; ?></p>
                            <p>Color: <?php echo $fetch_products['color']; ?></p>
                            <p>Categoría: <?php echo $fetch_products['categoria']; ?></p>
                            <p>Material: <?php echo $fetch_products['material']; ?></p>
                            <p>Stock: <?php echo $fetch_products['stock']; ?></p>
                        </div>

                        <div class="actions">
                            <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Actualizar</a>

                            <a href="../admin/handle_products.php?delete=<?php echo $fetch_products['id']; ?>"
                                class="delete-btn"
                                onclick="return confirm('¿Eliminar este producto?');">
                                Eliminar
                            </a>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no se han añadido productos!</p>';
            }
            ?>
        </div>

    </section>

    <!-- FORMULARIO EDITAR PRODUCTO -->
    <section class="edit-product-form">

        <?php
        if (isset($_GET['update'])) {

            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'")
                or die('query failed');

            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>

                    <form action="../admin/handle_products.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['imagen']; ?>">

                        <img src="../assets/uploaded_img/<?php echo $fetch_update['imagen']; ?>" alt="">

                        <input type="text" name="update_nombre" class="box" value="<?php echo $fetch_update['nombre']; ?>" required>
                        <input type="number" min="0" name="update_precio" class="box" value="<?php echo $fetch_update['precio']; ?>" required>
                        <input type="text" name="update_talla" class="box" value="<?php echo $fetch_update['talla']; ?>">
                        <input type="text" name="update_color" class="box" value="<?php echo $fetch_update['color']; ?>">
                        <input type="text" name="update_categoria" class="box" value="<?php echo $fetch_update['categoria']; ?>">
                        <input type="text" name="update_material" class="box" value="<?php echo $fetch_update['material']; ?>">
                        <input type="number" min="0" name="update_stock" class="box" value="<?php echo $fetch_update['stock']; ?>">

                        <input type="file" name="update_image" class="box" accept="image/jpg, image/jpeg, image/png">

                        <div class="update-buttons">
                            <input type="submit" value="Actualizar" name="update_product" class="btn btn-update">
                            <button type="button" id="close-update" class="btn btn-cancel">Cancelar</button>
                        </div>

                    </form>

        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>

    </section>

    <script src="../assets/js/admin_script.js"></script>

</body>

</html>