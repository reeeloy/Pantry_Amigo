<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    

require_once '/xampp/htdocs/Pantry-Amigo/MVC/Modelo/ConexionBD.php'; // Asegúrate de que la ruta sea correcta
header('Content-Type: application/json'); // Devuelve JSON

$conexion = new ConexionBD();
$metodo = $_SERVER['REQUEST_METHOD']; // Obtiene el método HTTP (GET, POST, etc.)

// Manejo de solicitudes
switch ($metodo) {
    case 'GET':
        // Leer casos
        if ($conexion->abrir()) {
            $sql = "SELECT * FROM tbl_caso_donacion";
            $conexion->consulta($sql);
            $result = $conexion->obtenerResult();
            $casos = [];
            while ($fila = $result->fetch_assoc()) {
                $casos[] = $fila;
            }
            echo json_encode($casos);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'POST':
        // Crear un nuevo caso
        $datos = json_decode(file_get_contents('php://input'), true);
        if ($conexion->abrir()) {
            $sql = "INSERT INTO tbl_caso_donacion (Caso_Nombre_Caso, Caso_Descripcion, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Fund_Id, Caso_Acep_Vol) 
                    VALUES ('{$datos['nombre']}', '{$datos['descripcion']}', '{$datos['fecha_inicio']}', '{$datos['fecha_fin']}', '{$datos['estado']}', {$datos['fundacion_id']}, {$datos['acepta_voluntarios']})";
            $conexion->consulta($sql);
            echo json_encode(["mensaje" => "Caso creado correctamente"]);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'PUT':
        // Actualizar un caso existente
        $datos = json_decode(file_get_contents('php://input'), true);
        if ($conexion->abrir()) {
            $sql = "UPDATE tbl_caso_donacion 
                    SET Caso_Nombre_Caso = '{$datos['nombre']}', 
                        Caso_Descripcion = '{$datos['descripcion']}', 
                        Caso_Fecha_Inicio = '{$datos['fecha_inicio']}', 
                        Caso_Fecha_Fin = '{$datos['fecha_fin']}', 
                        Caso_Estado = '{$datos['estado']}', 
                        Caso_Fund_Id = {$datos['fundacion_id']}, 
                        Caso_Acep_Vol = {$datos['acepta_voluntarios']} 
                    WHERE Caso_Id = {$datos['id']}";
            $conexion->consulta($sql);
            echo json_encode(["mensaje" => "Caso actualizado correctamente"]);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'DELETE':
        // Eliminar un caso
        $id = $_GET['id']; // Obtén el ID del caso desde la URL
        if ($conexion->abrir()) {
            $sql = "DELETE FROM tbl_caso_donacion WHERE Caso_Id = $id";
            $conexion->consulta($sql);
            echo json_encode(["mensaje" => "Caso eliminado correctamente"]);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>