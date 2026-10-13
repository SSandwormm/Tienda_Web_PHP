<?php
// 1. CONFIG
include '../db/config.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? null;

// VALIDAR SESIÓN
if (!$admin_id) {
    header('location:../auth/login.php');
    exit();
}

/* ================= CONSULTAS ================= */

$total_pendings = 0;
$select_pending = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status='pending'");
while ($row = mysqli_fetch_assoc($select_pending)) {
    $total_pendings += $row['total_price'];
}

$total_completed = 0;
$select_completed = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status='completed'");
while ($row = mysqli_fetch_assoc($select_completed)) {
    $total_completed += $row['total_price'];
}

$select_orders   = mysqli_query($conn, "SELECT * FROM orders");
$select_products = mysqli_query($conn, "SELECT * FROM products");
$select_users    = mysqli_query($conn, "SELECT * FROM users WHERE user_type='user'");
$select_admins   = mysqli_query($conn, "SELECT * FROM users WHERE user_type='admin'");
$select_accounts = mysqli_query($conn, "SELECT * FROM users");
$select_messages = mysqli_query($conn, "SELECT * FROM message");

?>

<?php include '../includes/headerA.php'; ?>

<body>

    <?php include '../admin/admin_header.php'; ?>

    <section class="dashboard">

        <div class="dashboard-header">
            <h1>Panel Administrativo</h1>
            <p>Resumen general del sistema</p>
        </div>

        <div class="stats-grid">

            <div class="stat-card pending">
                <div class="icon">💰</div>
                <div class="content">
                    <h3>$<?= number_format($total_pendings, 0, ',', '.') ?> COP</h3>
                    <span>Pagos pendientes</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="icon">✅</div>
                <div class="content">
                    <h3>$<?= number_format($total_completed, 0, ',', '.') ?> COP</h3>
                    <span>Pagos completados</span>
                </div>
            </div>

            <div class="stat-card info">
                <div class="icon">🛒</div>
                <div class="content">
                    <h3><?= mysqli_num_rows($select_orders) ?></h3>
                    <span>Pedidos</span>
                </div>
            </div>

            <div class="stat-card product">
                <div class="icon">📦</div>
                <div class="content">
                    <h3><?= mysqli_num_rows($select_products) ?></h3>
                    <span>Productos</span>
                </div>
            </div>

            <div class="stat-card user">
                <div class="icon">👤</div>
                <div class="content">
                    <h3><?= mysqli_num_rows($select_users) ?></h3>
                    <span>Usuarios</span>
                </div>
            </div>

            <div class="stat-card admin">
                <div class="icon">🛡️</div>
                <div class="content">
                    <h3><?= mysqli_num_rows($select_admins) ?></h3>
                    <span>Administradores</span>
                </div>
            </div>

            <div class="stat-card total">
                <div class="icon">📊</div>
                <div class="content">
                    <h3><?= mysqli_num_rows($select_accounts) ?></h3>
                    <span>Total cuentas</span>
                </div>
            </div>

            <div class="stat-card message">
                <div class="icon">✉️</div>
                <div class="content">
                    <h3><?= mysqli_num_rows($select_messages) ?></h3>
                    <span>Mensajes</span>
                </div>
            </div>

        </div>

    </section>

    <script src="../assets/js/admin_script.js"></script>

</body>

</html>