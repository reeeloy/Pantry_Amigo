<?php
// /Pantry_Amigo/MVC/Vista/HTML/obtener_TODOS_casos.php (Versión para Administrador)

header('Content-Type: application/json; charset=utf-8');
include_once '../../Modelo/ConexionBD.php';
session_start();

// Verificación de seguridad: solo un Administrador puede ver todos los casos.
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Administrador') {
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

$response = [];
$conn_obj = new ConexionBD();
$conexion = $conn_obj->abrir();

if ($conexion) {
    // Consulta que une los casos con el nombre de la fundación que lo creó
    $sql = "SELECT 
                c.*, 
                f.Fund_Username AS Nombre_Fundacion
            FROM 
                tbl_casos_dinero c
            LEFT JOIN
                tbl_fundaciones f ON c.Caso_Fund_Id = f.Fund_Id
            ORDER BY
                c.Caso_Id DESC";
    
    $result = $conexion->query($sql);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response = ['error' => 'Error en la consulta SQL: ' . $conexion->error];
    }
    $conn_obj->cerrar();
} else {
    $response = ['error' => 'No se pudo conectar a la base de datos.'];
}

echo json_encode($response);
?>