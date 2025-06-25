<?php
// /Pantry_Amigo/MVC/Vista/HTML/actualizar_estado_fundacion.php (Versión Final)

header('Content-Type: application/json');
include_once '../../Modelo/ConexionBD.php';
include_once '../../Modelo/usuario.php'; 
include_once '../../Controlador/enviar_correo.php'; 

session_start();

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Administrador') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit;
}

$response = ['success' => false, 'message' => 'Datos inválidos.'];

if (isset($_POST['id']) && isset($_POST['estado'])) {
    $conn_obj = new ConexionBD();
    $conexion = $conn_obj->abrir();

    if ($conexion) {
        $usuarioModelo = new Usuario($conexion);
        $id_fundacion = intval($_POST['id']);
        $nuevo_estado = $_POST['estado'];
        
        $fundacion = $usuarioModelo->obtenerDatosFundacionPorId($id_fundacion);
        
        if ($fundacion && $usuarioModelo->actualizarEstadoVerificacion($id_fundacion, $nuevo_estado)) {
            $asunto = '';
            $cuerpoHTML = '';

            if ($nuevo_estado == 'verificado') {
                $asunto = '¡Tu solicitud en Pantry Amigo ha sido APROBADA!';
                $cuerpoHTML = "<h1>¡Felicidades, " . htmlspecialchars($fundacion['Fund_Username']) . "!</h1><p>Tu cuenta ha sido verificada y aprobada por nuestros administradores. Ya puedes iniciar sesión y empezar a crear casos de donación.</p><p>¡Bienvenido a Pantry Amigo!</p>";
            } else { 
                $motivo = !empty($_POST['motivo']) ? $_POST['motivo'] : 'No se especificó un motivo.';
                $asunto = 'Actualización sobre tu solicitud en Pantry Amigo';
                $cuerpoHTML = "<h1>Actualización sobre tu solicitud</h1><p>Hola, " . htmlspecialchars($fundacion['Fund_Username']) . ".</p><p>Hemos revisado tu solicitud y lamentablemente ha sido rechazada por el siguiente motivo:</p><p><strong>" . htmlspecialchars($motivo) . "</strong></p><p>Si crees que esto es un error, por favor, contacta a soporte.</p>";
            }
            
            if (enviarCorreo($fundacion['Fund_Correo'], $fundacion['Fund_Username'], $asunto, $cuerpoHTML)) {
                $response = ['success' => true, 'message' => "Fundación marcada como '{$nuevo_estado}' y correo de notificación enviado."];
            } else {
                $response = ['success' => true, 'message' => "ATENCIÓN: El estado de la fundación se actualizó, pero falló el envío del correo de notificación."];
            }
        } else {
            $response['message'] = "Error al actualizar la base de datos o encontrar la fundación.";
        }
    } else {
        $response['message'] = "Error de conexión a la base de datos.";
    }
}

echo json_encode($response);
?>