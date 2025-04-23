<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';

$conn = (new ConexionBD())->conexion;

try {
    $sql = "
      SELECT
        Hora_Id,
        Hora_Citacion,
        Hora_Localizacion,
        Hora_Vol_Cedula
      FROM tbl_horarios_voluntarios
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
