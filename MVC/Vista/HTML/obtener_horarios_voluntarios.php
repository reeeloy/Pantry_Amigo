<?php
// obtener_horarios_voluntarios.php (Versión Final Filtrada)

header('Content-Type: application/json; charset=utf-8');
session_start(); // Iniciamos la sesión para poder acceder a las variables

// 1. Verificación de Seguridad: Si no hay un ID de fundación en la sesión, no se devuelve nada.
if (!isset($_SESSION['Fund_Id'])) {
    echo json_encode([]);
    exit();
}

include_once '../../Modelo/ConexionBD.php';

try {
    $conn = (new ConexionBD())->conexion;
    $fundacion_id = $_SESSION['Fund_Id']; // Obtenemos el ID de la fundación logueada

    // 2. CAMBIO: La consulta SQL ahora une horarios y casos para filtrar por el ID de la fundación
    $sql = "
      SELECT
        h.Hora_Id,
        h.Hora_Citacion,
        h.Hora_Localizacion,
        h.Hora_Vol_Cedula
      FROM 
        tbl_horarios_voluntarios h
      JOIN 
        tbl_casos_dinero c ON h.Hora_Caso_Id = c.Caso_Id
      WHERE 
        c.Caso_Fund_Id = ?
      ORDER BY 
        h.Hora_Id DESC
    ";
    
    $stmt = $conn->prepare($sql);
    
    // 3. Pasamos el ID de la fundación de forma segura como parámetro
    $stmt->execute([$fundacion_id]);
    
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>