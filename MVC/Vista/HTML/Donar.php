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
        <form action="../../Controlador/CrearPreferencia.php" method="POST" class="donation-form">

          <input type="hidden" name="casoId" value="<?= (int)$caso['Caso_Id'] ?>">
          <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria) ?>">

          <label for="nombre">Nombre:</label>
          <input type="text" id="nombre" name="nombre" required>

          <label for="apellido">Apellido:</label>
          <input type="text" id="apellido" name="apellido" required>

          <label for="cedula">Cédula:</label>
          <input type="text" id="cedula" name="cedula" required>

          <label for="correo">Correo:</label>
          <input type="email" id="correo" name="correo" required>

          <label for="monto">Monto a donar:</label>
          <input type="number" id="monto" name="monto" min="1000" required>

          <button type="submit" class="submit-button">Ir a pagar</button>
        </form>
        </section>
      </section>

    <?php else: ?>
      <p class="error-msg">No se encontró el caso con ID <?= htmlspecialchars($id) ?></p>
    <?php endif; ?>

  </main>

</body>
</html>
