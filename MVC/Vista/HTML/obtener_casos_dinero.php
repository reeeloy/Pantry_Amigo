<?php
header('Content-Type: application/json; charset=utf-8');
session_start(); // Iniciamos la sesión para poder acceder a $_SESSION

// 1. Verificación de Seguridad: Si no hay un ID de fundación en la sesión, no devolvemos nada.
if (!isset($_SESSION['Fund_Id'])) {
    echo json_encode([]); // Devolvemos un array vacío
    exit();
}

include_once '../../Modelo/ConexionBD.php';

try {
    $conn = (new ConexionBD())->conexion; // Mantenemos tu método de conexión PDO
    $fundacion_id = $_SESSION['Fund_Id']; // Obtenemos el ID de la fundación que ha iniciado sesión

    // 2. CAMBIO: Se añade la cláusula WHERE para filtrar por el ID de la fundación
    $sql = "
      SELECT 
        Caso_Id,
        Caso_Nombre,
        Caso_Descripcion,
        Caso_Monto_Meta,
        Caso_Monto_Recaudado,
        Caso_Fecha_Inicio,
        Caso_Fecha_Fin,
        Caso_Estado,
        Caso_Imagen,
        Caso_Voluntariado,
        Caso_Fund_Id,
        Caso_Cat_Nombre
      FROM tbl_casos_dinero
      WHERE Caso_Fund_Id = ?  -- Filtramos aquí
    ";
    
    $stmt = $conn->prepare($sql);
    
    // 3. Pasamos el ID de la fundación como parámetro a la consulta
    $stmt->execute([$fundacion_id]);
    
    // Devolvemos solo los casos que coinciden
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    // En caso de error, devolvemos un mensaje
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>