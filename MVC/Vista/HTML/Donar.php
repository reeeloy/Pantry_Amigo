<?php
require_once '../../Modelo/ConexionBD.php';

$conn = new ConexionBD();
if (!$conn->abrir()) {
  die("❌ Error al conectar con la base de datos.");
}

$id = $_GET['ID'] ?? 0;
$categoria = $_GET['categoria'] ?? '';

$sql = "SELECT * FROM Tbl_Casos_Dinero WHERE Caso_Id = ?";
$conn->consulta($sql, [$id]);
$result = $conn->obtenerResult();
$caso = $result->fetch_assoc();

$conn->cerrar();

// --- MercadoPago Preference ---
require_once '../../../vendor/autoload.php';
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952');
$client = new PreferenceClient();
$preference = $client->create([
    "items" => [
        [
            "id" => "donacion_" . $id,
            "title" => "Donación para caso #" . $id,
            "quantity" => 1,
            "unit_price" => 3000.00, // Monto mínimo por defecto
        ],
    ],
    "statement_descriptor" => "Donación Pantry",
    "external_reference" => "donacion_" . $id,
]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Donación</title>
  <link rel="stylesheet" href="../CSS/estilosDonacion.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header>
    <div class="navbar">
      <a href="#" class="nav-logo" aria-label="Inicio">
        <img src="../IMG/logosinfondo.png" alt="Logo de Pantry">
        <h2 class="logo-text">PANTRY</h2>
      </a>
      <ul class="nav-menu">
        <li class="nav-item"><a href="#" class="nav-link">INFO</a></li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars" aria-label="Abrir menú"></button>
      <button id="menu-close-button" class="fas fa-times" aria-label="Cerrar menú"></button>
    </div>
  </header>

  <main class="section-content">
    <section class="section-donation">
      <?php if ($caso): ?>
        <h2 class="section-title">Estás apoyando a:</h2>

        <section class="detail-section">
          <img src="/Pantry_Amigo/<?= htmlspecialchars($caso['Caso_Imagen']) ?>" alt="Imagen del caso" class="caso-imagen">
          <div class="detail-description">
            <h3 class="caso-nombre"><?= htmlspecialchars($caso['Caso_Nombre']) ?></h3>
            <p class="caso-descripcion"><?= nl2br(htmlspecialchars($caso['Caso_Descripcion'])) ?></p>
          </div>
        </section>

        <section class="form-section">
          <h3 class="form-title">Completa tus datos</h3>
          <form id="form-donacion" class="donation-form" novalidate>
            <input type="hidden" name="casoId" value="<?= (int)$caso['Caso_Id'] ?>">
            <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria) ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios">

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios">

            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="monto">Monto a donar:</label>
            <input type="number" id="monto" name="monto" min="3000" required value="3000">

           <button type="submit" id="btn-donar">Donar ahora</button>


          </form>
          <div id="wallet_container" style="margin-top:24px; display: none;"></div>

        </section>
      <?php else: ?>
        <p class="error-msg">No se encontró el caso con ID <?= htmlspecialchars($id) ?></p>
      <?php endif; ?>
    </section>
  </main>

  <script>
const mp = new MercadoPago('APP_USR-8cf87360-1878-4484-be17-19415e2931e7', {
  locale: 'es-CO'
});

let currentBrick = null;

function renderWallet(preferenceId) {
  if (currentBrick) currentBrick.unmount();
  mp.bricks().create("wallet", "wallet_container", {
    initialization: { preferenceId, redirectMode: 'modal' },
    customization: {
      texts: { action: 'pay', valueProp: 'security_details' },
      visual: { buttonBackground: 'black' }
    }
  }).then(brick => {
    currentBrick = brick;
    document.getElementById('wallet_container').style.display = 'block'; // Mostrar contenedor
  });
}

// Ya no renderizamos nada al inicio

// Formulario
document.getElementById("form-donacion").addEventListener("submit", function(e) {
  e.preventDefault();

  const nombre = document.getElementById('nombre').value.trim();
  const apellido = document.getElementById('apellido').value.trim();
  const cedula = document.getElementById('cedula').value.trim();
  const correo = document.getElementById('correo').value.trim();
  const monto = parseFloat(document.getElementById('monto').value.trim());
  const casoId = document.querySelector('input[name="casoId"]').value;

  if (!nombre || !apellido || !cedula || !correo || isNaN(monto) || monto < 3000) {
    Swal.fire({
      icon: 'warning',
      title: 'Campos incompletos',
      text: 'Completa todos los campos y asegúrate de que el monto sea mínimo $3.000 COP.'
    });
    return;
  }

  fetch('generar_preferencia.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      nombre, apellido, cedula, correo, monto, casoId
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.preference_id) {
      renderWallet(data.preference_id);
      Swal.fire({
        icon: 'success',
        title: '¡Datos listos!',
        text: 'Tu botón de pago fue cargado.',
        timer: 2000,
        showConfirmButton: false
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: data.error || 'No se pudo generar la preferencia de pago.'
      });
    }
  });
});
</script>


</body>
</html>
