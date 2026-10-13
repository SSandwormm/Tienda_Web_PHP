<?php

include '../db/config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

?>

<?php include '../includes/header.php';
?>

<body>

    <?php include '../includes/headerU.php';
    ?>


    <section class="about-clean">

        <div class="about-container">

            <!-- TEXTO -->
            <div class="about-content">
                <span class="about-badge">SOBRE GOAT</span>

                <h1>
                    Más que una tienda,<br>
                    <span>un estilo de vida</span>
                </h1>

                <p>
                    En Goat creemos que la ropa y las zapatillas no solo se usan, se viven.
                    Seleccionamos piezas auténticas y de alta calidad que representan
                    la cultura urbana y el estilo contemporáneo.

                    Trabajamos con stock real, productos 100% originales y procesos
                    seguros para que compres con confianza y tranquilidad.

                </p>

                <a href="../pages/shop.php" class="about-btn">Explorar tienda</a>
            </div>

            <!-- IMAGEN -->
            <div class="about-image">
                <img src="../assets/images/img_about1.png" alt="Goat Style">
            </div>

        </div>

    </section>


    <!-- =========================
   SECCIÓN TIENDA FÍSICA
========================= -->
    <section class="stores-section">

        <div class="stores-container">

            <!-- Imagen única -->
            <div class="stores-image-single">
                <img src="../assets/images/img_about2.png" alt="Tienda Goat">
            </div>

            <!-- Contenido -->
            <div class="stores-content">
                <span class="stores-badge">NUESTRA TIENDA</span>
                <h2>Visítanos en nuestra<br>tienda física</h2>

                <p class="stores-desc">
                    Vive la experiencia Goat en nuestro espacio físico.
                    Encuentra productos 100% originales, atención personalizada
                    y el estilo urbano que nos representa.
                </p>

                <ul class="stores-list">
                    <li>
                        <i class="fas fa-store"></i>
                        Goat Centro – Cra 7 #12-45
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        Lunes a sábado · 10:00 AM – 8:00 PM
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        Bogota, Colombia
                    </li>
                </ul>

                <a href="../pages/contact.php" class="stores-btn">
                    Ver ubicación
                </a>
            </div>

        </div>

    </section>



    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/admin_script.js"></script>

</body>

</html>