<?php
include '../includes/headerL.php';
?>

<body>

    <div class="form-container">

        <?php if (isset($_GET['error'])): ?>
            <div class="login-error">
                <img src="../assets/images/Error401..png" alt="No autorizado">
                <p>Email o contraseña incorrectos</p>
            </div>
        <?php endif; ?>

        <form action="ValidarSesion.php" method="post">
            <h3>Inicio de Sesión</h3>

            <input type="email" name="email" placeholder="Email" required class="box">
            <input type="password" name="password" placeholder="Contraseña" required class="box">

            <input type="submit" name="submit" value="Iniciar" class="btn">

            <p class="text-small">¿Aún no tienes cuenta? <a href="../auth/register.php">Registrarse</a></p>
            <p class="text-small">¿Quieres volver a la página principal? <a href="../index.php">Volver</a></p>
        </form>

    </div>


</body>

</html>