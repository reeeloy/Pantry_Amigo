<?php
require_once '../../Modelo/ConexionBD.php';

$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar con la base de datos.");
}

$id = $_GET['ID'] ?? 0;
$categoria = $_GET['categoria'] ?? '';

$sql = "SELECT * FROM Tbl_Casos_Dinero WHERE Caso_Id = ?";
$conn->consulta($sql, [$id]);
$result = $conn->obtenerResult();
$caso = $result->fetch_assoc();

$conn->cerrar();
?>
<head>
  <title>Donación</title>
  <link rel="stylesheet" href="../CSS/estilosDonacion.css">
</head>

<h2>Donar al caso:</h2>

<?php if ($caso): ?>
  <p><strong><?= htmlspecialchars($caso['Caso_Nombre']) ?></strong></p>
  <p><?= htmlspecialchars($caso['Caso_Descripcion']) ?></p>
  <p><strong>Categoría:</strong> <?= htmlspecialchars($categoria) ?></p>


  <form action="../../Controlador/CrearPreferencia.php" method="POST">
    <input type="hidden" name="casoId" value="<?= $caso['Caso_Id'] ?>">
    <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria) ?>">


    <label>Nombre:</label>
    <input type="text" name="nombre" required><br>

    <label>Apellido:</label>
    <input type="text" name="apellido" required><br>

    <label>Cédula:</label>
    <input type="text" name="cedula" required><br>

    <label>Correo:</label>
    <input type="email" name="correo" required><br>

    <label>Monto a donar:</label>
    <input type="number" name="monto" min="1000" required><br>

    <button type="submit">Ir a pagar</button>
  </form>

<?php else: ?>
  <p style="color: red;">No se encontró el caso con ID <?= htmlspecialchars($id) ?></p>
<?php endif; ?>

