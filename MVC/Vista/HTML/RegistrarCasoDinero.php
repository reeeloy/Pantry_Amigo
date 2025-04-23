<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Caso de Donación</title>
    <link rel="stylesheet" href="../../Vista/CSS/estiloRegCaso.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Caso de Donación de Dinero</h2>

        <form action="../../Controlador/Controlador.php" method="POST" enctype="multipart/form-data">
            <label>Nombre del Caso:</label>
            <input type="text" name="casoNombre" required><br>

            <label>Descripción:</label>
            <textarea name="casoDescripcion" required></textarea><br>

            <label>Meta de Recaudación:</label>
            <input type="number" name="casoMontoMeta" required>

            <label>Fecha de Inicio:</label>
            <input type="date" name="casoFechaInicio" required><br>

            <label>Fecha de Fin:</label>
            <input type="date" name="casoFechaFin"><br>

            <label>Estado:</label>
            <select name="casoEstado" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>

            <label>Imagen del Caso:</label>
            <input type="file" name="casoImagen" accept="image/*">

            <label>Permitir Voluntariado:</label>
            <input type="checkbox" name="casoVoluntariado" value="1">

            <label>ID de Fundación:</label>
            <input type="number" name="casoFundacion" required><br>

            <label>Categoría:</label>
            <select name="casoCategoria" required>
                <option value="Salud">Salud</option>
                <option value="Educacion">Educacion</option>
                <option value="Emergencias">Emergencias</option>
                <option value="Alimentación">Alimentación</option>
                <option value="Tecnología">Tecnología</option>
                <option value="Medio Ambiente">Medio Ambiente</option>
            </select>

            <button type="submit" name="registrarCasoDin">Crear Caso Dinero</button>
        </form>
    </div>
</body>
</html>
