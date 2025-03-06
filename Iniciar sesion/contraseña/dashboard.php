<?php
if ($_SESSION['role_id'] != 1) {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <div class="sidebar">
        <a href="#">Dashboard</a>
        <a href="#">Inicio</a>
        <a href="#">Estadísticas</a>
        <a href="#">Informes</a>
        <a href="#">Configuración</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>

    <div class="main">
        <h1>Bienvenido al Dashboard</h1>
        
        <h2>Resumen de Actividades</h2>
        <p>Aquí puedes ver un resumen de tus actividades recientes.</p>

        <div class="card">
            <h3>Estadísticas Recientes</h3>
            <p>Visualiza las estadísticas más recientes aquí.</p>
        </div>

        <div class="card">
            <h3>Informes Generales</h3>
            <p>Consulta los informes generales de tu sistema.</p>
        </div>
    </div>
</body>
</html>
