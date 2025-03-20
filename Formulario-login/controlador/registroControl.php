<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../modelo/conexionBD.php'; // Conexión a la base de datos
include '../modelo/registro.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $tipo = trim($_POST['tipo']);
    $correo = trim($_POST['correo']);

    $user = new Usuario($conn);
    $result = $user->registrarUsuario($username, $password, $tipo, $correo);

    if ($result === true) {
        header("Location: ../vista/dashboard.php"); // Redirigir a la página principal
        exit();
    } else {
        echo "<p style='color:red;'>$result</p>";
    }
}
?>
