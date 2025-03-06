<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Donación</title>
    <link rel="stylesheet" href="../CSS/estiloDonar.css">
</head>
<body>

<?php
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
} else {
    echo "<p>Error: No se encontró el donante.</p>";
    exit();
}
?>

<main>
    <h2>Registrar Donación</h2>
    <form action="procesarDonacion.php" method="POST">
        <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($cedula); ?>">

        <label for="tipoDonacion">Tipo de Donación:</label>
        <select name="tipoDonacion" id="tipoDonacion">
            <option value="dinero">Dinero</option>
            <option value="alimentos">Alimentos</option>
            <option value="ropa">Ropa</option>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required>

        <button type="submit">Registrar Donación</button>
    </form>
</main>

</body>
</html>
