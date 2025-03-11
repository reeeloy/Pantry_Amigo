<?php
session_start();
require_once "./Controlador/ConexionBD.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['fund_id']) || empty($_POST['fund_id'])) {
        $_SESSION['mensaje'] = "Error: ID de fundación no proporcionado.";
        header("Location: index.php");
        exit();
    }

    // Sanitizar y obtener valores
    $fund_id = intval($_POST['fund_id']);
    $correo = trim($_POST['correo']);
    $username = trim($_POST['username']);
    $direccion = trim($_POST['direccion']);
    $casos_activos = intval($_POST['casos_activos']);
    $telefono = trim($_POST['telefono']);

    // Verificar que no haya campos vacíos
    if (empty($correo) || empty($username) || empty($direccion) || empty($telefono)) {
        $_SESSION['mensaje'] = "Error: Todos los campos deben estar llenos.";
        header("Location: index.php");
        exit();
    }

    // Preparar y ejecutar la actualización
    $sql = "UPDATE tbl_fundaciones SET Fund_Correo=?, Fund_Username=?, Fund_Direccion=?, Fund_Casos_Activos=?, Fund_Telefono=? WHERE Fund_Id=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $_SESSION['mensaje'] = "Error en la preparación de la consulta.";
        header("Location: index.php");
        exit();
    }

    $stmt->bind_param("sssisi", $correo, $username, $direccion, $casos_activos, $telefono, $fund_id);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Información actualizada correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    
    header("Location: index.php");
    exit();
}
?>
