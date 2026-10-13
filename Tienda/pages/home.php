<?php
include '../db/config.php';
session_start();

/* =========================
   VALIDAR SESIÓN
========================= */
if (!isset($_SESSION['user_id'])) {
    header('location:../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

/* =========================
   AGREGAR AL CARRITO
========================= */
if (isset($_POST['add_to_cart'])) {

    $product_id       = (int) $_POST['product_id'];
    $product_name     = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price    = (float) $_POST['product_price'];
    $product_image    = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_quantity = (int) $_POST['product_quantity'];
    $product_stock    = (int) $_POST['product_stock'];
    $product_talla    = mysqli_real_escape_string($conn, $_POST['product_talla']);

    if ($product_stock <= 0) {
        $message[] = 'Este producto no tiene stock disponible';
    } elseif ($product_quantity > $product_stock) {
        $message[] = "Solo hay $product_stock unidades disponibles";
    } else {

        $check_cart = mysqli_query(
            $conn,
            "SELECT * FROM cart 
             WHERE user_id = '$user_id' 
             AND name = '$product_name'
             AND talla = '$product_talla'"
        );

        if (mysqli_num_rows($check_cart) > 0) {

            $cart_item   = mysqli_fetch_assoc($check_cart);
            $new_quantity = $cart_item['quantity'] + $product_quantity;

            if ($new_quantity > $product_stock) {
                $message[] = "No puedes superar el stock disponible ($product_stock)";
            } else {
                mysqli_query(
                    $conn,
                    "UPDATE cart 
                     SET quantity = '$new_quantity'
                     WHERE id = '{$cart_item['id']}'"
                );
                $message[] = 'Cantidad actualizada en el carrito';
            }
        } else {

            mysqli_query(
                $conn,
                "INSERT INTO cart (user_id, name, price, quantity, stock, talla, image)
                 VALUES (
                    '$user_id',
                    '$product_name',
                    '$product_price',
                    '$product_quantity',
                    '$product_stock',
                    '$product_talla',
                    '$product_image'
                 )"
            );

            $message[] = 'Producto agregado al carrito';
        }
    }
}

include '../includes/header.php';
?>

<body>
    <section class="block-model">
        <!-- COLUMNA IZQUIERDA -->
        <div class="hero-card light">
            <div class="hero-text-top">
            </div>

            <img src="../assets/images/model1.png" alt="Modelo 1">

            <div class="hero-bottom">
                <h1>Black</h1>
            </div>
        </div>

        <!-- COLUMNA DERECHA -->
        <div class="hero-card dark">
            <img src="../assets/images/model2.png" alt="Modelo 2">
            <h1 class="name">White</h1>
        </div>
    </section>
    <!-- =========================
        HERO SECTION
========================= -->
    <section class="hero">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1>Eleva tu estilo</h1>
            <p>Zapatillas y ropa exclusiva con autenticidad garantizada</p>
            <a href="#productos" class="hero-btn">Ver productos</a>
        </div>
    </section>

    <!-- =========================
        PRODUCTOS
========================= -->
    <section class="products" id="productos">

        <h1 class="title">Últimos productos</h1>

        <div class="box-container">

            <?php
            $select_products = mysqli_query(
                $conn,
                "SELECT * FROM products ORDER BY id DESC LIMIT 6"
            );

            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>

                    <form action="" method="post" class="box">

                        <img class="image"
                            src="../assets/uploaded_img/<?php echo $fetch_products['imagen']; ?>"
                            alt="<?php echo $fetch_products['nombre']; ?>">

                        <div class="name"><?php echo $fetch_products['nombre']; ?></div>
                        <div class="price">$<?php echo number_format($fetch_products['precio'], 0, ',', '.'); ?> COP</div>

                        <p class="stock">
                            Stock disponible: <?php echo $fetch_products['stock']; ?>
                        </p>

                        <p class="talla">
                            Talla base: <strong><?php echo $fetch_products['talla']; ?></strong>
                        </p>

                        <select name="product_talla" class="select">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>

                        <input type="number"
                            name="product_quantity"
                            min="1"
                            value="1"
                            class="qty"
                            max="<?php echo $fetch_products['stock']; ?>">

                        <!-- HIDDEN INPUTS -->
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['nombre']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['precio']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['imagen']; ?>">
                        <input type="hidden" name="product_stock" value="<?php echo $fetch_products['stock']; ?>">

                        <input type="submit"
                            name="add_to_cart"
                            value="Añadir al carrito"
                            class="btn">
                    </form>

            <?php
                }
            } else {
                echo '<p class="empty">No hay productos disponibles.</p>';
            }
            ?>

        </div>

        <div class="load-more">
            <a href="../pages/shop.php" class="option-btn">Cargar más</a>
        </div>

    </section>

    <!-- =========================
   BENEFICIOS MATERIAL CAMISETA
========================= -->
    <section class="benefits-section">

        <div class="benefits-header">
            <span class="benefits-subtitle">CALIDAD GARANTIZADA</span>
            <h2>Compra con seguridad y estilo</h2>
            <p>Materiales seleccionados para máxima comodidad y durabilidad</p>
        </div>

        <div class="benefits-layout">

            <!-- LADO IZQUIERDO -->
            <div class="benefits-column">
                <div class="benefit-card">
                    <h4>Algodón Premium</h4>
                    <p>Tejido suave, resistente y transpirable.</p>
                </div>

                <div class="benefit-card">
                    <h4>Costuras Reforzadas</h4>
                    <p>Mayor durabilidad para uso diario.</p>
                </div>
            </div>

            <!-- IMAGEN CENTRAL -->
            <div class="benefits-image">
                <img src="../assets/images/img_index3.png" alt="Camiseta premium Goat">
            </div>

            <!-- LADO DERECHO -->
            <div class="benefits-column">
                <div class="benefit-card">
                    <h4>Ajuste Perfecto</h4>
                    <p>Diseño moderno que se adapta al cuerpo.</p>
                </div>

                <div class="benefit-card">
                    <h4>Alta Resistencia</h4>
                    <p>No pierde forma ni color con los lavados.</p>
                </div>
            </div>

        </div>

    </section>

    <!-- =========================
   SECCIÓN ZAPATILLAS
========================= -->
    <section class="shoes-section">

        <div class="shoes-container">

            <!-- IMAGEN GRANDE -->
            <div class="shoes-image-main">
                <img src="../assets/images/nikeAirmax1.png" alt="Zapatillas Goat">
            </div>

            <!-- CONTENIDO -->
            <div class="shoes-content">
                <h2>Vendemos también zapatillas exclusivas</h2>
                <p>
                    Seleccionamos zapatillas premium y streetwear de alta calidad,
                    pensadas para quienes buscan comodidad, diseño y estilo único
                    en cada paso.
                </p>

                <a href="#" class="shoes-btn">Ver zapatillas</a>

                <!-- ZAPATILLAS PEQUEÑAS -->
                <div class="shoes-gallery">
                    <div class="shoe-card">
                        <img src="../assets/images/img_index.png" alt="Zapatilla 1">
                    </div>

                    <div class="shoe-card">
                        <img src="../assets/images/nikeAirmax2.png" alt="Zapatilla 2">
                    </div>
                </div>
            </div>

        </div>

    </section>


    <?php include '../includes/footer.php'; ?>

    <script src="../assets/js/admin_script.js"></script>
</body>

</html>