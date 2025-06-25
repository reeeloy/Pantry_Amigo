<?php
// Evitar cualquier output antes del JSON
ob_start();

// Configuración de errores para producción
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();

// Limpiar cualquier output previo
ob_clean();

// Configuración de headers para JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Validar sesión
    if (!isset($_SESSION['Usu_Id']) || !isset($_SESSION['Fund_Id'])) {
        throw new Exception('Usuario no autenticado o sin fundación asociada');
    }

    // Cargar conexión
    $modelosPath = '../../Modelo/ConexionBD.php';
    if (!file_exists($modelosPath)) {
        throw new Exception('Error: Archivo de conexión no encontrado');
    }
    
    include_once $modelosPath;

    // Establecer conexión
    $conn = new ConexionBD();
    $conexion = $conn->abrir();
    
    if (!$conexion) {
        throw new Exception('Error: No se pudo establecer conexión a la base de datos');
    }

    // Determinar la acción
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    
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
    
    // Cerrar conexión
    $conn->cerrar();
    
    // Enviar respuesta
    echo json_encode($resultado);

} catch (Exception $e) {
    // En caso de error, enviar respuesta JSON de error
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}

function crearCaso($conexion) {
    try {
        // Validar datos requeridos
        $requiredFields = ['Caso_Nombre', 'Caso_Descripcion', 'Caso_Monto_Meta', 'Caso_Fecha_Inicio', 'Caso_Fecha_Fin'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("El campo $field es requerido");
            }
        }
        
        // Validar fechas
        $fechaInicio = $_POST['Caso_Fecha_Inicio'];
        $fechaFin = $_POST['Caso_Fecha_Fin'];
        
        if (strtotime($fechaFin) <= strtotime($fechaInicio)) {
            throw new Exception('La fecha de fin debe ser posterior a la fecha de inicio');
        }
        
        // Preparar datos del caso
        $nombre = trim($_POST['Caso_Nombre']);
        $descripcion = trim($_POST['Caso_Descripcion']);
        $meta = floatval($_POST['Caso_Monto_Meta']);
        $recaudado = 0;
        $fecha_inicio = $fechaInicio;
        $fecha_fin = $fechaFin;
        $estado = 'Activo';
        $voluntariado = isset($_POST['Caso_Voluntariado']) ? 1 : 0;
        $fund_id = $_SESSION['Fund_Id'];
        
        // Validar monto meta
        if ($meta <= 0) {
            throw new Exception('El monto meta debe ser mayor a 0');
        }
        
        // Manejar subida de imagen
        $imagen = '';
        if (isset($_FILES['Caso_Imagen']) && $_FILES['Caso_Imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = subirImagen($_FILES['Caso_Imagen']);
            if (!$uploadResult['success']) {
                throw new Exception($uploadResult['message']);
            }
            $imagen = $uploadResult['filename'];
        }
        
        // Insertar en base de datos SIN la columna Caso_Cat_Id que no existe
        $sql = "INSERT INTO tbl_casos_dinero (Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, Caso_Voluntariado, Caso_Fund_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error preparando consulta: ' . $conexion->error);
        }
        
        $stmt->bind_param("ssdissisii", $nombre, $descripcion, $meta, $recaudado, $fecha_inicio, $fecha_fin, $estado, $imagen, $voluntariado, $fund_id);
        
        if (!$stmt->execute()) {
            throw new Exception('Error al crear el caso: ' . $stmt->error);
        }
        
        $caso_id = $conexion->insert_id;
        $stmt->close();
        
        return [
            'success' => true, 
            'message' => 'Caso creado exitosamente', 
            'id' => $caso_id
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false, 
            'message' => $e->getMessage()
        ];
    }
}

