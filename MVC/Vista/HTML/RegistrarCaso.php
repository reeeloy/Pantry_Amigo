<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="../../Controlador/Controlador.php" method="POST">
<h2>Registro de Caso de Donación</h2>

<label>ID del Caso:</label>
    <input type="text" name="casoId" required><br>

    <label>Nombre del Caso:</label>
    <input type="text" name="casoNombre" required><br>

    <label>Descripción:</label>
    <textarea name="casoDescripcion" required></textarea><br>

    <label>Fecha de Inicio:</label>
    <input type="date" name="casoFechaInicio" required><br>

    <label>Fecha de Fin:</label>
    <input type="date" name="casoFechaFin"><br>

    <label>Estado:</label>
    <input type="text" name="casoEstado" required><br>

    <label>ID de Fundación:</label>
    <input type="number" name="casoFundacion" required><br>

    <button type="submit" name="registrarCaso"> crear Caso</button>
</form>

</body>
</html>