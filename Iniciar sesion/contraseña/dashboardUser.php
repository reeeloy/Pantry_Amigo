<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 3) { // Suponiendo que el rol de fundacion es 3
    header("Location: ../index.php");
    exit();
}

// Conecta a la base de datos
require_once '../config/Connection.php';
$connection = new Connection();
$pdo = $connection->connect();

// Obtiene la lista de usuarios
$sql = "SELECT id, username FROM usuarios";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Fundacion</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <div class="sidebar">
        <h2></h2>
        <a href="secretary_dashboard.php">Inicio</a>
        <a href="register.php">Agregar Usuario</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard de Fundacion</h1>
        </div>
        
        <div class="user-list">
            <h2>Lista de Usuarios</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
