<?php
require_once '../../../vendor/autoload.php';
require_once '../../Modelo/ConexionBD.php';
require_once '../../Modelo/DonacionModelo.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952');

$payment_id = $_GET['payment_id'] ?? null;

if (!$payment_id) {
    die("❌ No se recibió el ID del pago.");
}

$client = new PaymentClient();
$payment = $client->get($payment_id);

// ✅ Validar estado del pago
if ($payment->status !== 'approved') {
    die("❌ El pago no fue aprobado. Estado: " . $payment->status);
}

// ✅ Descomponer los datos de external_reference
list($casoId, $nombre, $apellido, $cedula, $correo, $monto, $categoria) = explode('|', $payment->external_reference);

// ✅ Conexión a la base de datos
$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar con la base de datos.");
}

$conexion = $conn->getConexion();

// ✅ Calcular la comisión
$comision = $payment->transaction_details->total_paid_amount - $payment->transaction_details->net_received_amount;
$fecha = date('Y-m-d H:i:s');

// ✅ Crear instancia del modelo
$modelo = new DonacionModelo($conexion);

// ✅ Registrar la donación
$modelo->registrarDonacion([
    'monto' => $monto,
    'comision' => $comision,
    'cedula' => $cedula,
    'nombre' => $nombre,
    'apellido' => $apellido,
    'correo' => $correo,
    'fecha' => $fecha,
    'casoId' => $casoId,
    'categoria' => $categoria
]);

// ✅ Actualizar el monto recaudado del caso
$modelo->actualizarMontoRecaudado($casoId);

$montos = $modelo->obtenerMontos($casoId);
if ($montos['Caso_Monto_Recaudado'] >= $montos['Caso_Monto_Meta']) {
    $modelo->desactivarCaso($casoId);
}

$conn->cerrar();

// Mostrar mensaje de éxito y redirigir
echo "
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Gracias por tu donación!',
      text: 'Tu aporte ha sido registrado exitosamente.',
      timer: 3500,
      showConfirmButton: false
    });

    setTimeout(function() {
      window.location.href = '/Pantry_Amigo/MVC/Vista/HTML/index.php'; // Ajusta si tu home está en otro lugar
    }, 3500);
  </script>
</body>
</html>";
exit;





