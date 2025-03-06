<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/estiloDonar.css">
    <title>Crear nuevo caso</title>
</head>
<body>
<h2>Crear Caso de Donación</h2>
    <form action="backend/crear_caso.php" method="POST">
        <label for="nombre">Nombre del Caso:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        
        <label for="fundacion">Fundación:</label>
        <select id="fundacion" name="fundacion" required>
            <option value="">Seleccione una fundación</option>
            <!-- Opciones dinámicas desde Tbl_Fundaciones -->
        </select>
        
        <label for="meta">Meta de Donación:</label>
        <input type="number" id="meta" name="meta" required>
        
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
        
        <label for="fecha_limite">Fecha Límite:</label>
        <input type="date" id="fecha_limite" name="fecha_limite" required>
        
        <label for="estado">Estado del Caso:</label>
        <select id="estado" name="estado" required>
            <option value="activo">Activo</option>
            <option value="cerrado">Cerrado</option>
        </select>
        
        <label for="categorias">Categorías:</label>
        <select id="categorias" name="regcategorias" multiple required>
            <option value="">Seleccione categorías</option>
            <!-- Opciones dinámicas desde Tbl_Categorias -->
        </select>
        
        <label for="voluntarios">Voluntarios Asignados:</label>
        <select id="voluntarios" name="regvoluntarios" multiple>
            <option value="">Seleccione voluntarios</option>
            <!-- Opciones dinámicas desde Tbl_Voluntarios -->
        </select>
        
        <button type="submit">Crear Caso</button>
    </form>
</body>
</html>