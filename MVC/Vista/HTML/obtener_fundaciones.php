<?php
include '../../Modelo/ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conexion;

try {
    $sql = "SELECT * FROM tbl_fundaciones";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $fundaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($fundaciones);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
