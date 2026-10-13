<?php

include '../db/config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:../auth/login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_users.php');
}

include '../includes/headerA.php';
?>

<body>

    <?php include '../admin/admin_header.php'; ?>

    <section class="add-user-form">
        <div class="form-container">

            <h3>Crear Usuario</h3>

            <form action="save_user.php" method="POST">

                <input type="text" name="name" class="box" placeholder="Nombre completo" required>

                <input type="email" name="email" class="box" placeholder="Correo" required>

                <input type="password" name="password" class="box" placeholder="Contraseña" required>

                <select name="user_type" class="box" required>
                    <option value="" disabled selected>Seleccionar rol</option>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>

                <input type="submit" value="Crear usuario" class="btn">
            </form>

        </div>
    </section>

    <section class="users">

        <h1 class="title">Cuentas de Usuario</h1>

        <div class="users-container">

            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {
            ?>
                <div class="user-card">
                    <p><strong>ID Usuario:</strong> <span><?php echo $fetch_users['id']; ?></span></p>
                    <p><strong>Nombre:</strong> <span><?php echo $fetch_users['name']; ?></span></p>
                    <p><strong>Email:</strong> <span><?php echo $fetch_users['email']; ?></span></p>

                    <p><strong>Tipo Usuario:</strong>
                        <span class="role <?php echo $fetch_users['user_type']; ?>">
                            <?php echo $fetch_users['user_type']; ?>
                        </span>
                    </p>

                    <div class="buttons">
                        <button class="edit-btn"
                            onclick="openUserModal(
        '<?php echo $fetch_users['id']; ?>',
        '<?php echo $fetch_users['name']; ?>',
        '<?php echo $fetch_users['email']; ?>',
        '<?php echo $fetch_users['user_type']; ?>' )">
                            Editar
                        </button>


                        <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>"
                            onclick="return confirm('¿Eliminar este usuario?');"
                            class="delete-btn-user">Eliminar</a>
                    </div>
                </div>
            <?php }; ?>

        </div>

    </section>


    <!-- ======================= MODAL USUARIOS ======================= -->
    <div id="editUserModal" class="edit-user-modal">
        <form action="save_user.php" method="POST">

            <span class="close-user-modal" onclick="closeUserModal()">&times;</span>

            <h3>Editar Usuario</h3>

            <input type="hidden" name="id" id="edit_user_id">

            <input type="text" name="name" id="edit_user_name" class="box" placeholder="Nombre" required>

            <input type="email" name="email" id="edit_user_email" class="box" placeholder="Correo" required>

            <select name="user_type" id="edit_user_type" class="box">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>

            <input type="submit" value="Actualizar" class="btn">

            <button type="button" onclick="closeUserModal()" class="btn cancel-btn">
                Cancelar
            </button>
        </form>

    </div>


    <script src="../assets/js/admin_script.js"></script>

</body>

</html>