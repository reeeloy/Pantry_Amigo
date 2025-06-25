<?php
require_once '../../../MVC/Modelo/conexionBDD.php';
require_once '../../../MVC/Modelo/donacionModelo.php';

$conexion = new ConexionBD();
$conn = $conexion->getConexion();
$modelo = new DonacionModelo($conn);

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : null;
$horarios = $modelo->obtenerHorariosVoluntarios($cedula);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Horarios</title>
    <link rel="stylesheet" href="../CSS/prueba.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">   
</head>
<body>

<!-- Header -->
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

<!-- Sección de búsqueda -->
<section class="search-section">
    <div class="container">
        <h2 class="section-title">Buscar Tu Horario</h2>
        <form id="frmConsultar" method="GET" class="search-form">
            <input type="text" name="cedula" placeholder="Ingrese tu CC" class="search-input" required>
            <button type="submit" class="btn-submit">Buscar</button>
            
            <?php if (!empty($horarios)): ?>
                <button type="button" onclick="window.location.href='/Pantry_Amigo/MVC/Controlador/donacionDineroControlador.php?generar_pdf=1&cedula=<?= urlencode($cedula) ?>'" class="btn-pdf">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </button>
            <?php endif; ?>
        </form>
    </div>
</section>

<!-- Resultados -->
<section class="results-section">
    <div class="container">
        <?php if (!empty($horarios)): ?>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha y Hora de Citación</th>
                        <th>Lugar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios as $hora): ?>
                        <tr>
                            <td><?= htmlspecialchars($hora['Hora_Id']) ?></td>
                            <td><?= htmlspecialchars($hora['Hora_Citacion']) ?></td>
                            <td><?= htmlspecialchars($hora['Hora_Localizacion']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-results">No se encontraron horarios asignados.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        &copy; <?= date('Y') ?> PANTRY - Todos los derechos reservados
    </div>
</footer>

</body>
</html>