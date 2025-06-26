<?php
// /Pantry_Amigo/MVC/Vista/HTML/eliminar_fundacion.php

header('Content-Type: application/json');
ini_set('display_errors', 1); // Activado para depuración
error_reporting(E_ALL);

include_once '../../Modelo/ConexionBD.php';
include_once '../../Modelo/usuario.php'; 
session_start();

// 1. Verificación de Seguridad: Solo un Administrador puede eliminar.
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Administrador') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit;
}

$response = ['success' => false, 'message' => 'ID de fundación no proporcionado.'];

if (isset($_POST['id'])) {
    $fundacionId = intval($_POST['id']);

    $conn_obj = new ConexionBD();
    $conexion = $conn_obj->abrir();

    if ($conexion) {
        $conexion->begin_transaction(); // Iniciamos una transacción para seguridad
        try {
            // 2. Obtener el ID de usuario y los archivos antes de eliminar
            $usuarioModelo = new Usuario($conexion);
            $datosFundacion = $usuarioModelo->obtenerDatosFundacionPorId($fundacionId);
            $usuarioId = $datosFundacion['Fund_Usu_Id'] ?? null;
            $documento = $datosFundacion['Fund_Ruta_Documento'] ?? null;
            $imagen = $datosFundacion['Fund_Imagen'] ?? null;

            // 3. Eliminar todos los casos de donación de esa fundación
            $sqlCasos = "DELETE FROM tbl_casos_dinero WHERE Caso_Fund_Id = ?";
            $stmtCasos = $conexion->prepare($sqlCasos);
            $stmtCasos->bind_param("i", $fundacionId);
            $stmtCasos->execute();
            $stmtCasos->close();

            // 4. Eliminar el registro de la fundación
            $sqlFundacion = "DELETE FROM tbl_fundaciones WHERE Fund_Id = ?";
            $stmtFundacion = $conexion->prepare($sqlFundacion);
            $stmtFundacion->bind_param("i", $fundacionId);
            $stmtFundacion->execute();
            $stmtFundacion->close();

            // 5. Eliminar la cuenta de usuario asociada (si existe)
            if ($usuarioId) {
                $sqlUsuario = "DELETE FROM Tbl_Usuario WHERE Usu_Id = ?";
                $stmtUsuario = $conexion->prepare($sqlUsuario);
                $stmtUsuario->bind_param("i", $usuarioId);
                $stmtUsuario->execute();
                $stmtUsuario->close();
            }

            // 6. Eliminar archivos físicos del servidor
            if ($documento && file_exists("../../uploads/documentos/" . $documento)) {
                unlink("../../uploads/documentos/" . $documento);
            }
            if ($imagen && $imagen !== 'default.png' && file_exists("../imagenes/" . $imagen)) {
                unlink("../imagenes/" . $imagen);
            }
            
            $conexion->commit(); // Si todo salió bien, confirmamos los cambios
            $response = ['success' => true, 'message' => 'Fundación y todos sus datos asociados han sido eliminados con éxito.'];

        } catch (Exception $e) {
            $conexion->rollback(); // Si algo falla, revertimos todo
            $response['message'] = 'Error durante la eliminación: ' . $e->getMessage();
        }
        $conn_obj->cerrar();
    } else {
        $response['message'] = "Error de conexión a la base de datos.";
    }
}

echo json_encode($response);
?>