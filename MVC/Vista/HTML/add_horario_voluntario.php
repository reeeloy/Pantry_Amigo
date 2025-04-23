<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Inválido']);
    exit;
}
$conn = (new ConexionBD())->conexion;
$d = $_POST;
try {
    $stmt = $conn->prepare("
      INSERT INTO tbl_horarios_voluntarios
        (Hora_Citacion, Hora_Localizacion, Hora_Vol_Cedula)
      VALUES (?, ?, ?)
    ");
    $stmt->execute([
      $d['Hora_Citacion'],
      $d['Hora_Localizacion'],
      $d['Hora_Vol_Cedula']
    ]);
    echo json_encode(['success' => true, 'message' => 'Horario asignado']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
