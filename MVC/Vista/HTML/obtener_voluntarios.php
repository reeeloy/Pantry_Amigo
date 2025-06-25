<?php
// obtener_voluntarios.php (Versión Final Filtrada)

header('Content-Type: application/json; charset=utf-8');
session_start(); // Iniciamos la sesión para acceder a las variables

// 1. Verificación de Seguridad: Si no hay un ID de fundación en la sesión, no se devuelve nada.
if (!isset($_SESSION['Fund_Id'])) {
    echo json_encode([]);
    exit();
}

include_once '../../Modelo/ConexionBD.php';

try {
    $conn = (new ConexionBD())->conexion;
    $fundacion_id = $_SESSION['Fund_Id']; // Obtenemos el ID de la fundación logueada

    // 2. CAMBIO: La consulta SQL ahora une voluntarios y casos, y filtra por el ID de la fundación
    // Usamos DISTINCT para no repetir voluntarios si están en varios casos de la misma fundación
    $sql = "
      SELECT DISTINCT
        v.Vol_Nombre,
        v.Vol_Cedula,
        v.Vol_Apellido,
        v.Vol_Correo,
        v.Vol_Celular,
        v.Vol_Caso_Id,
        v.Vol_Caso_Tipo
      FROM 
        tbl_voluntarios v
      JOIN 
        tbl_casos_dinero c ON v.Vol_Caso_Id = c.Caso_Id
      WHERE 
        c.Caso_Fund_Id = ?
    ";
    
    $stmt = $conn->prepare($sql);
    
    // 3. Pasamos el ID de la fundación de forma segura como parámetro
    $stmt->execute([$fundacion_id]);
    
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>