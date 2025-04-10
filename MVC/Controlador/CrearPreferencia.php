<?php
// Reemplaza con tu token de acceso SANDBOX
$access_token = "TEST-5944914137482918-040922-40e4f95522d411cb65ef16baab3cc680-2378312331";

// Datos del form
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$monto = $_POST['monto'];
$caso_id = $_POST['casoId'];

// Crear preferencia
$preference_data = [
  "items" => [[
    "title" => "Donación caso #$caso_id",
    "quantity" => 1,
    "currency_id" => "COP",
    "unit_price" => (float)$monto
  ]],
  "payer" => [
    "name" => $nombre,
    "email" => $correo
  ],
  "back_urls" => [
  "success" => "http://localhost/Pantry_Amigo/MVC/Controlador/registro_donacion.php?caso_id=$caso_id&monto=$monto&nombre=" . urlencode($nombre) . "&correo=" . urlencode($correo),
  "failure" => "http://localhost/Pantry_Amigo/error_pago.php"
],
"auto_return" => "approved"

];

// Configurar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Authorization: Bearer $access_token",
  "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($preference_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decodificar respuesta
$response = json_decode($response, true);

// Redirigir a Mercado Pago
header("Location: " . $response['init_point']);
exit;
