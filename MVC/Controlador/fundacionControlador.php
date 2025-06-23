<?php
session_start();

require_once __DIR__ . '/../Modelo/ConexionBD.php';
require_once __DIR__ . '/../Modelo/fundacionModelo.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Pantry_Amigo/MVC/Vista/HTML/login.php');
    exit;
}

$usuarioId = $_SESSION['id_usuario'];

$db = new ConexionBD();
$conn = $db->conexion;
$modelo = new FundacionModelo($conn);

$datos = $modelo->obtenerPorUsuario($usuarioId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagen = $datos['Fund_Imagen'] ?? null;

    if (!empty($_FILES['foto']['name'])) {
        $imagen = uniqid() . "_" . basename($_FILES['foto']['name']);
        $uploadDir = __DIR__ . '/../Vista/IMG/';
        move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $imagen);
    }

    $entrada = [
    'username'   => $_POST['Fund_Username']       ?? '',
    'correo'     => $_POST['Fund_Correo']         ?? '',
    'direccion'  => $_POST['Fund_Direccion']      ?? '',
    'casos'      => $_POST['Fund_Casos_Activos']  ?? 0,
    'telefono'   => $_POST['Fund_Telefono']       ?? '',
    'descripcion'=> $_POST['Fund_Descripcion']    ?? '', 
    'usuarioId'  => $usuarioId,
    'imagen'     => $imagen
];

    if (isset($_POST['registrar'])) {
        $modelo->registrar($entrada);
    } elseif (isset($_POST['actualizar'])) {
        $modelo->actualizar($entrada);
    }

    header('Location: ../Vista/HTML/Fundacion_Dashboard.php');
    exit;
}
?>