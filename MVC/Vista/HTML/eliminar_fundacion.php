<?php
include '../../Modelo/ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conexion;

if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM tbl_fundaciones WHERE ID = ?");
        $stmt->execute([$_GET['id']]);

        echo json_encode(['success' => true, 'message' => 'Fundación eliminada correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
