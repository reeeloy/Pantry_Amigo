<?php
// /Pantry_Amigo/MVC/Controlador/prueba_correo.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'enviar_correo.php';

echo "<h1>Iniciando Prueba de Envío de Correo...</h1>";

// --- CONFIGURA ESTOS DATOS PARA LA PRUEBA ---
$destinatario_prueba = "jequinsil1200@gmail.com"; // <-- USA TU PROPIO CORREO PARA LA PRUEBA
$nombre_prueba = "Prueba Pantry Amigo";
$asunto_prueba = "Correo de Verificación de Sistema";
$cuerpo_prueba = "Este es un correo de prueba para verificar la configuración de PHPMailer. Si lo recibes, ¡todo funciona!";
// ---------------------------------------------

echo "<p>Intentando enviar correo a: <b>" . $destinatario_prueba . "</b></p>";
echo "<hr>";
echo "<h3>Bitácora de Conexión con Gmail:</h3>";
echo "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc; border-radius: 5px; white-space: pre-wrap; word-wrap: break-word;'>";

// Llamamos a la función de envío
$resultado = enviarCorreo($destinatario_prueba, $nombre_prueba, $asunto_prueba, $cuerpo_prueba);

echo "</pre>";
echo "<hr>";

echo "<h3>Resultado Final:</h3>";
echo "<p><b>" . htmlspecialchars($resultado) . "</b></p>";
?>