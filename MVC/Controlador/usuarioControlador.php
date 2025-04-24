<?php
session_start();
require_once __DIR__.'/../Modelo/ConexionBD.php';
require_once __DIR__.'/../Modelo/usuario.php';

$usuario = new Usuario($conn);

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['login'])) {
    $u = trim($_POST['username']);
    $p = $_POST['password'];
    $res = $usuario->login($u,$p);

    if ($res && $res->num_rows===1) {
        $row = $res->fetch_assoc();
        $_SESSION['Usu_Id']    = $row['Usu_Id'];
        $_SESSION['username']  = $row['Usu_Username'];
        $_SESSION['tipo']      = $row['Usu_Tipo'];

        if (strcasecmp($row['Usu_Tipo'],'fundacion')===0) {
            // ¡Clave! Guardar aquí el id de fundación:
            $_SESSION['id_fundacion'] = $row['Usu_Id'];
            header('Location: ../Vista/HTML/Fundacion_Dashboard.php');
            exit;
        }
        // … resto de roles …
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');window.location.href='../Vista/HTML/index.php';</script>";
        exit;
    }
}
