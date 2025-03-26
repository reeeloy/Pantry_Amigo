<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '/xampp/htdocs/Pantry-Amigo/MVC/Modelo/ConexionBD.php';  // Ajusta la ruta según tu estructura

$conexion = new ConexionBD();
$conexion->abrir();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar actualización
    $caso_id          = $_POST['Caso_Id'];
    $nombre_caso      = $_POST['Caso_Nombre_Caso'];
    $descripcion      = $_POST['Caso_Descripcion'];
    $fecha_inicio     = $_POST['Caso_Fecha_Inicio'];
    $fecha_fin        = $_POST['Caso_Fecha_Fin'];
    $estado           = $_POST['Caso_Estado'];

    // Consulta UPDATE (usa sentencias preparadas en producción)
    $sql = "UPDATE tbl_caso_donacion 
            SET Caso_Nombre_Caso = '$nombre_caso',
                Caso_Descripcion = '$descripcion',
                Caso_Fecha_Inicio = '$fecha_inicio',
                Caso_Fecha_Fin = '$fecha_fin',
                Caso_Estado = '$estado'
            WHERE Caso_Id = '$caso_id'";
    $conexion->consulta($sql);
    
    if ($conexion->obtenerFilasAfectadas() > 0) {
        echo "<p>Caso actualizado correctamente. <a href='Dashboard.php'>Volver al Dashboard</a></p>";
    } else {
        echo "<p>Error al actualizar el caso o no se realizaron cambios. <a href='Dashboard.php'>Volver al Dashboard</a></p>";
    }
    $conexion->cerrar();
    exit();
} else {
    // Modo GET: Mostrar el formulario con datos actuales
    if (!isset($_GET['caso_id'])) {
        die("No se proporcionó el ID del caso.");
    }
    $caso_id = $_GET['caso_id'];
    $sql = "SELECT * FROM tbl_caso_donacion WHERE Caso_Id = '$caso_id'";
    $conexion->consulta($sql);
    $resultado = $conexion->obtenerResult();
    
    if (count($resultado) === 0) {
        die("Caso no encontrado.");
    }
    
    $caso = $resultado[0];
}
$conexion->cerrar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Caso</title>
  <link rel="stylesheet" href="../CSS/estiloActualizarCaso.css">
  <style>
    /* Estilos básicos para el formulario de actualización */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }
    .form-container {
      background-color: #fff;
      padding: 20px;
      max-width: 600px;
      margin: auto;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .form-container h2 {
      text-align: center;
      color: #4CAF50;
      margin-bottom: 20px;
    }
    .form-container label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    .form-container input,
    .form-container textarea,
    .form-container select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .form-container button {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      margin-top: 20px;
      cursor: pointer;
      border-radius: 5px;
      width: 100%;
      font-size: 16px;
    }
    .form-container button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Actualizar Caso</h2>
    <form action="actualizar_caso.php" method="POST">
      <label for="Caso_Id">ID del Caso:</label>
      <input type="text" id="Caso_Id" name="Caso_Id" value="<?php echo $caso['Caso_Id']; ?>" readonly>
      
      <label for="Caso_Nombre_Caso">Nombre del Caso:</label>
      <input type="text" id="Caso_Nombre_Caso" name="Caso_Nombre_Caso" value="<?php echo $caso['Caso_Nombre_Caso']; ?>" required>
      
      <label for="Caso_Descripcion">Descripción:</label>
      <textarea id="Caso_Descripcion" name="Caso_Descripcion" required><?php echo $caso['Caso_Descripcion']; ?></textarea>
      
      <label for="Caso_Fecha_Inicio">Fecha de Inicio:</label>
      <input type="date" id="Caso_Fecha_Inicio" name="Caso_Fecha_Inicio" value="<?php echo $caso['Caso_Fecha_Inicio']; ?>" required>
      
      <label for="Caso_Fecha_Fin">Fecha de Fin:</label>
      <input type="date" id="Caso_Fecha_Fin" name="Caso_Fecha_Fin" value="<?php echo $caso['Caso_Fecha_Fin']; ?>" required>
      
      <label for="Caso_Estado">Estado:</label>
      <select id="Caso_Estado" name="Caso_Estado" required>
        <option value="Activo" <?php echo (strtolower($caso['Caso_Estado']) === 'activo') ? 'selected' : ''; ?>>Activo</option>
        <option value="Inactivo" <?php echo (strtolower($caso['Caso_Estado']) === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
      </select>
      
      <button type="submit">Actualizar Caso</button>
    </form>
  </div>
</body>
</html>
