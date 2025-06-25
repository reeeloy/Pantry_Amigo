<?php
// /Pantry_Amigo/MVC/Vista/HTML/manejador_casos.php (Versión Definitiva y Corregida)

ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
ob_clean();

header('Content-Type: application/json; charset=utf-8');

try {
    if (!isset($_SESSION['Usu_Id']) || !isset($_SESSION['Fund_Id'])) {
        throw new Exception('Usuario no autenticado o sin fundación asociada');
    }

    include_once '../../Modelo/ConexionBD.php';
    $conn = new ConexionBD();
    $conexion = $conn->abrir();
    if (!$conexion) {
        throw new Exception('Error: No se pudo establecer conexión a la base de datos');
    }

    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    $resultado = null;

    switch ($action) {
        case 'crear':
            $resultado = crearCaso($conexion);
            break;
        case 'actualizar':
            $resultado = actualizarCaso($conexion);
            break;
        case 'eliminar':
            $resultado = eliminarCaso($conexion);
            break;
        default:
            throw new Exception('Acción no especificada o inválida');
    }
    
    if (method_exists($conn, 'cerrar')) {
        $conn->cerrar();
    }
    
    echo json_encode($resultado);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}


// --- Tu función crearCaso() funcional (SIN CAMBIOS) ---
function crearCaso($conexion) {
    try {
        $requiredFields = ['Caso_Nombre', 'Caso_Descripcion', 'Caso_Monto_Meta', 'Caso_Fecha_Inicio', 'Caso_Fecha_Fin'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("El campo $field es requerido");
            }
        }
        
        $fechaInicio = $_POST['Caso_Fecha_Inicio'];
        $fechaFin = $_POST['Caso_Fecha_Fin'];
        if (strtotime($fechaFin) <= strtotime($fechaInicio)) {
            throw new Exception('La fecha de fin debe ser posterior a la fecha de inicio');
        }
        
        $nombre = trim($_POST['Caso_Nombre']);
        $descripcion = trim($_POST['Caso_Descripcion']);
        $meta = floatval($_POST['Caso_Monto_Meta']);
        $recaudado = 0;
        $fecha_inicio = $fechaInicio;
        $fecha_fin = $fechaFin;
        $estado = 'Activo'; // Se asigna 'Activo' por defecto
        $voluntariado = isset($_POST['Caso_Voluntariado']) ? 1 : 0;
        $fund_id = $_SESSION['Fund_Id'];
        
        if ($meta <= 0) {
            throw new Exception('El monto meta debe ser mayor a 0');
        }
        
        $imagen = '';
        if (isset($_FILES['Caso_Imagen']) && $_FILES['Caso_Imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = subirImagen($_FILES['Caso_Imagen']);
            if (!$uploadResult['success']) {
                throw new Exception($uploadResult['message']);
            }
            $imagen = $uploadResult['filename'];
        }
        
        // Se mantiene tu consulta original que funciona
        $sql = "INSERT INTO tbl_casos_dinero (Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, Caso_Voluntariado, Caso_Fund_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparando consulta: ' . $conexion->error);
        }
        
        // Se mantiene tu bind_param original que funciona
        $stmt->bind_param("ssdissisii", $nombre, $descripcion, $meta, $recaudado, $fecha_inicio, $fecha_fin, $estado, $imagen, $voluntariado, $fund_id);
        
        if (!$stmt->execute()) {
            throw new Exception('Error al crear el caso: ' . $stmt->error);
        }
        
        $caso_id = $conexion->insert_id;
        $stmt->close();
        
        return ['success' => true, 'message' => 'Caso creado exitosamente', 'id' => $caso_id];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}


