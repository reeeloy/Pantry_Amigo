<?php
// /Pantry_Amigo/MVC/Vista/HTML/obtener_fundaciones.php (Versión Actualizada)

header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL);

include_once '../../Modelo/ConexionBD.php';

$conn_obj = new ConexionBD();
$conexion = $conn_obj->abrir();
$response = [];

if ($conexion) {
    // Consulta SQL que ahora trae TODOS los campos necesarios de la tabla de fundaciones
    $sql = "SELECT 
                Fund_Id, 
                Fund_Username, 
                Fund_Correo, 
                Fund_NIT, 
                Fund_Direccion, 
                Fund_Telefono,
                Fund_Casos_Activos,
                Fund_Ruta_Documento,
                Fund_Estado_Verificacion,
                Fund_Usu_Id
            FROM 
                tbl_fundaciones"; // Asegúrate de que el nombre de la tabla sea correcto
    
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