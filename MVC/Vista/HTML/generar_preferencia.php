<?php
require_once '../../../vendor/autoload.php';
require_once '../../Modelo/ConexionBD.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

header('Content-Type: application/json');

// Validar datos
$monto = isset($_POST['monto']) ? floatval($_POST['monto']) : 0;
$casoId = isset($_POST['casoId']) ? intval($_POST['casoId']) : 0;
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$cedula = trim($_POST['cedula'] ?? '');
$correo = trim($_POST['correo'] ?? '');

if ($monto <= 3000 || !$casoId || !$nombre || !$apellido || !$cedula || !$correo) {
  echo json_encode(['error' => 'Datos incompletos']);
  exit;
}

// Generar preferencia
MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952');
$client = new PreferenceClient();
$preference = $client->create([
    "items" => [
        [
            "id" => "donacion_" . $casoId,
            "title" => "Donación para caso #" . $casoId,
            "quantity" => 1,
            "unit_price" => $monto,
        ],
    ],
    "statement_descriptor" => "Donación Pantry",
    "external_reference" => "donacion_" . $casoId,
]);

// ✅ Puedes guardar los datos en la base de datos aquí si lo deseas
// pero lo ideal es guardarlos solo cuando el pago esté aprobado
// por eso este paso es opcional aquí

echo json_encode(['preference_id' => $preference->id]);
