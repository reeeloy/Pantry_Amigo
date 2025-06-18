<?php
require_once '../../../vendor/autoload.php';
require_once '../../Modelo/ConexionBD.php';
require_once '../../Modelo/DonacionModelo.php'; // <- este modelo lo usas para guardar

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952');

$payment_id = $_GET['payment_id'] ?? null;

if (!$payment_id) {
    die("❌ No se recibió el ID del pago.");
}

$client = new PaymentClient();
$payment = $client->get($payment_id);

if ($payment->status !== 'approved') {
    die("❌ El pago no fue aprobado.");
}

// Descompón el external_reference
list($casoId, $nombre, $apellido, $cedula, $correo, $monto) = explode('|', $payment->external_reference);

// Aquí guardas en la base de datos
$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar con la base de datos.");
}

$sql = "INSERT INTO Tbl_Donacion_Dinero (Don_Monto, Don_Comision, Don_Cedula_Donante, Don_Nombre_Donante, Don_Apellido_Donante, Don_Correo, Don_Fecha, Don_Caso_Id, Don_Cat_Nombre)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";

// Calcular comisión si aplica
$comision = $payment->transaction_details->total_paid_amount - $payment->transaction_details->net_received_amount;

$categoria = ''; // Si no estás mandando la categoría, ponla manual o consulta por ID

$conn->consulta($sql, [
    $monto,
    $comision,
    $cedula,
    $nombre,
    $apellido,
    $correo,
    $casoId,
    $categoria
]);

$conn->cerrar();

echo "✅ Donación registrada correctamente. ¡Gracias por tu apoyo!";
?>

