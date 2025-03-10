<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "voluntariado");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Registro de voluntarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $disponibilidad = $_POST['disponibilidad'];
    
    $sql = "INSERT INTO voluntarios (nombre, email, telefono, disponibilidad) VALUES ('$cedula',$nombre', '$email', '$telefono', '$disponibilidad')";
    if ($conexion->query($sql) === TRUE) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $conexion->error;
    }
}

// Asignar tarea al voluntario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['asignar_tarea'])) {
    $voluntario_id = $_POST['voluntario_id'];
    $tarea = $_POST['tarea'];
    
    $sql = "INSERT INTO scrum (voluntario_id, tarea) VALUES ('$voluntario_id', '$tarea')";
    if ($conexion->query($sql) === TRUE) {
        echo "Tarea asignada correctamente";
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Voluntariado</title>
</head>
<body>
    
    <h2>Asignar Tarea</h2>
    <form method="POST">
        <input type="number" name="voluntario_id" placeholder="ID del Voluntario" required>
        <input type="text" name="tarea" placeholder="Tarea" required>
        <button type="submit" name="asignar_tarea">Asignar</button>
    </form>
</body>
</html>
