<?php
require_once '../Modelo/conexionBDD.php';
require_once '../Modelo/donacionModelo.php';

$conexion = new ConexionBD();
$conn = $conexion->getConexion();

$modelo = new DonacionModelo($conn);

$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : null;
$donaciones = $modelo->obtenerDonaciones($cedula);

include '../Vista/HTML/ConsultarParticipacion.php';
