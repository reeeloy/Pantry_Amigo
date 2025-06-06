<?php
// Incluye la clase de conexión a la base de datos
require_once '../../Modelo/ConexionBD.php';

// Crea una instancia de la conexión y abre la conexión
$conn = new ConexionBD();
if (!$conn->abrir()) {
  die("❌ Error al conectar con la base de datos.");
}

// Obtiene el ID del caso y la categoría desde la URL (GET), con valores por defecto
$id = $_GET['ID'] ?? 0;
$categoria = $_GET['categoria'] ?? '';

// Consulta la base de datos para obtener los detalles del caso específico
$sql = "SELECT * FROM Tbl_Casos_Dinero WHERE Caso_Id = ?";
$conn->consulta($sql, [$id]);
$result = $conn->obtenerResult();
$caso = $result->fetch_assoc(); // Obtiene los datos del caso como arreglo asociativo

// Cierra la conexión con la base de datos
$conn->cerrar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Donación</title>
  <link rel="stylesheet" href="../CSS/estilosDonacion.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Librería SweetAlert2 para mostrar alertas -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

  <!-- Encabezado de la página con navegación -->
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

  <!-- Contenido principal -->
  <main class="section-content">
    <section class="section-donation">
      <?php if ($caso): ?>
        <!-- Si se encuentra el caso, se muestra su información -->
        <h2 class="section-title">Estás apoyando a:</h2>

        <section class="detail-section">
          <!-- Imagen y descripción del caso -->
          <img src="/Pantry_Amigo/<?= htmlspecialchars($caso['Caso_Imagen']) ?>" alt="Imagen del caso" class="caso-imagen">
          <div class="detail-description">
            <h3 class="caso-nombre"><?= htmlspecialchars($caso['Caso_Nombre']) ?></h3>
            <p class="caso-descripcion"><?= nl2br(htmlspecialchars($caso['Caso_Descripcion'])) ?></p>
          </div>
        </section>

        <!-- Formulario de donación -->
        <section class="form-section">
          <h3 class="form-title">Completa tus datos</h3>
          <form action="../HTML/CrearPreferencia.php" method="POST" class="donation-form" novalidate>
            <!-- Campos ocultos para enviar ID del caso y categoría -->
            <input type="hidden" name="casoId" value="<?= (int)$caso['Caso_Id'] ?>">
            <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria) ?>">

            <!-- Campos del formulario -->
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

            <button type="submit" class="submit-button">Ir a pagar</button>
          </form>
        </section>
      <?php else: ?>
        <!-- Mensaje si no se encuentra el caso -->
        <p class="error-msg">No se encontró el caso con ID <?= htmlspecialchars($id) ?></p>
      <?php endif; ?>
    </section>
  </main>

  <!-- Script para validar el formulario antes de enviarlo -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('.donation-form');
      if (!form) return;

      form.addEventListener('submit', function(e) {
        e.preventDefault(); // Detiene el envío por defecto

        // Obtiene los valores de los campos
        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const cedula = document.getElementById('cedula').value.trim();
        const correo = document.getElementById('correo').value.trim();
        const monto = parseInt(document.getElementById('monto').value, 10);

        // Valida que todos los campos estén completos
        if (!nombre || !apellido || !cedula || !correo || isNaN(monto)) {
          Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos.',
             customClass: {
    popup: 'mi-popup',
    title: 'mi-titulo',
    icon: 'mi-icono',
    confirmButton: 'mi-boton'
  }
            
          });
          return;
        }

        // Valida que el monto mínimo sea 1000
        if (monto < 1000) {
          Swal.fire({
            icon: 'error',
            title: 'Monto muy bajo',
            text: 'El monto mínimo de donación es 3000 COP.',
            
            customClass: {
    popup: 'mi-popup',
    title: 'mi-titulo',
    icon: 'mi-icono',
    confirmButton: 'mi-boton'
  }
          });
          return;
        }

        // Si todo es válido, envía el formulario
        form.submit();
      });
    });
  </script>

</body>

</html>