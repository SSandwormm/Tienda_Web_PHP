<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
      <div class="message">
          <span>' . $msg . '</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>


<header class="header">

    <div class="flex">

        <a href="../admin/admin_page.php" class="logo">Admin<span>GOAT</span></a>

        <nav class="navbar">
            <a href="../admin/admin_page.php">Inicio</a>
            <a href="../admin/admin_products.php">Productos</a>
            <a href="../admin/admin_orders.php">Pedidos</a>
            <a href="../admin/admin_users.php">Usuarios</a>
            <a href="../admin/admin_contacts.php">Mensajes</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>Nombre: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="../auth/logout.php" class="delete-btn">Salir</a>
        </div>

    </div>

</header>