<?php
require_once '../../Modelo/Caso.php';

$modelo = new Caso();
header('Content-Type: application/json');
echo json_encode($modelo->obtenerCasosActivosRecursos());
?>


