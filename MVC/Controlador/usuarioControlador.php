<?php
session_start();
include '../Modelo/ConexionBDD.php';
include '../Modelo/usuario.php';
$usuario = new Usuario($conn);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $usuario->login($username, $password);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['Usu_Id'] = $row['Usu_Id']; //esta linea importante
        $_SESSION['username'] = $row['Usu_Username'];
        $_SESSION['tipo'] = $row['Usu_Tipo'];

        header("Location: " . ($row['Usu_Tipo'] == 'Administrador' ? "../Vista/HTML/pruebaAdmin.php" : "../Vista/HTML/Dashboard.php"));
        exit();
    } else {
        // Mostrar alerta y redirigir al login con un mensaje de error
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href = '../Vista/HTML/index.php';</script>";
        exit();
    }
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $tipo = $_POST['tipo'];
    $correo = $_POST['correo'];

    if ($usuario->register($username, $password, $tipo, $correo)) {
        echo "<script>alert('Registro exitoso'); window.location.href = '../Vista/HTML/index.php';</script>";
    } else {
        echo "<script>alert('Error al registrar'); window.location.href = '../Vista/HTML/index.php';</script>";
    }
}

if (isset($_POST['reset_password'])) {
    if ($usuario->resetPassword($_POST['correo'], $_POST['new_password'])) {
        echo "<script>alert('Contraseña actualizada'); window.location.href = '../Vista/HTML/index.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la contraseña'); window.location.href = '../Vista/HTML/index.php';</script>";
    }
}
?>
