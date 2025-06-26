<?php
// /Pantry_Amigo/MVC/Controlador/enviar_correo.php (Versión Segura)

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

// CAMBIO: Incluimos nuestro nuevo archivo de configuración
require_once __DIR__ . '/../../config.php';

function enviarCorreo($destinatario, $nombreDestinatario, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jequinsil1200@gmail.com';
        // CAMBIO: La contraseña ahora se lee desde la constante segura
        $mail->Password   = SENDGRID_API_KEY; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';
        $mail->setFrom('jequinsil1200@gmail.com', 'Pantry Amigo');
        $mail->addAddress($destinatario, $nombreDestinatario);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->AltBody = strip_tags($cuerpo);
        return $mail->send();
    } catch (Exception $e) {
        error_log("Error de PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}
?>