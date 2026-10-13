<?php
include '../db/config.php';
session_start();
$user_id = $_SESSION['user_id'];
?>

<?php include '../includes/header.php'; ?>

<body>

    <?php include '../includes/headerU.php'; ?>

    <section class="contact">

        <form action="Envimensaje.php" method="post">

            <!-- MENSAJE ENVIADO -->
            <?php if (isset($_GET['sent'])): ?>
                <div class="contact-success">
                    <img src="../assets/images/Enviado.png" alt="Mensaje enviado">
                    <p>Mensaje enviado correctamente</p>
                </div>
            <?php endif; ?>

            <h3>¡Cuéntanos!</h3>

            <input type="text" name="name" required placeholder="Nombre" class="box">
            <input type="email" name="email" required placeholder="Email" class="box">
            <input type="number" name="number" required placeholder="Número" class="box">
            <textarea name="message" class="box" required placeholder="Mensaje" rows="6"></textarea>

            <input type="submit" value="Enviar Mensaje" name="send" class="btn">

        </form>

    </section>

    <?php include '../includes/footer.php'; ?>

</body>

</html>