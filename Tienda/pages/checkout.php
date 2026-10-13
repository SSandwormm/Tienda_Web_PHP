<?php
include '../db/config.php';
session_start();

/* ===== VALIDAR SESIÓN ===== */
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

/* ===== PROCESAR PEDIDO ===== */
if (isset($_POST['order_btn'])) {

    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);

    // Dirección completa
    $address = mysqli_real_escape_string(
        $conn,
        $_POST['street'] . ', ' .
            $_POST['extra'] . ', ' .
            $_POST['city'] . ', ' .
            $_POST['state'] . ', ' .
            $_POST['country'] . ' - ' .
            $_POST['pin_code']
    );

    $placed_on = date('Y-m-d');

    $cart_total = 0;
    $cart_products = [];

    /* ===== OBTENER PRODUCTOS DEL CARRITO ===== */
    $cart_query = mysqli_query($conn, "
        SELECT name, price, quantity 
        FROM cart 
        WHERE user_id = '$user_id'
    ");

    if (mysqli_num_rows($cart_query) > 0) {
        while ($item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $item['name'] . " ({$item['quantity']})";
            $cart_total += ($item['price'] * $item['quantity']);
        }
    }

    /* ===== VALIDACIONES ===== */
    if ($cart_total == 0) {
        $message[] = 'Tu carrito está vacío';
    } else {

        $total_products = implode(', ', $cart_products);

        // Evitar pedidos duplicados
        $check_order = mysqli_query($conn, "
            SELECT id 
            FROM orders 
            WHERE user_id = '$user_id'
            AND total_products = '$total_products'
            AND total_price = '$cart_total'
        ");

        if (mysqli_num_rows($check_order) > 0) {
            $message[] = 'Este pedido ya fue registrado';
        } else {

            // Insertar pedido
            mysqli_query($conn, "
                INSERT INTO orders 
                (user_id, name, number, email, method, address, total_products, total_price, placed_on)
                VALUES 
                ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')
            ");

            // Vaciar carrito
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

            $message[] = 'Pedido realizado correctamente';
        }
    }
}
?>

<?php include '../includes/headerU.php'; ?>

<body>

    <?php include '../includes/header.php'; ?>

    <!-- ===== MOSTRAR PEDIDO ===== -->
    <section class="display-order">
        <?php
        $grand_total = 0;

        $select_cart = mysqli_query($conn, "
    SELECT name, price, quantity 
    FROM cart 
    WHERE user_id = '$user_id'
");

        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                $grand_total += $sub_total;
        ?>
                <p>
                    <?= $fetch_cart['name']; ?>
                    <span>
                        ($<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?>)
                    </span>
                </p>
        <?php
            }
        } else {
            echo '<p class="empty">Tu carrito está vacío</p>';
        }
        ?>
        <div class="grand-total">
            Total a pagar : <span>$<?= $grand_total; ?> COP</span>
        </div>
    </section>

    <!-- ===== FORMULARIO CHECKOUT ===== -->
    <section class="checkout">
        <form action="" method="post">
            <h3>Haz tu pedido</h3>

            <div class="flex">
                <div class="inputBox">
                    <span>Nombre Completo :</span>
                    <input type="text" name="name" required>
                </div>

                <div class="inputBox">
                    <span>Número :</span>
                    <input type="number" name="number" required placeholder="3008924633">
                </div>

                <div class="inputBox">
                    <span>Email :</span>
                    <input type="email" name="email" required placeholder="correo@email.com">
                </div>

                <div class="inputBox">
                    <span>Método de pago :</span>
                    <select name="method">
                        <option value="Contra entrega">Contra entrega</option>
                        <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                        <option value="Tarjeta débito">Tarjeta débito</option>
                        <option value="Nequi">Nequi</option>
                        <option value="Paypal">Paypal</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>Dirección :</span>
                    <input type="text" name="street" required placeholder="Calle 27 sur #27C-51">
                </div>

                <div class="inputBox">
                    <span>Datos adicionales :</span>
                    <input type="text" name="extra" placeholder="Torre 23 Apto 5">
                </div>

                <div class="inputBox">
                    <span>Ciudad :</span>
                    <input type="text" name="city" required placeholder="Bogotá">
                </div>

                <div class="inputBox">
                    <span>Departamento :</span>
                    <input type="text" name="state" required placeholder="Cundinamarca">
                </div>

                <div class="inputBox">
                    <span>País :</span>
                    <input type="text" name="country" required placeholder="Colombia">
                </div>

                <div class="inputBox">
                    <span>Código Postal :</span>
                    <input type="number" name="pin_code" required placeholder="110110">
                </div>
            </div>

            <input type="submit" value="Ordenar ahora" class="btn" name="order_btn">
        </form>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="../assets/js/admin_script.js"></script>
</body>

</html>