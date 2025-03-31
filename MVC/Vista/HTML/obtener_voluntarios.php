<?php
    error_reporting(0); // O configurar adecuadamente para desarrollo
    ini_set('display_errors', 0);
    header('Content-Type: application/json');
// ...
require_once '/xampp/htdocs/Pantry_Amigo/MVC/Modelo/ConexionBD.php'; // Asegúrate de que la ruta sea correcta
header('Content-Type: application/json'); // Devuelve JSON

$conexion = new ConexionBD();
$metodo = $_SERVER['REQUEST_METHOD']; // Obtiene el método HTTP (GET, POST, etc.)

// Manejo de solicitudes
switch ($metodo) {
    case 'GET':
        // Leer voluntarios
        if ($conexion->abrir()) {
            $sql = "SELECT * FROM tbl_voluntarios";
            $conexion->consulta($sql);
            $result = $conexion->obtenerResult();
            $voluntarios = [];

            while ($fila = $result->fetch_assoc()) {
                $voluntarios[] = $fila;
            }

            echo json_encode($voluntarios);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'POST':
        // Crear un nuevo voluntario
        $datos = json_decode(file_get_contents('php://input'), true);

        if (!isset($datos['nombre'], $datos['apellido'], $datos['correo'], $datos['celular'], $datos['caso_id'])) {
            echo json_encode(["error" => "Datos incompletos"]);
            exit;
        }

        if ($conexion->abrir()) {
            $sql = "INSERT INTO tbl_voluntarios (Vol_Nombre, Vol_Apellido, Vol_Correo, Vol_Celular, Vol_Caso_Id) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conexion->mySQLI->prepare($sql);
            $stmt->bind_param("ssssi", $datos['nombre'], $datos['apellido'], $datos['correo'], $datos['celular'], $datos['caso_id']);

            if ($stmt->execute()) {
                echo json_encode(["mensaje" => "Voluntario creado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al insertar voluntario"]);
            }

            $stmt->close();
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'PUT':
        // Actualizar un voluntario existente
        $datos = json_decode(file_get_contents('php://input'), true);

        if (!isset($datos['nombre'], $datos['apellido'], $datos['correo'], $datos['celular'], $datos['caso_id'], $datos['cedula'])) {
            echo json_encode(["error" => "Datos incompletos"]);
            exit;
        }

        if ($conexion->abrir()) {
            $sql = "UPDATE tbl_voluntarios 
                    SET Vol_Nombre = ?, 
                        Vol_Apellido = ?, 
                        Vol_Correo = ?, 
                        Vol_Celular = ?, 
                        Vol_Caso_Id = ? 
                    WHERE Vol_Cedula = ?";

            $stmt = $conexion->mySQLI->prepare($sql);
            $stmt->bind_param("ssssii", $datos['nombre'], $datos['apellido'], $datos['correo'], $datos['celular'], $datos['caso_id'], $datos['cedula']);

            if ($stmt->execute()) {
                echo json_encode(["mensaje" => "Voluntario actualizado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al actualizar voluntario"]);
            }

            $stmt->close();
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'DELETE':
        // Eliminar un voluntario
        if (!isset($_GET['cedula'])) {
            echo json_encode(["error" => "Cédula no proporcionada"]);
            exit;
        }

        $cedula = intval($_GET['cedula']); // Asegura que sea un número válido

        if ($conexion->abrir()) {
            $sql = "DELETE FROM tbl_voluntarios WHERE Vol_Cedula = ?";
            
            $stmt = $conexion->mySQLI->prepare($sql);
            $stmt->bind_param("i", $cedula);

            if ($stmt->execute()) {
                echo json_encode(["mensaje" => "Voluntario eliminado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al eliminar voluntario"]);
            }

            $stmt->close();
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
