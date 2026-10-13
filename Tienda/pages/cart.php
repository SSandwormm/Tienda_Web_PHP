<?php

include '../db/config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:../auth/login.php');
}

// Actualizar cantidad
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
}

// Eliminar item
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

// Eliminar todo
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}

include '../includes/header.php';
?>

<body>

    <?php include '../includes/headerU.php'; ?>

    <div class="cart-wrapper">

        <h1 class="title">Productos añadidos</h1>

        <div class="cart-items">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>
                    <div class="cart-item-horizontal">

                        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>"
                            class="fas fa-times delete-icon"
                            onclick="return confirm('¿Eliminar esto del carrito?');"></a>

                        <img src="../assets/uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">

                        <div class="content">
                            <h3><?php echo $fetch_cart['name']; ?></h3>
                            <p class="price">$<?php echo $fetch_cart['price']; ?></p>

                            <form action="" method="post" class="update-form">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit" name="update_cart" value="Actualizar" class="option-btn">
                            </form>

                            <p class="subtotal">
                                Subtotal: <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?></span>
                            </p>
                        </div>

                    </div>

            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">Tu carrito está vacío</p>';
            }
            ?>
        </div>

        <div style="margin-top: 2rem; text-align:center;">
            <a href="cart.php?delete_all"
                class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>"
                onclick="return confirm('¿Eliminar todo el carrito?');">
                Borrar todo
            </a>
        </div>


        <div class="cart-actions">
            <p>Total: <span>$<?php echo $grand_total; ?></span></p>

            <div class="action-buttons">
                <a href="../pages/shop.php" class="option-btn">Seguir comprando</a>
                <a href="../pages/checkout.php"
                    class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">
                    Ir a pagar
                </a>
            </div>
        </div>

    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="../assets/js/admin_script.js"></script>

</body>

</html>