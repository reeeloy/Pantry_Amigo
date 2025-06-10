<?php
require_once '../../Modelo/ConexionBD.php';

// Reemplaza con tu token de acceso SANDBOX de Mercado Pago
$access_token = "APP_USR-73908507895478-060613-66306803047a2dd492db9e57194ebdf8-2378312331";

// Recibiendo los datos desde el formulario
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$correo = $_POST['correo'] ?? '';
$cedula = $_POST['cedula'] ?? '';
$monto = $_POST['monto'] ?? 0;
$caso_id = $_POST['casoId'] ?? null;
$categoria = $_POST['categoria'] ?? '';


// SEGUNDO: Crear la preferencia en Mercado Pago
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
        "success" => "Pantry_Amigo/Vista/HTML/index.php?caso_id=$caso_id&monto=$monto&nombre=" . urlencode($nombre) . "&correo=" . urlencode($correo),
        "failure" => "Pantry_Amigo/ErrorPago.php"
    ],
    "auto_return" => "approved"
];

// Hacer la solicitud cURL a la API de Mercado Pago
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

// Decodificar la respuesta
$response = json_decode($response, true);

// Redirigir al sandbox de Mercado Pago
if (isset($response['sandbox_init_point'])) {
    // Redirigir al usuario al sandbox de Mercado Pago para completar la donación
    header("Location: " . $response['sandbox_init_point']);
    exit;
} else {
    echo "❌ Error al generar la preferencia de pago.";
    print_r($response);
}
?>
