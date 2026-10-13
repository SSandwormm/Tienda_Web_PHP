<?php
include '../db/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];

/* ===== USUARIO ===== */
$userQ = $conn->prepare("
    SELECT name, last_name, email, genero, cedula, telefono, fecha_nacimiento
    FROM users WHERE id = ?
");
$userQ->bind_param("i", $user_id);
$userQ->execute();
$user = $userQ->get_result()->fetch_assoc();

if (!$user) die("Usuario no encontrado");

/* ===== DIRECCIÓN ===== */
$addrQ = $conn->prepare("SELECT * FROM addresses WHERE user_id = ? LIMIT 1");
$addrQ->bind_param("i", $user_id);
$addrQ->execute();
$address = $addrQ->get_result()->fetch_assoc();

/* ===== PEDIDOS ===== */
$orderQ = $conn->prepare("
    SELECT id, total_price, placed_on, payment_status
    FROM orders
    WHERE user_id = ?
    ORDER BY placed_on DESC
");
$orderQ->bind_param("i", $user_id);
$orderQ->execute();
$orders = $orderQ->get_result();
?>

<?php include '../includes/header.php'; ?>

<section class="profile-page">

    <!-- SIDEBAR -->
    <aside class="profile-sidebar">
        <div class="profile-user">
            <div class="avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
            <p>Hola,<br><strong><?= htmlspecialchars($user['name']) ?></strong></p>
        </div>
    </aside>

    <!-- CONTENIDO -->
    <div class="profile-content">

        <!-- PERFIL -->
        <h2>Perfil</h2>

        <div class="profile-grid">
            <div><label>Nombre</label><span><?= htmlspecialchars($user['name']) ?></span></div>
            <div><label>Apellido</label><span><?= $user['last_name'] ?: '—' ?></span></div>
            <div><label>Email</label><span><?= htmlspecialchars($user['email']) ?></span></div>
            <div><label>Género</label><span><?= $user['genero'] ?: '—' ?></span></div>
            <div><label>Cédula</label><span><?= $user['cedula'] ?: '—' ?></span></div>
            <div><label>Teléfono</label><span><?= $user['telefono'] ?: '—' ?></span></div>
            <div>
                <label>Fecha nacimiento</label>
                <span>
                    <?= $user['fecha_nacimiento']
                        ? date('d/m/Y', strtotime($user['fecha_nacimiento']))
                        : '—'; ?>
                </span>
            </div>
        </div>

        <button id="btnEdit" class="profile-btn">Editar perfil</button>

        <hr>

        <!-- DIRECCIÓN -->
        <h2>Dirección</h2>

        <?php if ($address): ?>
            <div class="profile-grid">
                <div><label>País</label><span><?= $address['pais'] ?></span></div>
                <div><label>Departamento</label><span><?= $address['departamento'] ?></span></div>
                <div><label>Municipio</label><span><?= $address['municipio'] ?></span></div>
                <div><label>Calle</label><span><?= $address['calle'] ?></span></div>
                <div><label>Barrio</label><span><?= $address['barrio'] ?></span></div>
                <div><label>Info adicional</label><span><?= $address['info_adicional'] ?: '—' ?></span></div>
                <div><label>Destinatario</label><span><?= $address['destinatario'] ?></span></div>
            </div>
        <?php else: ?>
            <p>No tienes dirección registrada.</p>
        <?php endif; ?>

        <button id="btnAddress" class="profile-btn">
            <?= $address ? 'Editar dirección' : 'Agregar dirección' ?>
        </button>

        <?php if ($address): ?>
            <button id="btnDeleteAddress" class="profile-btn danger">
                Borrar dirección
            </button>
        <?php endif; ?>

        <hr>

        <!-- TARJETA -->
        <h2>Tarjeta de crédito</h2>
        <p>No tienes tarjetas guardadas.</p>

        <button id="btnAddCard" class="profile-btn">
            Agregar tarjeta
        </button>

        <hr>

        <!-- PEDIDOS -->
        <h2>Mis pedidos</h2>

        <?php if ($orders->num_rows > 0): ?>
            <?php while ($o = $orders->fetch_assoc()): ?>
                <div class="order-box">
                    <div>
                        <strong>Pedido #<?= $o['id'] ?></strong><br>
                        Total: $<?= number_format($o['total_price'], 0, ',', '.') ?><br>
                        Fecha: <?= date('d/m/Y', strtotime($o['placed_on'])) ?>
                    </div>

                    <button class="btnReturn profile-btn"
                        data-id="<?= $o['id'] ?>">
                        Solicitar devolución
                    </button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes pedidos.</p>
        <?php endif; ?>

    </div>
</section>

<!-- ================= MODALES ================= -->

<!-- PERFIL -->
<div class="modal" id="editModal">
    <form id="editProfileForm" class="modal-content">
        <h3>Editar perfil</h3>

        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
        <input type="text" name="cedula" value="<?= htmlspecialchars($user['cedula'] ?? '') ?>">
        <input type="date" name="fecha_nacimiento" value="<?= $user['fecha_nacimiento'] ?>">
        <input type="text" name="telefono" value="<?= htmlspecialchars($user['telefono'] ?? '') ?>">

        <button type="submit">Guardar</button>
        <button type="button" id="closeModal">Cancelar</button>
    </form>
</div>

<!-- DIRECCIÓN -->
<div class="modal" id="addressModal">
    <form id="addressForm" class="modal-content">
        <h3>Dirección</h3>

        <input type="text" name="pais" value="Colombia" readonly>
        <input type="text" name="departamento" value="<?= $address['departamento'] ?? '' ?>" required>
        <input type="text" name="municipio" value="<?= $address['municipio'] ?? '' ?>" required>
        <input type="text" name="calle" value="<?= $address['calle'] ?? '' ?>" required>
        <input type="text" name="barrio" value="<?= $address['barrio'] ?? '' ?>">
        <input type="text" name="info_adicional" value="<?= $address['info_adicional'] ?? '' ?>">
        <input type="text" name="destinatario"
            value="<?= $user['name'] . ' ' . $user['last_name'] ?>" readonly>

        <button type="submit">Guardar dirección</button>
        <button type="button" id="closeAddressModal">Cancelar</button>
    </form>
</div>

<!-- TARJETA -->
<div class="modal" id="cardModal">
    <form id="cardForm" class="modal-content">
        <h3>Tarjeta de crédito</h3>

        <input type="text" placeholder="Titular" required>
        <input type="text" placeholder="Número tarjeta" required>
        <input type="text" placeholder="MM/YY" required>

        <button type="submit">Guardar tarjeta</button>
        <button type="button" id="closeCardModal">Cancelar</button>
    </form>
</div>

<!-- DEVOLUCIÓN -->
<div class="modal" id="returnModal">
    <form id="returnForm" class="modal-content">
        <h3>Solicitud de devolución</h3>

        <input type="hidden" name="order_id" id="order_id">

        <select required>
            <option value="">Motivo</option>
            <option>Producto defectuoso</option>
            <option>No era lo esperado</option>
            <option>Producto incorrecto</option>
        </select>

        <button type="submit">Enviar</button>
        <button type="button" id="closeReturnModal">Cancelar</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
<script src="../assets/js/admin_script.js"></script>