<?php
require_once '../../Modelo/ConexionBD.php';

$status    = $_GET['status'] ?? '';
$nombre    = $_GET['nombre'] ?? '';
$apellido  = $_GET['apellido'] ?? '';
$cedula    = $_GET['cedula'] ?? '';
$correo    = $_GET['correo'] ?? '';
$monto     = $_GET['monto'] ?? 0;
$casoId    = $_GET['caso'] ?? 0;
$categoria = $_GET['cat'] ?? '';

if ($status !== 'approved') {
    die("❌ Pago no aprobado.");
}

$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar a la BD.");
}

// Calcula comisión
$comision = $monto * 0.054;

$sql = "INSERT INTO Tbl_Donacion_Dinero 
  (Don_Monto, Don_Comision, Don_Cedula_Donante, Don_Nombre_Donante, 
   Don_Apellido_Donante, Don_Correo, Don_Fecha, Don_Caso_Id, Don_Cat_Nombre)
  VALUES (?, ?, ?, ?, ?, ?, CURDATE(), ?, ?)";
$params = [$monto, $comision, $cedula, $nombre, $apellido, $correo, $casoId, $categoria];

$conn->consulta($sql, $params);
$conn->cerrar();

echo "<h2>✅ ¡Gracias, $nombre! Tu donación de $$monto COP se registró correctamente.</h2>";
?>


