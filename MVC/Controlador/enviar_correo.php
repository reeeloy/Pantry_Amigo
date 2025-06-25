<?php
// /Pantry_Amigo/MVC/Controlador/enviar_correo.php (VERSIÓN DE DEPURACIÓN)

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

function enviarCorreo($destinatario, $nombreDestinatario, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);

    try {
        // --- CAMBIO CLAVE: Se activa el modo de depuración detallado ---
        // Esto nos mostrará toda la conversación con el servidor de Gmail
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // -----------------------------------------------------------

        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jequinsil1200@gmail.com'; // <-- REVISA QUE ESTE CORREO SEA CORRECTO
        $mail->Password   = 'lpkfxafuvwpemcgk'; // <-- REVISA QUE ESTA CONTRASEÑA DE APP SEA EXACTA Y SIN ESPACIOS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';

        // Remitente y Destinatario
        $mail->setFrom('jequinsil1200@gmail.com', 'Pantry Amigo');
        $mail->addAddress($destinatario, $nombreDestinatario);

        // Contenido del Correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->AltBody = strip_tags($cuerpo);

        if($mail->send()) {
            return true;
        } else {
            // Si send() falla pero no lanza excepción, devolvemos el error
            return $mail->ErrorInfo;
        }

    } catch (Exception $e) {
        // Si hay un error, lo registramos y devolvemos el mensaje de error para verlo en pantalla.
        $errorInfo = $mail->ErrorInfo;
        error_log("El mensaje no pudo ser enviado. Mailer Error: {$errorInfo}");
        return $errorInfo; // Devolvemos el error específico
    }
}
?>