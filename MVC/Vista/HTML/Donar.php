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
            <input type="number" id="monto" name="monto" min="3000" required>

            <p><small>Luego de completar tus datos, aparecerá el formulario de pago seguro de Mercado Pago.</small></p>

            <div id="walletBrick_container"></div>
          </form>
        </section>
      <?php else: ?>
        <p class="error-msg">No se encontró el caso con ID <?= htmlspecialchars($id) ?></p>
      <?php endif; ?>
    </section>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', async () => {
      const mp = new MercadoPago("TEST-34b09027-4aa4-4155-9769-b43bc0b9f265", {
        locale: "es-CO"
      });

      const montoInput = document.getElementById('monto');
      const form = document.getElementById('form-donacion');
      let cardPaymentBrickController = null;

      const idempotencyKey = 'donacion_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

      const crearBrick = (monto) => {
        mp.bricks().create("cardPayment", "walletBrick_container", {
          initialization: { amount: monto },
          callbacks: {
            onReady: () => console.log("✅ Brick cargado correctamente"),
            onError: (error) => {
              console.error("❌ Error cargando Brick:", error);
              Swal.fire('Error', 'No se pudo cargar el formulario de pago.', 'error');
            },
            onSubmit: async (cardFormData) => {
              if (!form.checkValidity()) {
                Swal.fire('⚠️ Faltan datos', 'Por favor completa todos los campos requeridos antes de pagar.', 'warning');
                return;
              }

              const data = {
                nombre: form.nombre.value.trim(),
                apellido: form.apellido.value.trim(),
                cedula: form.cedula.value.trim(),
                correo: form.correo.value.trim(),
                monto: monto,
                casoId: form.casoId.value,
                categoria: form.categoria.value,
                token: cardFormData.token,
                payment_method_id: cardFormData.payment_method_id,
                issuer_id: cardFormData.issuer_id,
                installments: cardFormData.installments
              };

              console.log("🟡 Enviando datos al servidor:", data);

              try {
                const response = await fetch("/Pantry_Amigo/MVC/Vista/HTML/ProcesarPago.php", {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/json",
                    "X-Idempotency-Key": idempotencyKey
                  },
                  body: JSON.stringify(data)
                });

                if (!response.ok) throw new Error("❌ Error HTTP: " + response.status);

                const result = await response.json();
                console.log("📦 Resultado del pago:", result);

                if (result.status === 'approved') {
                  Swal.fire('✅ ¡Gracias!', 'Tu donación fue aprobada con éxito', 'success');
                  // window.location.href = '/gracias.php';
                } else {
                  Swal.fire('⚠️ Pago no aprobado', result.status_detail || 'Intenta con otro medio de pago', 'warning');
                }
              } catch (error) {
                console.error("❌ Error al procesar el pago:", error);
                Swal.fire('❌ Error', 'Ocurrió un problema al procesar el pago', 'error');
              }
            }
          }
        }).then(controller => {
          cardPaymentBrickController = controller;
        });
      };

      let debounceTimer;
      montoInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          const nuevoMonto = parseFloat(montoInput.value);
          if (!isNaN(nuevoMonto)) {
            if (nuevoMonto < 3000) {
              Swal.fire('⚠️ Monto muy bajo', 'El monto mínimo es de $3.000 COP.', 'warning');
              return;
            }

            if (cardPaymentBrickController) {
              cardPaymentBrickController.unmount();
            }
            crearBrick(nuevoMonto);
          }
        }, 400);
      });

      if (montoInput.value && parseFloat(montoInput.value) >= 3000) {
        crearBrick(parseFloat(montoInput.value));
      }
    });
  </script>
</body>
</html>
