<?php
// /Pantry_Amigo/MVC/Controlador/enviar_correo.php (Versión Final con Autoloader de Composer)

// Se usan estas líneas para importar las clases al scope actual
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// CAMBIO CLAVE: Se incluye UN SOLO archivo, el autoloader de Composer.
// Este se encarga de encontrar y cargar todas las librerías necesarias (PHPMailer, Google, MercadoPago, etc.)
require_once __DIR__ . '/../../vendor/autoload.php';

// Se incluye tu archivo de configuración para las llaves secretas
require_once __DIR__ . '/../../config.php';

function enviarCorreo($destinatario, $nombreDestinatario, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);
    try {
        // La configuración del servidor no cambia
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jequinsil1200@gmail.com'; 
        
        // Se usa la constante segura desde config.php para la contraseña de aplicación
        // ¡ASEGÚRATE DE QUE LA CONSTANTE EN config.php se llame 'APP_PASSWORD' o ajústala aquí!
        $mail->Password   = defined('APP_PASSWORD') ? APP_PASSWORD : ''; 
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('jequinsil1200@gmail.com', 'Pantry Amigo');
        $mail->addAddress($destinatario, $nombreDestinatario);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->AltBody = strip_tags($cuerpo);

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Error de PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}
?>