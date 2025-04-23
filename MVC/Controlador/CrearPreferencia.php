<?php
require_once '../Modelo/ConexionBD.php';

// Reemplaza con tu token de acceso SANDBOX de Mercado Pago
$access_token = "TEST-5944914137482918-040922-40e4f95522d411cb65ef16baab3cc680-2378312331";

// Recibiendo los datos desde el formulario
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$correo = $_POST['correo'] ?? '';
$cedula = $_POST['cedula'] ?? '';
$monto = $_POST['monto'] ?? 0;
$caso_id = $_POST['casoId'] ?? null;
$categoria = $_POST['categoria'] ?? '';

// 👉 PRIMERO: Guardar la donación en la base de datos
$conn = new ConexionBD();
if ($conn->abrir()) {
    $sql = "INSERT INTO Tbl_Donacion_Dinero (Don_Caso_Id, Don_Nombre_Donante, Don_Apellido_Donante, Don_Cedula_Donante, Don_Correo, Don_Monto) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $conn->consulta($sql, [$caso_id, $nombre, $apellido, $cedula, $correo, $monto]);
    $conn->cerrar();
} else {
    die("❌ Error al conectar a la base de datos.");
}

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
        "success" => "http://localhost/Pantry_Amigo/MVC/Vista/HTML/Index.php?caso_id=$caso_id&monto=$monto&nombre=" . urlencode($nombre) . "&correo=" . urlencode($correo),
        "failure" => "http://localhost/Pantry_Amigo/ErrorPago.php"
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

// Redirigir al sandbox
if (isset($response['sandbox_init_point'])) {
    header("Location: " . $response['sandbox_init_point']);
    exit;
} else {
    echo "❌ Error al generar la preferencia de pago.";
    print_r($response);
}
?>
