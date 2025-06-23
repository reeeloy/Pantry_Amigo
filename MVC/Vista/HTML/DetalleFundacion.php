<?php
include '../../Modelo/ConexionBD.php';

// Obtener el ID de la fundación desde la URL
if (isset($_GET['id'])) {
  $fundacionId = $_GET['id'];

  // Conexión a la base de datos
  $conexion = new ConexionBD();
  $conn = $conexion->conexion;

  try {
    // Consulta para obtener los detalles de la fundación por ID
    $sql = "
            SELECT
                Fund_Id             AS ID,
                Fund_Correo         AS Correo,
                Fund_Username       AS Nombre,
                Fund_Direccion      AS Direccion,
                Fund_Descripcion  AS Descripcion,
                Fund_Telefono       AS Telefono
            FROM tbl_fundaciones
            WHERE Fund_Usu_Id = :id
        ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $fundacionId, PDO::PARAM_INT);
    $stmt->execute();

    $fundacion = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra la fundación
    if (!$fundacion) {
      echo "<p>Fundación no encontrada.</p>";
      exit;
    }
  } catch (PDOException $e) {
    echo "<p>Error al cargar los detalles de la fundación: " . $e->getMessage() . "</p>";
    exit;
  }
} else {
  echo "<p>El ID de la fundación no está disponible.</p>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Detalles de la Fundación</title>
  <link rel="stylesheet" href="../CSS/estiloDetalle.css" />
</head>

<body>
  <header>
    <div class="navbar section-content">
      <a href="#" class="nav-logo">
        <img src="../IMG/logosinfondo.png" alt="Logo">
        <h2 class="logo-text">PANTRY</h2>
      </a>
      <ul class="nav-menu">
        <button id="menu-close-button" class=""></button>
        <li class="nav-item">
          <a href="../HTML/index.Php" class="nav-link">INICIO</a>
        </li>
        <li class="nav-item">
          <a href="#sobre-nosotros" class="nav-link">SOBRE NOSOTROS</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link">CUENTA</a>
          <ul class="submenu">
            <li><a href="../HTML/registro.php">REGISTRARSE</a></li>
            <li><a href="../HTML/login.php">INICIAR SESION</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">INFO</a>
        </li>
      </ul>
      <button id="menu-open-button" class=""></button>
    </div>
  </header>

  <main class="container">
    <h1 class="section-title"> Información Perfil</h1>
    <div class="cards">
      <div class="profile-card">

        <div class="fundacion-detalles">

          <h2><?php echo htmlspecialchars($fundacion['Nombre']); ?></h2>
          <p><strong>Correo:</strong> <?php echo htmlspecialchars($fundacion['Correo']); ?></p>
          <p><strong>Dirección:</strong> <?php echo htmlspecialchars($fundacion['Direccion']); ?></p>
          <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($fundacion['Telefono']); ?></p>
          <p><strong>Descripcion: </strong> <?php echo htmlspecialchars($fundacion['Descripcion']); ?></p>
        </div>

      </div>

      <div class="cases-card">

      </div>

    </div>

    <a href="Fundaciones.php" class="volver-btn">Explorar mas fundaciones</a>
  </main>
</body>

</html>