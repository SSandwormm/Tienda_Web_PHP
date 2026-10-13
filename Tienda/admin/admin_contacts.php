<?php

// 1. INCLUSIÓN DE CONFIG: El archivo está en 'admin/'. Debe subir un nivel (../) y entrar en 'db/'.
// ANTES: include 'config.php';
include '../db/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    // 2. REDIRECCIÓN DE LOGIN: El archivo de login está en 'auth/'. Debe subir un nivel (../) y entrar en 'auth/'.
    // ANTES: header('location:login.php');
    header('location:../auth/login.php');
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
    // 3. REDIRECCIÓN DENTRO DE LA MISMA CARPETA: No necesita ../
    // ANTES: header('location:admin_contacts.php');
    header('location:admin_contacts.php');
}

?>

<?php
// 4. INCLUSIÓN DE HEADER (Admin): Está en 'includes/'. Debe subir un nivel (../).
// ANTES: include 'includes/headerA.php'; 
include '../includes/headerA.php'; ?>

<body>

    <?php
    // 5. INCLUSIÓN DE NAVBAR/HEADER (Admin): Está en 'includes/'. Debe subir un nivel (../).
    // ANTES: include 'admin_header.php'; 
    include '../admin/admin_header.php';
    ?>

    <section class="messages">

        <h1 class="title"> mensajes </h1>

        <div class="box-container">
            <?php
            $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            if (mysqli_num_rows($select_message) > 0) {
                while ($fetch_message = mysqli_fetch_assoc($select_message)) {

            ?>
                    <div class="box">
                        <p> ID Usuario : <span><?php echo $fetch_message['user_id']; ?></span> </p>
                        <p> Nombre : <span><?php echo $fetch_message['name']; ?></span> </p>
                        <p> Numero : <span><?php echo $fetch_message['number']; ?></span> </p>
                        <p> Email : <span><?php echo $fetch_message['email']; ?></span> </p>
                        <p> Mensaje : <span><?php echo $fetch_message['message']; ?></span> </p>
                        <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('borrar este mensaje?');" class="delete-btn">borrar este mensaje?</a>
                    </div>
            <?php
                };
            } else {
                echo '<p class="empty">no tienes mensajes!</p>';
            }
            ?>
        </div>

    </section>

    <script src="../assets/js/admin_script.js"></script>

</body>

</html>