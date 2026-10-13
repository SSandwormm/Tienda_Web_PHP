<?php
include '../db/config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:../auth/login.php');
    exit;
}

/* ACTUALIZAR ESTADO DEL PAGO */
if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    mysqli_query(
        $conn,
        "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'"
    ) or die('query failed');

    $message[] = 'Estado del pedido actualizado';
}

/* ELIMINAR PEDIDO */
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
    exit;
}
?>

<?php include '../includes/headerA.php'; ?>

<body>

    <?php include '../admin/admin_header.php'; ?>

    <section class="orders">

        <h1 class="title">Pedidos realizados</h1>

        <div class="box-container">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY placed_on DESC") or die('query failed');

            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                    <div class="box">

                        <!-- DATOS DEL CLIENTE -->
                        <p><strong>Cliente:</strong>
                            <span><?php echo $fetch_orders['name']; ?></span>
                        </p>

                        <p><strong>Email:</strong>
                            <span><?php echo $fetch_orders['email']; ?></span>
                        </p>

                        <p><strong>Teléfono:</strong>
                            <span><?php echo $fetch_orders['number']; ?></span>
                        </p>

                        <!-- DIRECCIÓN -->
                        <p><strong>Dirección:</strong>
                            <span><?php echo $fetch_orders['address']; ?></span>
                        </p>

                        <!-- PRODUCTOS -->
                        <p><strong>Productos:</strong><br>
                            <span><?php echo $fetch_orders['total_products']; ?></span>
                        </p>

                        <!-- INFO DE PAGO -->
                        <p><strong>Método de pago:</strong>
                            <span><?php echo $fetch_orders['method']; ?></span>
                        </p>

                        <p><strong>Total:</strong>
                            <span>$<?php echo number_format($fetch_orders['total_price']); ?> COP</span>
                        </p>

                        <p><strong>Fecha:</strong>
                            <span><?php echo $fetch_orders['placed_on']; ?></span>
                        </p>

                        <p>
                            <strong>Estado:</strong>
                            <span style="color:<?php echo ($fetch_orders['payment_status'] == 'pending') ? 'red' : 'green'; ?>">
                                <?php echo $fetch_orders['payment_status']; ?>
                            </span>
                        </p>

                        <!-- FORM ACTUALIZAR -->
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">

                            <select name="update_payment" required>
                                <option value="" disabled selected>Cambiar estado</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="COMPLETADO">Completado</option>
                            </select>

                            <input type="submit" value="Actualizar" name="update_order" class="option-btn">

                            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>"
                                onclick="return confirm('¿Eliminar este pedido?');"
                                class="delete-btn">
                                Eliminar
                            </a>
                        </form>

                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No hay pedidos registrados</p>';
            }
            ?>
        </div>

    </section>

    <script src="../assets/js/admin_script.js"></script>

</body>

</html>