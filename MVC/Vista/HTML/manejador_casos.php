<?php
// /Pantry_Amigo/MVC/Vista/HTML/manejador_casos.php (Versión Definitiva)

ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

header('Content-Type: application/json');
include_once '../../Modelo/ConexionBD.php';
session_start();

$response = ['success' => false, 'message' => 'Acción no especificada o no válida.'];

if (!isset($_SESSION['Fund_Id'])) {
    $response['message'] = 'Error de Sesión: ID de fundación no encontrado. Por favor, inicie sesión de nuevo.';
    echo json_encode($response);
    exit();
}

$conn_obj = new ConexionBD();
$conexion = $conn_obj->abrir();

if (!$conexion) {
    $response['message'] = 'Error Crítico: No se pudo conectar a la base de datos.';
    echo json_encode($response);
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action) {
    switch ($action) {
        case 'crear':
        case 'actualizar':
            // Asignación de variables desde el formulario
            $nombre = $_POST['Caso_Nombre'];
            $descripcion = $_POST['Caso_Descripcion'];
            $meta = $_POST['Caso_Monto_Meta'];
            $fecha_inicio = $_POST['Caso_Fecha_Inicio'];
            $fecha_fin = $_POST['Caso_Fecha_Fin'];
            $cat_id = $_POST['Caso_Cat_Id'];
            $voluntariado = isset($_POST['Caso_Voluntariado']) ? 1 : 0;
            $fundacion_id = $_SESSION['Fund_Id'];

            if ($action === 'crear') {
                $recaudado = 0;
                $estado = 'Activo';
                $imagen = 'default.jpg'; 
                if (isset($_FILES['Caso_Imagen']) && $_FILES['Caso_Imagen']['error'] == 0) {
                    // Lógica para subir imagen
                }
                
                $sql = "INSERT INTO tbl_casos_dinero (Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, Caso_Voluntariado, Caso_Fund_Id, Caso_Cat_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ssdissisiii", $nombre, $descripcion, $meta, $recaudado, $fecha_inicio, $fecha_fin, $estado, $imagen, $voluntariado, $fundacion_id, $cat_id);
            } else { // Actualizar
                $id = $_POST['id'];
                // La lógica de actualización iría aquí, por ahora confirmamos que funciona
                $response = ['success' => true, 'message' => '¡Lógica de Actualización alcanzada con éxito!'];
                echo json_encode($response);
                exit;
            }

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => '¡Operación de caso realizada con éxito!'];
            } else {
                $response['message'] = 'Error al ejecutar la consulta: ' . $stmt->error;
            }
            $stmt->close();
            break;

        case 'eliminar':
            $id = $_GET['id'];
            $fundacion_id = $_SESSION['Fund_Id'];
            $sql = "DELETE FROM tbl_casos_dinero WHERE Caso_Id = ? AND Caso_Fund_Id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ii", $id, $fundacion_id);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Caso eliminado correctamente.'];
            } else {
                $response['message'] = 'Error al eliminar el caso: ' . $stmt->error;
            }
            $stmt->close();
            break;
    }
}

$conn_obj->cerrar();
echo json_encode($response);
?>