<?php

include '../db/config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:../auth/login.php');
    exit;
}

?>

<?php include '../includes/header.php'; ?>

<body>

    <?php include '../includes/headerU.php'; ?>

    <section class="placed-orders">

        <h1 class="title">Pedidos realizados</h1>

        <div class="box-container">

            <?php
            $order_query = mysqli_query(
                $conn,
                "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY placed_on DESC"
            ) or die('query failed');

            if (mysqli_num_rows($order_query) > 0) {
                while ($order = mysqli_fetch_assoc($order_query)) {
            ?>
                    <div class="box">

                        <p>
                            <strong>Fecha del pedido:</strong>
                            <span><?php echo $order['placed_on']; ?></span>
                        </p>

                        <p>
                            <strong>Nombre:</strong>
                            <span><?php echo $order['name']; ?></span>
                        </p>

                        <p>
                            <strong>Email:</strong>
                            <span><?php echo $order['email']; ?></span>
                        </p>

                        <p>
                            <strong>Teléfono:</strong>
                            <span><?php echo $order['number']; ?></span>
                        </p>

                        <p>
                            <strong>Dirección:</strong>
                            <span><?php echo $order['address']; ?></span>
                        </p>

                        <p>
                            <strong>Método de pago:</strong>
                            <span><?php echo $order['method']; ?></span>
                        </p>

                        <p>
                            <strong>Productos:</strong><br>
                            <span><?php echo $order['total_products']; ?></span>
                        </p>

                        <p>
                            <strong>Total pagado:</strong>
                            <span>$<?php echo number_format($order['total_price'], 0, ',', '.'); ?> COP</span>
                        </p>

                        <p>
                            <strong>Estado del pago:</strong>
                            <span style="color:<?php echo ($order['payment_status'] == 'pending') ? 'red' : 'green'; ?>">
                                <?php echo $order['payment_status']; ?>
                            </span>
                        </p>

                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no se han realizado pedidos!</p>';
            }
            ?>

        </div>

    </section>

    <section class="home-contact"></section>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/admin_script.js"></script>

</body>

</html>