function actualizarCaso($conexion) {
    try {
        $casoId = intval($_POST['id']);
        if (empty($casoId)) {
            throw new Exception('ID del caso requerido');
        }
        
        // Verificar que el caso pertenece a la fundación
        $checkSql = "SELECT Caso_Id, Caso_Imagen FROM tbl_casos_dinero WHERE Caso_Id = ? AND Caso_Fund_Id = ?";
        $checkStmt = $conexion->prepare($checkSql);
        $checkStmt->bind_param("ii", $casoId, $_SESSION['Fund_Id']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('Caso no encontrado o sin permisos');
        }
        
        $casoExistente = $result->fetch_assoc();
        $checkStmt->close();
        
        // Preparar datos actualizados
        $nombre = trim($_POST['Caso_Nombre']);
        $descripcion = trim($_POST['Caso_Descripcion']);
        $meta = floatval($_POST['Caso_Monto_Meta']);
        $fecha_inicio = $_POST['Caso_Fecha_Inicio'];
        $fecha_fin = $_POST['Caso_Fecha_Fin'];
        $voluntariado = isset($_POST['Caso_Voluntariado']) ? 1 : 0;
        
        // Validar fechas
        if (strtotime($fecha_fin) <= strtotime($fecha_inicio)) {
            throw new Exception('La fecha de fin debe ser posterior a la fecha de inicio');
        }
        
        // Validar monto meta
        if ($meta <= 0) {
            throw new Exception('El monto meta debe ser mayor a 0');
        }
        
        // Manejar imagen si se subió una nueva
        $imagen_clause = "";
        $imagen_param = null;
        if (isset($_FILES['Caso_Imagen']) && $_FILES['Caso_Imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = subirImagen($_FILES['Caso_Imagen']);
            if (!$uploadResult['success']) {
                throw new Exception($uploadResult['message']);
            }
            
            // Eliminar imagen anterior si existe
            if (!empty($casoExistente['Caso_Imagen'])) {
                $rutaAnterior = '../../Vista/imagenes/' . $casoExistente['Caso_Imagen'];
                if (file_exists($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
            }
            $imagen_clause = ", Caso_Imagen = ?";
            $imagen_param = $uploadResult['filename'];
        }
        
        // Actualizar el caso SIN la columna Caso_Cat_Id
        $sql = "UPDATE tbl_casos_dinero SET Caso_Nombre = ?, Caso_Descripcion = ?, Caso_Monto_Meta = ?, Caso_Fecha_Inicio = ?, Caso_Fecha_Fin = ?, Caso_Voluntariado = ?" . $imagen_clause . " WHERE Caso_Id = ?";
        
        $stmt = $conexion->prepare($sql);
        
        if ($imagen_param) {
            $stmt->bind_param("ssdsssii", $nombre, $descripcion, $meta, $fecha_inicio, $fecha_fin, $voluntariado, $imagen_param, $casoId);
        } else {
            $stmt->bind_param("ssdssi", $nombre, $descripcion, $meta, $fecha_inicio, $fecha_fin, $voluntariado, $casoId);
        }
        
        if (!$stmt->execute()) {
            throw new Exception('Error al actualizar el caso: ' . $stmt->error);
        }
        
        $stmt->close();
        
        return [
            'success' => true, 
            'message' => 'Caso actualizado exitosamente'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false, 
            'message' => $e->getMessage()
        ];
    }
}

function eliminarCaso($conexion) {
    try {
        $casoId = intval($_GET['id']);
        if (empty($casoId)) {
            throw new Exception('ID del caso requerido');
        }
        
        // Verificar que el caso pertenece a la fundación
        $checkSql = "SELECT Caso_Imagen FROM tbl_casos_dinero WHERE Caso_Id = ? AND Caso_Fund_Id = ?";
        $checkStmt = $conexion->prepare($checkSql);
        $checkStmt->bind_param("ii", $casoId, $_SESSION['Fund_Id']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('Caso no encontrado o sin permisos');
        }
        
        $caso = $result->fetch_assoc();
        $checkStmt->close();
        
        // Eliminar imagen si existe
        if (!empty($caso['Caso_Imagen'])) {
            $rutaImagen = '../../Vista/imagenes/' . $caso['Caso_Imagen'];
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        
        // Eliminar el caso
        $deleteSql = "DELETE FROM tbl_casos_dinero WHERE Caso_Id = ?";
        $deleteStmt = $conexion->prepare($deleteSql);
        $deleteStmt->bind_param("i", $casoId);
        
        if (!$deleteStmt->execute()) {
            throw new Exception('Error al eliminar el caso: ' . $deleteStmt->error);
        }
        
        $deleteStmt->close();
        
        return [
            'success' => true, 
            'message' => 'Caso eliminado exitosamente'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false, 
            'message' => $e->getMessage()
        ];
    }
}

function subirImagen($archivo) {
    $uploadDir = '../../Vista/imagenes/';
    
    // Crear directorio si no existe
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return ['success' => false, 'message' => 'No se pudo crear el directorio de imágenes'];
        }
    }
    
    // Validar tipo de archivo
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = $archivo['type'];
    
    if (!in_array($fileType, $allowedTypes)) {
        return ['success' => false, 'message' => 'Tipo de archivo no permitido. Solo se permiten imágenes (JPG, PNG, GIF, WEBP).'];
    }
    
    // Validar tamaño (máximo 5MB)
    if ($archivo['size'] > 5 * 1024 * 1024) {
        return ['success' => false, 'message' => 'El archivo es demasiado grande. Máximo 5MB.'];
    }
    
    // Generar nombre único
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $filename = 'caso_' . uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = $uploadDir . $filename;
    
    // Mover archivo
    if (move_uploaded_file($archivo['tmp_name'], $uploadPath)) {
        return ['success' => true, 'filename' => $filename];
    } else {
        return ['success' => false, 'message' => 'Error al subir la imagen'];
    }
}
?>