// --- FUNCIÓN actualizarCaso (RECONSTRUIDA Y CORREGIDA) ---
function actualizarCaso($conexion) {
    try {
        $casoId = intval($_POST['id']);
        if (empty($casoId)) {
            throw new Exception('ID del caso requerido');
        }
        
        $checkSql = "SELECT Caso_Imagen FROM tbl_casos_dinero WHERE Caso_Id = ? AND Caso_Fund_Id = ?";
        $checkStmt = $conexion->prepare($checkSql);
        $checkStmt->bind_param("ii", $casoId, $_SESSION['Fund_Id']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows === 0) {
            throw new Exception('Caso no encontrado o sin permisos');
        }
        $casoExistente = $result->fetch_assoc();
        $checkStmt->close();
        
        $nombre = trim($_POST['Caso_Nombre']);
        $descripcion = trim($_POST['Caso_Descripcion']);
        $meta = floatval($_POST['Caso_Monto_Meta']);
        $fecha_inicio = $_POST['Caso_Fecha_Inicio'];
        $fecha_fin = $_POST['Caso_Fecha_Fin'];
        $voluntariado = isset($_POST['Caso_Voluntariado']) ? 1 : 0;
        // Se obtiene el estado del formulario para guardarlo
        $estado = $_POST['Caso_Estado'];

        // (Validaciones de fecha y monto como en tu función original)
        if (strtotime($fecha_fin) <= strtotime($fecha_inicio)) throw new Exception('La fecha de fin debe ser posterior a la fecha de inicio');
        if ($meta <= 0) throw new Exception('El monto meta debe ser mayor a 0');
        
        // Lógica para construir la consulta dinámicamente
        $sql_parts = [];
        $params = [];
        $types = "";

        $sql_parts[] = "Caso_Nombre = ?"; $params[] = $nombre; $types .= "s";
        $sql_parts[] = "Caso_Descripcion = ?"; $params[] = $descripcion; $types .= "s";
        $sql_parts[] = "Caso_Monto_Meta = ?"; $params[] = $meta; $types .= "d";
        $sql_parts[] = "Caso_Fecha_Inicio = ?"; $params[] = $fecha_inicio; $types .= "s";
        $sql_parts[] = "Caso_Fecha_Fin = ?"; $params[] = $fecha_fin; $types .= "s";
        $sql_parts[] = "Caso_Voluntariado = ?"; $params[] = $voluntariado; $types .= "i";
        $sql_parts[] = "Caso_Estado = ?"; $params[] = $estado; $types .= "s";
        
        if (isset($_FILES['Caso_Imagen']) && $_FILES['Caso_Imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = subirImagen($_FILES['Caso_Imagen']);
            if (!$uploadResult['success']) throw new Exception($uploadResult['message']);
            
            if (!empty($casoExistente['Caso_Imagen']) && $casoExistente['Caso_Imagen'] != 'default.jpg') {
                $rutaAnterior = '../../uploads/casos/' . $casoExistente['Caso_Imagen'];
                if (file_exists($rutaAnterior)) unlink($rutaAnterior);
            }
            $sql_parts[] = "Caso_Imagen = ?";
            $params[] = $uploadResult['filename'];
            $types .= "s";
        }

        $params[] = $casoId;
        $types .= "i";

        $sql = "UPDATE tbl_casos_dinero SET " . implode(", ", $sql_parts) . " WHERE Caso_Id = ?";
        
        $stmt = $conexion->prepare($sql);
        if(!$stmt) throw new Exception('Error al preparar la consulta de actualización: ' . $conexion->error);

        $stmt->bind_param($types, ...$params);
        
        if (!$stmt->execute()) throw new Exception('Error al actualizar el caso: ' . $stmt->error);
        
        $stmt->close();
        
        return ['success' => true, 'message' => 'Caso actualizado exitosamente'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// --- Tu función eliminarCaso() funcional (SIN CAMBIOS) ---
function eliminarCaso($conexion) {
    try {
        $casoId = intval($_GET['id']);
        if (empty($casoId)) { throw new Exception('ID del caso requerido'); }
        $checkSql = "SELECT Caso_Imagen FROM tbl_casos_dinero WHERE Caso_Id = ? AND Caso_Fund_Id = ?";
        $checkStmt = $conexion->prepare($checkSql);
        $checkStmt->bind_param("ii", $casoId, $_SESSION['Fund_Id']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows === 0) { throw new Exception('Caso no encontrado o sin permisos'); }
        $caso = $result->fetch_assoc();
        $checkStmt->close();
        if (!empty($caso['Caso_Imagen']) && $caso['Caso_Imagen'] != 'default.jpg') {
            $rutaImagen = '../../uploads/casos/' . $caso['Caso_Imagen'];
            if (file_exists($rutaImagen)) { unlink($rutaImagen); }
        }
        $deleteSql = "DELETE FROM tbl_casos_dinero WHERE Caso_Id = ?";
        $deleteStmt = $conexion->prepare($deleteSql);
        $deleteStmt->bind_param("i", $casoId);
        if (!$deleteStmt->execute()) { throw new Exception('Error al eliminar el caso: ' . $deleteStmt->error); }
        $deleteStmt->close();
        return ['success' => true, 'message' => 'Caso eliminado exitosamente'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// --- Tu función subirImagen() funcional (SIN CAMBIOS) ---
function subirImagen($archivo) {
    $uploadDir = '../../uploads/casos/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return ['success' => false, 'message' => 'No se pudo crear el directorio de imágenes'];
        }
    }
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($archivo['type'], $allowedTypes)) {
        return ['success' => false, 'message' => 'Tipo de archivo no permitido.'];
    }
    if ($archivo['size'] > 5 * 1024 * 1024) {
        return ['success' => false, 'message' => 'El archivo es demasiado grande (Máx 5MB).'];
    }
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $filename = 'caso_' . uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = $uploadDir . $filename;
    if (move_uploaded_file($archivo['tmp_name'], $uploadPath)) {
        return ['success' => true, 'filename' => $filename];
    } else {
        return ['success' => false, 'message' => 'Error al subir la imagen'];
    }
}
?>