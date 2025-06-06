<?php
require_once '../../../Modelo/ConexionBD.php';

// Recibir parámetros que Mercado Pago envía en la URL (por ejemplo: status, payment_id, etc)
$status = $_GET['status'] ?? '';
$payment_id = $_GET['payment_id'] ?? '';
$external_reference = $_GET['external_reference'] ?? ''; // si usas referencia externa

if ($status !== 'approved') {
    die("El pago no fue aprobado.");
}

// Conectar a la base de datos
$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("Error al conectar a la base de datos.");
}

// Actualizar el estado de la donación a 'approved'
// Para esto debes tener algún identificador para relacionar, podría ser el payment_id, cédula, o el id insertado antes.
// Aquí un ejemplo suponiendo que uses cédula y monto para actualizar el pago:

$sql = "UPDATE Tbl_Donacion_Dinero SET Don_Estado = 'approved' WHERE Don_Cedula_Donante = ? AND Don_Monto = ? AND Don_Estado = 'pendiente'";

$conn->consulta($sql, [$_GET['cedula'] ?? '', $_GET['monto'] ?? 0]);
$conn->cerrar();

echo "¡Gracias! El pago fue aprobado y registrado.";
?>
