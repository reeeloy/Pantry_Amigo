<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../modelo/conexionBD.php';
include '../modelo/inicioSesion.php';

$user = new Usuario($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $tipo = $_POST['tipo'];
        $correo = $_POST['correo'];

        $result = $user->registrarUsuario($username, $password, $tipo, $correo);
        if ($result === true) {
            header("Location: ../Vista/IniciarSesionFrom");
            exit();
        } else {
            $error = $result;
        }
    }

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login = $user->iniciarSesion($username, $password);
        if ($login) {
            $_SESSION['username'] = $username;
            header("Location: ../vista/dashboard.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
}
?>