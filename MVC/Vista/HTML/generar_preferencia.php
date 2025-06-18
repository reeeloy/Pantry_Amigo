<?php
require_once '../../Modelo/ConexionBD.php';
require_once '../../../vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

header('Content-Type: application/json');

$monto = isset($_POST['monto']) ? floatval($_POST['monto']) : 0;
$casoId = $_POST['casoId'] ?? null;

if ($monto < 3000 || !$casoId) {
  echo json_encode(['error' => 'Monto inválido o datos incompletos.']);
  exit;
}

MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952');
$client = new PreferenceClient();

try {
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

  echo json_encode(['preference_id' => $preference->id]);

} catch (Exception $e) {
  echo json_encode(['error' => 'Error al generar la preferencia: ' . $e->getMessage()]);
}

