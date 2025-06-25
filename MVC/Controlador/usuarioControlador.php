<?php
// /Pantry_Amigo/MVC/Controlador/usuarioControlador.php (Versión Final con Lógica Reparada y Recuperación)

session_start();
// Se incluyen los modelos al principio.
include_once '../Modelo/ConexionBD.php';
include_once '../Modelo/usuario.php';

// Se establece la conexión una sola vez.
$conn_obj = new ConexionBD();
$conexion = $conn_obj->abrir();
if (!$conexion) {
    die("Error crítico al conectar a la base de datos. Revise ConexionBD.php");
}

$usuario = new Usuario($conexion);

// --- LÓGICA DE RECUPERACIÓN DE CONTRASEÑA ---
if (isset($_POST['reset_password'])) {
    // Verificar que los campos no estén vacíos
    if (!empty($_POST['correo']) && !empty($_POST['new_password'])) {
        $correo = $_POST['correo'];
        $new_password = $_POST['new_password'];

        // Buscar usuario por correo
        $query = "SELECT * FROM Tbl_Usuario WHERE Usu_Correo = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            // Actualizar contraseña sin encriptar (como tú lo necesitas)
            $update_query = "UPDATE Tbl_Usuario SET Usu_Password = ? WHERE Usu_Id = ?";
            $update_stmt = $conexion->prepare($update_query);
            $update_stmt->bind_param("si", $new_password, $row['Usu_Id']);

            if ($update_stmt->execute()) {
                // Contraseña actualizada → Mostrar alerta y redirigir
                echo "<script>
                    alert('✅ Contraseña cambiada con éxito');
                    window.location.href = '../Vista/HTML/index.php';
                </script>";
                exit();
            } else {
                echo "<script>
                    alert('❌ Error al actualizar la contraseña');
                    window.location.href = '../Vista/HTML/recuperar.php';
                </script>";
                exit();
            }
        } else {
            echo "<script>
                alert('❌ Correo no registrado');
                window.location.href = '../Vista/HTML/recuperar.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('⚠️ Por favor completa todos los campos');
            window.location.href = '../Vista/HTML/recuperar.php';
        </script>";
        exit();
    }
}
// --- LÓGICA DE INICIO DE SESIÓN ---
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $usuario->login($username, $password);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        $_SESSION['Usu_Id'] = $row['Usu_Id'];
        $_SESSION['username'] = $row['Usu_Username'];
        $_SESSION['tipo'] = $row['Usu_Tipo'];

        if ($row['Usu_Tipo'] == 'Administrador') {
            header("Location: ../Vista/HTML/Administrador_Dashboard.php");
            exit();
        } elseif ($row['Usu_Tipo'] == 'Usuario') {
            $fund_data = $usuario->obtenerDatosFundacion($row['Usu_Id']);
            if ($fund_data) {
                if ($fund_data['Fund_Estado_Verificacion'] == 'verificado') {
                    $_SESSION['Fund_Id'] = $fund_data['Fund_Id'];
                    header("Location: ../Vista/HTML/Fundacion_Dashboard.php");
                    exit();
                } else {
                    $estado = htmlspecialchars($fund_data['Fund_Estado_Verificacion']);
                    echo "<script>alert('Tu cuenta está actualmente en estado: $estado. No puedes acceder hasta que un administrador la apruebe.'); window.location.href = '../Vista/HTML/index.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Error: No se encontraron los datos de la fundación asociados a este usuario.'); window.location.href = '../Vista/HTML/index.php';</script>";
                exit();
            }
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href = '../Vista/HTML/index.php';</script>";
        exit();
    }
}

// --- LÓGICA DE REGISTRO ---
if (isset($_POST['register'])) {
    // Se establece el header para la respuesta AJAX
    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => 'Error desconocido durante el registro.'];

    $datosUsuario = [
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'tipo' => $_POST['tipo'],
        'correo' => $_POST['correo']
    ];

    if ($datosUsuario['tipo'] === 'Usuario') {
        $datosUsuario['nit'] = $_POST['Fund_NIT'];
        $rutaDocumento = '';

        if (isset($_FILES['Fund_Documento']) && $_FILES['Fund_Documento']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../uploads/documentos/';
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
            $nombreArchivo = 'cert_' . uniqid() . '_' . basename($_FILES['Fund_Documento']['name']);
            $rutaCompleta = $uploadDir . $nombreArchivo;

            if (move_uploaded_file($_FILES['Fund_Documento']['tmp_name'], $rutaCompleta)) {
                $rutaDocumento = $nombreArchivo;
            } else {
                $response['message'] = 'Error al subir el documento.';
                echo json_encode($response);
                exit;
            }
        }
        $datosUsuario['documento'] = $rutaDocumento;
    }

    if ($usuario->register($datosUsuario)) {
        $response = ['success' => true, 'message' => '¡Solicitud de registro enviada con éxito!'];
    } else {
        $response['message'] = 'Este usuario o correo ya está registrado.';
    }
    echo json_encode($response);
    exit();
}

$conn_obj->cerrar();
?>