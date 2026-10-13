<?php
include '../db/config.php';
session_start();

/* ======================
   VALIDAR SESIÓN
====================== */
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:../auth/login.php');
    exit;
}

/* ======================
   AGREGAR AL CARRITO
====================== */
if (isset($_POST['add_to_cart'])) {

    $product_name  = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = (float) $_POST['product_price'];
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_qty   = (int) $_POST['product_quantity'];

    $check_cart = mysqli_query(
        $conn,
        "SELECT * FROM cart 
         WHERE name = '$product_name' 
         AND user_id = '$user_id'"
    );

    if (mysqli_num_rows($check_cart) > 0) {
        $message[] = 'Este producto ya está en el carrito';
    } else {
        mysqli_query(
            $conn,
            "INSERT INTO cart (user_id, name, price, quantity, image)
             VALUES ('$user_id','$product_name','$product_price','$product_qty','$product_image')"
        );
        $message[] = 'Producto agregado al carrito';
    }
}
?>

<?php include '../includes/header.php'; ?>

<body>

    <?php include '../includes/headerU.php'; ?>

    <!-- ======================
     SEARCH PAGE
====================== -->
    <section class="search-page">

        <!-- BUSCADOR (NO TOCADO) -->
        <section class="search-form">
            <form action="" method="post">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar productos..."
                    class="box"
                    required>
                <input type="submit" name="submit" value="Buscar" class="btn">
            </form>
        </section>

        <!-- ESTADO VACÍO: IMAGEN + TEXTO -->
        <?php if (!isset($_POST['submit'])) : ?>
            <div class="search-empty-state">
                <img src="../assets/images/Buscar.png" alt="Buscar producto">
                <p>Busca un producto</p>
            </div>
        <?php endif; ?>

        <!-- RESULTADOS -->
        <section class="search-results">
            <div class="search-box-container">

                <?php
                if (isset($_POST['submit'])) {

                    $search_item = mysqli_real_escape_string($conn, $_POST['search']);

                    $query = mysqli_query(
                        $conn,
                        "SELECT * FROM products 
                     WHERE nombre LIKE '%$search_item%'"
                    );

                    if (mysqli_num_rows($query) > 0) {
                        while ($product = mysqli_fetch_assoc($query)) {
                ?>
                            <form action="" method="post" class="search-box">

                                <img
                                    src="../assets/uploaded_img/<?php echo $product['imagen']; ?>"
                                    alt="<?php echo $product['nombre']; ?>">

                                <div class="name">
                                    <?php echo $product['nombre']; ?>
                                </div>

                                <div class="price">
                                    $<?php echo number_format($product['precio'], 0, ',', '.'); ?>
                                </div>

                                <input
                                    type="number"
                                    name="product_quantity"
                                    min="1"
                                    max="<?php echo $product['stock']; ?>"
                                    value="1"
                                    class="qty">

                                <input type="hidden" name="product_name" value="<?php echo $product['nombre']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $product['precio']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $product['imagen']; ?>">

                                <input
                                    type="submit"
                                    name="add_to_cart"
                                    value="Añadir al carrito"
                                    class="btn">
                            </form>
                <?php
                        }
                    } else {
                        echo '<p class="empty">No se encontraron productos</p>';
                    }
                }
                ?>

            </div>
        </section>

    </section>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/admin_script.js"></script>

</body>

</html>