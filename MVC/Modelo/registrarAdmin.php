<?php
include_once '../Modelo/ConexionBD.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$username = $_POST['username'] ?? '';
$correo = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($correo) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    exit;
}

$conn = new ConexionBD();
$db = $conn->abrir();

// Validar que no exista un admin con ese correo
$check = $db->prepare("SELECT * FROM tbl_usuario WHERE Usu_Correo = ?");
$check->bind_param("s", $correo);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Este correo ya está registrado']);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $db->prepare("INSERT INTO tbl_usuario (Usu_Username, Usu_Correo, Usu_Password, Usu_Tipo) VALUES (?, ?, ?, 'Administrador')");
$stmt->bind_param("sss", $username, $correo, $passwordHash);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Administrador creado exitosamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al crear el administrador']);
}

$stmt->close();
$conn->cerrar();
?>
