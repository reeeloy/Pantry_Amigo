<!DOCTYPE html>
<html>
<head>
    <title>Asignar Horario a Voluntario</title>
</head>
<body>
    <h2>Asignar Horario a Voluntario</h2>
    <?php if (isset($_GET['success'])) echo "<p style='color: green;'>Horario asignado con éxito.</p>"; ?>
    
    <form method="POST" action="ControladorParticipacion.php">
        <label>Seleccionar Voluntario:</label>
        <select name="voluntario" required>
            <?php foreach ($voluntarios as $voluntario) { ?>
                <option value="<?php echo $voluntario['Vol_Cedula']; ?>">
                    <?php echo $voluntario['Vol_Nombre'] . " " . $voluntario['Vol_Apellido']; ?>
                </option>
            <?php } ?>
        </select>
        <br>

        <label>Hora de Citación:</label>
        <input type="datetime-local" name="hora_citacion" required>
        <br>

        <label>Localización:</label>
        <input type="text" name="localizacion" required>
        <br>

        <label>Duración (horas):</label>
        <input type="number" name="duracion_horas" min="1" required>
        <br>

        <button type="submit">Asignar Horario</button>
    </form>
</body>
</html>