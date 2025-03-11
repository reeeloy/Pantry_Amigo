<?php
session_start();
require_once "./Controlador/ConexionBD.php";

$fundacion = null;

// Buscar la fundación por ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    if (!isset($_POST['fund_id']) || empty($_POST['fund_id'])) {
        die("Error: ID de fundación no proporcionado.");
    }

    $fund_id = intval($_POST['fund_id']);
    $result = $conn->query("SELECT * FROM Tbl_Fundaciones WHERE Fund_Id = $fund_id");

    if ($result->num_rows > 0) {
        $fundacion = $result->fetch_assoc();
    } else {
        $_SESSION['mensaje'] = "No se encontró la fundación con el ID proporcionado.";
    }
}

// Actualizar la fundación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    if (!isset($_POST['fund_id']) || empty($_POST['fund_id'])) {
        die("Error: ID de fundación no proporcionado.");
    }

    $fund_id = intval($_POST['fund_id']);
    $correo = $_POST['correo'];
    $username = $_POST['username'];
    $direccion = $_POST['direccion'];
    $casos_activos = $_POST['casos_activos'];
    $telefono = $_POST['telefono'];

    // Preparar la consulta para actualizar
    $sql = "UPDATE Tbl_Fundaciones SET Fund_Correo=?, Fund_Username=?, Fund_Direccion=?, Fund_Casos_Activos=?, Fund_Telefono=? WHERE Fund_Id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $correo, $username, $direccion, $casos_activos, $telefono, $fund_id);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Información actualizada correctamente.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fundación</title>
</head>
<body>
    <h2>Editar Información de la Fundación</h2>

    <?php if(isset($_SESSION['mensaje'])) { echo "<p>" . $_SESSION['mensaje'] . "</p>"; unset($_SESSION['mensaje']); } ?>

    <!-- Formulario para buscar la fundación por ID -->
    <form method="POST" action="">
        <label>ID de Fundación: 
            <input type="number" name="fund_id" value="<?php echo isset($fundacion['Fund_Id']) ? $fundacion['Fund_Id'] : ''; ?>" required>
        </label>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if ($fundacion): ?>
        <!-- Formulario para actualizar los datos -->
        <form method="POST" action="">
            <input type="hidden" name="fund_id" value="<?php echo $fundacion['Fund_Id']; ?>">
            <label>Correo: <input type="email" name="correo" value="<?php echo $fundacion['Fund_Correo']; ?>" required></label><br>
            <label>Nombre de Usuario: <input type="text" name="username" value="<?php echo $fundacion['Fund_Username']; ?>" required></label><br>
            <label>Dirección: <input type="text" name="direccion" value="<?php echo $fundacion['Fund_Direccion']; ?>" required></label><br>
            <label>Casos Activos: <input type="number" name="casos_activos" value="<?php echo $fundacion['Fund_Casos_Activos']; ?>" required></label><br>
            <label>Teléfono: <input type="text" name="telefono" value="<?php echo $fundacion['Fund_Telefono']; ?>" required></label><br>
            <button type="submit" name="actualizar">Actualizar</button>
        </form>
    <?php endif; ?>

</body>
</html>
