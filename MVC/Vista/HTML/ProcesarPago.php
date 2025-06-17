<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Exceptions\MPHttpException;
use MercadoPago\Exceptions\MPException;

header('Content-Type: application/json');

MercadoPagoConfig::setAccessToken("TEST-3187040352619275-061515-1fd1626e01ea46208e6ba816bdc10d76-2378312331");

$input = json_decode(file_get_contents('php://input'), true);

$token = $input['token'] ?? null;
$payment_method_id = $input['payment_method_id'] ?? null;
$issuer_id = $input['issuer_id'] ?? null;
$installments = $input['installments'] ?? 1;
$nombre = $input['nombre'] ?? '';
$apellido = $input['apellido'] ?? '';
$cedula = $input['cedula'] ?? '';
$correo = $input['correo'] ?? '';
$monto = $input['monto'] ?? 0;
$casoId = $input['casoId'] ?? 0;
$categoria = $input['categoria'] ?? '';

if (!$token || !$payment_method_id || !$correo || $monto < 3000) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

try {
    $client = new PaymentClient();
    $payment = $client->create([
        "transaction_amount" => (float) $monto,
        "token" => $token,
        "description" => "Donación para caso #$casoId",
        "installments" => (int) $installments,
        "payment_method_id" => $payment_method_id,
        "issuer_id" => $issuer_id,
        "payer" => [
            "email" => $correo
        ]
    ]);

    if ($payment->status === 'approved') {
        require_once '../../Modelo/ConexionBD.php';
        require_once '../../Modelo/donacionModelo.php';

        $conn = new ConexionBD();
        if ($conn->abrir()) {
            $modelo = new DonacionModelo($conn);
            $modelo->registrarDonacion([
                'monto' => $monto,
                'categoria' => $categoria,
                'cedula' => $cedula,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'casoId' => $casoId
            ]);
            $conn->cerrar();
        }

        echo json_encode(['status' => 'approved']);
    } else {
        echo json_encode([
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'full_response' => $payment
        ]);
    }

}} catch (MPApiException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de API de Mercado Pago',
        'details' => $e->getMessage()
    ]);
} catch (MPHttpException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error HTTP al conectar con Mercado Pago',
        'details' => $e->getMessage()
    ]);
} catch (MPException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error general de Mercado Pago',
        'details' => $e->getMessage()
    ]);
}

