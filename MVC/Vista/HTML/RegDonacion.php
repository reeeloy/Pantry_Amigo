<?php
require_once '../../Modelo/ConexionBD.php';

// Verifica que el estado del pago sea 'approved'
$estado = $_GET['collection_status'] ?? '';
if ($estado !== 'approved') {
    die("❌ El pago no fue aprobado.");
}

// Obtener datos del donante y de la donación
$nombre    = $_GET['nombre'] ?? '';
$apellido  = $_GET['apellido'] ?? '';
$cedula    = $_GET['cedula'] ?? '';
$correo    = $_GET['correo'] ?? '';
$monto     = floatval($_GET['monto'] ?? 0);
$casoId    = $_GET['id'] ?? 0;
$categoria = $_GET['cat'] ?? '';

// Validación mínima
if (!$nombre || !$apellido || !$cedula || !$correo || $monto < 3000 || !$casoId || !$categoria) {
    die("❌ Datos incompletos o inválidos.");
}

// Calcular comisión
$comision = $monto * 0.054;

// Conectar a BD
$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar a la base de datos.");
}

// Insertar en la base de datos
$sql = "INSERT INTO Tbl_Donacion_Dinero 
  (Don_Monto, Don_Comision, Don_Cedula_Donante, Don_Nombre_Donante, 
   Don_Apellido_Donante, Don_Correo, Don_Fecha, Don_Caso_Id, Don_Cat_Nombre)
  VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";

$params = [$monto, $comision, $cedula, $nombre, $apellido, $correo, $casoId, $categoria];
$exito = $conn->consulta($sql, $params);
$conn->cerrar();

if ($exito) {
    echo "<h2>✅ ¡Gracias, $nombre! Tu donación de $$monto COP se registró correctamente.</h2>";
} else {
    echo "<h2>❌ Hubo un error al registrar tu donación. Intenta nuevamente.</h2>";
}
?>
