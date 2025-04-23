<?php
session_start();
include("Pantry_Amigo\MVC\Modelo\ConexionBD.php");
include("Pantry_Amigo\MVC\Modelo\fundacionModelo.php");

$usuarioId = $_SESSION['Usu_Id'];

$modelo = new FundacionModelo($conn);
$datos = $modelo->obtenerPorUsuario($usuarioId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagen = $datos['Fund_Imagen'] ?? null;
    if (isset($_FILES['foto']) && $_FILES['foto']['name'] !== "") {
        $imagen = uniqid() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../imagenes/$imagen");
    }

    $entrada = [
        'username' => $_POST['Fund_Username'],
        'correo' => $_POST['Fund_Correo'],
        'direccion' => $_POST['Fund_Direccion'],
        'casos' => $_POST['Fund_Casos_Activos'],
        'telefono' => $_POST['Fund_Telefono'],
        'usuarioId' => $usuarioId,
        'imagen' => $imagen
    ];

    if (isset($_POST['registrar'])) {
        $modelo->registrar($entrada);
    } elseif (isset($_POST['actualizar'])) {
        $modelo->actualizar($entrada);
    }

    header("Location: ../vista/perfilFundacion.php");
    exit;
}
?>
