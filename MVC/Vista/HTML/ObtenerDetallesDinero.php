<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once '../../Modelo/ConexionBD.php';

if (!isset($_GET['ID'])) {
    echo json_encode(['error' => 'ID no especificado']);
    exit;
}

$casoId = $_GET['ID'];

$db = new ConexionBD();

if (!$db->abrir()) {
    echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
    exit;
}

$conn = $db->getConexion(); // ✅ Obtener el objeto mysqli real

$sql = "SELECT 
            c.Caso_Id,
            c.Caso_Nombre,
            c.Caso_Descripcion,
            c.Caso_Monto_Meta,
            c.Caso_Monto_Recaudado,
            c.Caso_Fecha_Inicio,
            c.Caso_Fecha_Fin,
            c.Caso_Imagen,
            c.Caso_Voluntariado,
            c.Caso_Cat_Nombre,
            f.Fund_Username AS Fundacion_Nombre,
            f.Fund_Correo AS Fundacion_Correo,
            f.Fund_Telefono AS Fundacion_Telefono,
            f.Fund_Direccion AS Fundacion_Direccion
        FROM Tbl_Casos_Dinero c
        JOIN Tbl_Fundaciones f ON c.Caso_Fund_Id = f.Fund_Id
        WHERE c.Caso_Id = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $casoId);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Error al ejecutar la consulta']);
    $stmt->close();
    $db->cerrar();
    exit;
}

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo json_encode(['error' => 'Caso no encontrado']);
} else {
    $caso = $resultado->fetch_assoc();

    // Calcular el porcentaje recaudado
    $meta = floatval($caso['Caso_Monto_Meta']);
    $recaudado = floatval($caso['Caso_Monto_Recaudado']);
    $caso['porcentaje'] = ($meta > 0) ? round(($recaudado / $meta) * 100, 2) : 0;

    echo json_encode($caso, JSON_UNESCAPED_UNICODE);
}

$stmt->close();
$db->cerrar();


