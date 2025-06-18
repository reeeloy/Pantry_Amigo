<?php
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

require_once '../../vendor/autoload.php';
require_once '../../Modelo/ConexionBD.php';

// ---------- API de preferencia (cuando se hace POST AJAX) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generar_preferencia'])) {
    MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952'); // Tu access token

    $client = new PreferenceClient();

    $preference = $client->create([
        "items" => [[
            "id" => "caso_" . $_POST['casoId'],
            "title" => "Donación caso #" . $_POST['casoId'],
            "quantity" => 1,
            "unit_price" => floatval($_POST['monto']),
        ]],
        "statement_descriptor" => "Donación Pantry",
        "external_reference" => "donacion_" . uniqid(),
        "back_urls" => [
            "success" => "https://tusitio.com/Pantry_Amigo/MVC/Vista/HTML/RegDonacion.php?" . http_build_query($_POST)
        ],
        "auto_return" => "approved"
    ]);

    echo json_encode(["preference_id" => $preference->id]);
    exit;
}

// ---------- Obtiene el caso a mostrar ----------
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
  <main>
    <section class="section-donation">
      <?php if ($caso): ?>
        <h2>Estás apoyando a:</h2>
        <img src="/Pantry_Amigo/<?= htmlspecialchars($caso['Caso_Imagen']) ?>" alt="Imagen del caso" width="300">
        <p><?= htmlspecialchars($caso['Caso_Nombre']) ?></p>
        <p><?= nl2br(htmlspecialchars($caso['Caso_Descripcion'])) ?></p>

        <form id="form-donacion">
          <input type="hidden" name="casoId" value="<?= (int)$caso['Caso_Id'] ?>">
          <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria) ?>">

          <label>Nombre:</label>
          <input type="text" name="nombre" required><br>

          <label>Apellido:</label>
          <input type="text" name="apellido" required><br>

          <label>Cédula:</label>
          <input type="text" name="cedula" required><br>

          <label>Correo:</label>
          <input type="email" name="correo" required><br>

          <label>Monto (mín. $3000):</label>
          <input type="number" name="monto" id="monto" required><br>

          <button type="submit">Generar botón de pago</button>
        </form>

        <div id="wallet_container" style="margin-top: 20px;"></div>
      <?php else: ?>
        <p>No se encontró el caso.</p>
      <?php endif; ?>
    </section>
  </main>

  <script>
    const mp = new MercadoPago("APP_USR-8cf87360-1878-4484-be17-19415e2931e7", { locale: "es-CO" });

    const form = document.getElementById("form-donacion");
    const walletContainer = document.getElementById("wallet_container");

    form.addEventListener("submit", async function (e) {
      e.preventDefault();

      const formData = new FormData(form);
      const monto = parseFloat(formData.get("monto"));

      if (isNaN(monto) || monto < 3000) {
        Swal.fire('⚠️ Monto inválido', 'El monto mínimo es $3.000 COP.', 'warning');
        return;
      }

      formData.append("generar_preferencia", "1");

      const response = await fetch("", {
        method: "POST",
        body: formData
      });

      const result = await response.json();

      if (result.preference_id) {
        walletContainer.innerHTML = ""; // Limpia contenedor

        mp.bricks().create("wallet", "wallet_container", {
          initialization: {
            preferenceId: result.preference_id,
            redirectMode: 'modal'
          },
          customization: {
            texts: { action: 'pay', valueProp: 'security_details' },
            visual: { buttonBackground: 'black' }
          }
        });
      } else {
        Swal.fire('❌ Error', 'No se pudo generar la preferencia de pago.', 'error');
      }
    });
  </script>
</body>
</html>
