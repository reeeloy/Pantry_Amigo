<?php
session_start();
include '../../Modelo/ConexionBD.php';
if ($_SERVER['REQUEST_METHOD']!=='POST' || !isset($_SESSION['id_fundacion'])) {
  echo json_encode(['success'=>false,'message'=>'Inválido']);
  exit;
}
$conn = (new ConexionBD())->conexion;
$data = $_POST;
try {
  $stmt = $conn->prepare("
    INSERT INTO tbl_casos_recursos
    (Caso_Nombre,Caso_Descripcion,Caso_Fecha_Inicio,Caso_Fecha_Fin,
     Caso_Estado,Caso_Punto_Recoleccion,Caso_Imagen,Caso_Voluntariado,
     Caso_Fund_Id,Caso_Cat_Nombre)
    VALUES (?,?,?,?,?,?,?,?,?,?)
  ");
  $stmt->execute([
    $data['Caso_Nombre'],$data['Caso_Descripcion'],
    $data['Caso_Fecha_Inicio'],$data['Caso_Fecha_Fin'],
    $data['Caso_Estado'],$data['Caso_Punto_Recoleccion'],
    $data['Caso_Imagen'] ?? '',$data['Caso_Voluntariado'] ?? 0,
    $_SESSION['id_fundacion'],$data['Caso_Cat_Nombre']
  ]);
  echo json_encode(['success'=>true,'message'=>'Caso de recurso creado']);
} catch(PDOException $e){
  echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
}
