<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>';
    }
}
?>

<header class="header">
    <div class="header-2">
        <div class="flex">

            <a href="../pages/home.php" class="logo">Goat</a>

            <nav class="navbar">
                <a href="../pages/home.php">Inicio</a>
                <a href="../pages/about.php">Nosotros</a>
                <a href="../pages/shop.php">Tienda</a>
                <a href="../pages/contact.php">Contáctanos</a>
                <a href="../pages/oders.php">Órdenes</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars fa-fw"></div>

                <a href="../pages/search_page.php">
                    <i class="fas fa-search fa-fw"></i>
                </a>

                <div id="user-btn">
                    <i class="fas fa-user fa-fw"></i>
                </div>

                <?php
                $select_cart_number = mysqli_query(
                    $conn,
                    "SELECT * FROM `cart` WHERE user_id = '$user_id'"
                );
                $cart_rows_number = mysqli_num_rows($select_cart_number);
                ?>

                <a href="../pages/cart.php">
                    <i class="fas fa-shopping-cart fa-fw"></i>
                    <span>(<?php echo $cart_rows_number; ?>)</span>
                </a>
            </div>

            <div class="user-box">
                <p>Nombre: <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>Email: <span><?php echo $_SESSION['user_email']; ?></span></p>

                <a href="../pages/usuario_perfil.php" class="delete-btn">Perfil</a>
                <a href="../auth/logout.php" class="delete-btn">Salir</a>
            </div>

        </div>
    </div>
</header>