<?php
// /Pantry_Amigo/MVC/Vista/HTML/RegistrarCasoDinero.php

// Aseguramos una respuesta JSON limpia
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

header('Content-Type: application/json');

include_once '../../Modelo/ConexionBD.php';
session_start();

$response = ['success' => false, 'message' => 'Error: Petición no válida.'];

// Verificamos que la sesión y el ID de la fundación existan
if (!isset($_SESSION['Fund_Id'])) {
    $response['message'] = 'Error de Sesión: ID de fundación no encontrado.';
    echo json_encode($response);
    exit();
}

// Verificamos que se esté usando el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn_obj = new ConexionBD();
    $conexion = $conn_obj->abrir();

    if (!$conexion) {
        $response['message'] = 'Error crítico al conectar con la base de datos.';
        echo json_encode($response);
        exit();
    }

    // Asignamos las variables directamente desde el formulario
    $fundacion_id = $_SESSION['Fund_Id'];
    $nombre = $_POST['Caso_Nombre'];
    $descripcion = $_POST['Caso_Descripcion'];
    $meta = $_POST['Caso_Monto_Meta'];
    $fecha_inicio = $_POST['Caso_Fecha_Inicio'];
    $fecha_fin = $_POST['Caso_Fecha_Fin'];
    $cat_id = $_POST['Caso_Cat_Id'];
    $voluntariado = isset($_POST['Caso_Voluntariado']) ? 1 : 0;
    
    // Valores por defecto
    $recaudado = 0;
    $estado = 'Activo';
    $imagen = 'default.jpg'; // Asumimos una imagen por defecto

    // Lógica para manejar la subida de imagen si se proporciona
    if (isset($_FILES['Caso_Imagen']) && $_FILES['Caso_Imagen']['error'] == 0) {
        $upload_dir = '../../uploads/casos/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = 'caso_' . uniqid() . '_' . basename($_FILES['Caso_Imagen']['name']);
        if (move_uploaded_file($_FILES['Caso_Imagen']['tmp_name'], $upload_dir . $file_name)) {
            $imagen = $file_name;
        }
    }
    
    // Usamos la tabla correcta 'tbl_casos_dinero'
    $sql = "INSERT INTO tbl_casos_dinero (Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, Caso_Voluntariado, Caso_Fund_Id, Caso_Cat_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssdissisiii", $nombre, $descripcion, $meta, $recaudado, $fecha_inicio, $fecha_fin, $estado, $imagen, $voluntariado, $fundacion_id, $cat_id);
        
        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => '¡Caso creado con éxito!'];
        } else {
            $response['message'] = 'Error al guardar en la base de datos: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Error al preparar la consulta: ' . $conexion->error;
    }
    
    $conn_obj->cerrar();
    echo json_encode($response);
}
?>