<?php
require_once '../../Modelo/conexionBDD.php';
require_once '../../Modelo/donacionModelo.php';

$conexion = new ConexionBD();
$conn = $conexion->getConexion();
$modelo = new DonacionModelo($conn);

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : null;
$donaciones = $modelo->obtenerDonaciones($cedula);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Donaciones</title>
    <link rel="stylesheet" href="../CSS/estilosConsultar.css">
</head>
<body>
    <header>
    <div class="navbar section-content">
      <a href="#" class="nav-logo">
        <img src="../IMG/logosinfondo.png" alt="img">
        <h2 class="logo-text">PANTRY</h2>
      </a>
      <ul class="nav-menu">
        <button id="menu-close-button" class="fas fa-times"></button>
        <li class="nav-item">
          <a href="../HTML/index.Php" class="nav-link">HOME</a>
        </li>
        <li class="nav-item">
          <a href="#sobre-nosotros" class="nav-link">ABOUT US</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link">ACOUNT</a>
          <ul class="submenu">
            <li><a href="../HTML/registro.php">SIGN UP</a></li>
            <li><a href="../HTML/login.php">LOGIN</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="../HTML/ConsultarFundacion.php" class="nav-link">COLABORATORS</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">INFO</a>
        </li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars"></button>

    </div>
    </header>

    <div class="search-container">
        <form id="frmConsultar" method="GET">
            <input type="text" name="cedula" placeholder="Ingrese CC del donante" class="search-input">
            <input type="submit" value="Consultar" id="resEnviar">
        </form>
    </div>

    <div class="results-container">
        <?php if (!empty($donaciones)): ?>
            <?php foreach ($donaciones as $don): ?>
                <div class="result-item">
                    <span><b>Donante:</b> <?= $don['Don_Nombre_Donante'] . ' ' . $don['Don_Apellido_Donante'] ?></span><br>
                    <span><b>Cédula:</b> <?= $don['Don_Cedula_Donante'] ?></span><br>
                    <span><b>Monto:</b> $<?= number_format($don['Don_Monto'], 0, ',', '.') ?></span><br>
                    <span><b>Categoria:</b> $<?= $don['Don_Cat_Nombre']?></span><br>
                    <span><b>Correo:</b> <?= $don['Don_Correo'] ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No se encontraron donaciones.</p>
        <?php endif; ?>
    </div>
</body>
</html>
