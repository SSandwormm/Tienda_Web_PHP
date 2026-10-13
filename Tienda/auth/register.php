<?php
include '../includes/headerL.php';
?>

<body>

    <div class="form-container">

        <?php if (isset($_GET['error'])): ?>
            <div class="login-error">
                <img src="../assets/images/Error_Contrasena.png" alt="Error">
                <p>
                    <?php
                    if ($_GET['error'] === 'pass') {
                        echo 'Las contraseñas no coinciden';
                    } elseif ($_GET['error'] === 'email') {
                        echo 'El correo ya está registrado';
                    }
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <form action="ValidarRegistro.php" method="post">
            <h3>Registrarse</h3>

            <input type="text" name="name" placeholder="Nombre" required class="box">
            <input type="email" name="email" placeholder="Email" required class="box">
            <input type="password" name="password" placeholder="Contraseña" required class="box">
            <input type="password" name="cpassword" placeholder="Confirmar Contraseña" required class="box">

            <input type="submit" name="submit" value="Registrarse" class="btn">

            <p>¿Ya estás registrado? <a href="login.php">Iniciar sesión</a></p>
        </form>

    </div>

</body>

</html>