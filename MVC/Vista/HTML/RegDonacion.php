<?php
require_once '../../Modelo/ConexionBD.php';

$caso_id = $_GET['caso_id'] ?? null;
$monto = $_GET['monto'] ?? null;
$nombre = $_GET['nombre'] ?? '';
$correo = $_GET['correo'] ?? '';

if (!$caso_id || !$monto || !$nombre || !$correo) {
    die("❌ Datos incompletos para registrar la donación.");
}

$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar con la base de datos.");
}

// Obtener la categoría del caso (Don_Cat_Nombre)
$sqlCategoria = "SELECT Caso_Categoria FROM Tbl_Casos_Dinero WHERE Caso_Id = ?";
$conn->consulta($sqlCategoria, [$caso_id]);
$resCategoria = $conn->obtenerResult();
$fila = $resCategoria->fetch_assoc();
$categoria = $fila['Caso_Categoria'] ?? 'Sin categoría';

// Dividir nombre en nombre y apellido
$partes = explode(" ", $nombre, 2);
$nombre_donante = $partes[0];
$apellido_donante = $partes[1] ?? '';

$comision = $monto * 0.039;
$fecha = date("Y-m-d H:i:s");

$sqlInsert = "INSERT INTO Tbl_Donacion_Dinero (
    Don_Monto, Don_Comision, Don_Nombre_Donante, Don_Apellido_Donante,
    Don_Correo, Don_Metodo_Pago, Don_Fecha, Don_Caso_Id, Don_Cat_Nombre
) VALUES (?, ?, ?, ?, ?, 'MercadoPago', ?, ?, ?)";

$exito = $conn->consulta($sqlInsert, [
    $monto, $comision, $nombre_donante, $apellido_donante, $correo, $fecha, $caso_id, $categoria
]);

$conn->cerrar();

if ($exito) {
    echo "<h3>✅ ¡Gracias por tu donación!</h3>";
} else {
    echo "<h3>❌ Error al registrar la donación.</h3>";
}
?>

