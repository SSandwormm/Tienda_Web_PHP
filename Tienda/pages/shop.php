<?php

include '../db/config.php';
session_start();

$user_id = $_SESSION['user_id'];

?>

<?php include '../includes/header.php'; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == "stock") { ?>
    <div style="
        background:#e74c3c;
        color:white;
        padding:12px;
        text-align:center;
        margin:10px auto;
        width:90%;
        border-radius:8px;
    ">
        ❌ No hay suficiente stock para agregar esa cantidad.
    </div>
<?php } ?>

<body>

    <?php include '../includes/headerU.php'; ?>

    <section class="products">

        <h1 class="title">Todos los productos</h1>

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>

                    <form action="../pages/EnviProducto.php" method="post" class="box">

                        <img class="image" src="../assets/uploaded_img/<?php echo $fetch_products['imagen']; ?>" alt="">

                        <div class="name"><?php echo $fetch_products['nombre']; ?></div>
                        <div class="price">$<?php echo number_format($fetch_products['precio']); ?> COP</div>

                        <p class="stock">Stock disponible: <?php echo $fetch_products['stock']; ?></p>

                        <p class="talla">Talla: <strong><?php echo $fetch_products['talla']; ?></strong></p>

                        <!-- Selector de talla -->
                        <select name="product_talla" class="box">
                            <option value="S" <?php if ($fetch_products['talla'] == "S") echo "selected"; ?>>S</option>
                            <option value="M" <?php if ($fetch_products['talla'] == "M") echo "selected"; ?>>M</option>
                            <option value="L" <?php if ($fetch_products['talla'] == "L") echo "selected"; ?>>L</option>
                            <option value="XL" <?php if ($fetch_products['talla'] == "XL") echo "selected"; ?>>XL</option>
                        </select>

                        <input type="number" min="1" name="product_quantity" value="1" class="qty">

                        <!-- Datos ocultos correctos -->
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['nombre']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['precio']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['imagen']; ?>">
                        <input type="hidden" name="product_stock" value="<?php echo $fetch_products['stock']; ?>">

                        <input type="submit" value="Añadir al carrito" name="add_to_cart" class="btn">

                    </form>

            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no hay productos disponibles!</p>';
            }
            ?>

        </div>

    </section>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/admin_script.js"></script>

</body>

</html>