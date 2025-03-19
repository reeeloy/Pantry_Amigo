<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear caso</title>
    <link rel="stylesheet" href="../CSS/estiloRegCaso.css">
</head>
<body>

 <header>
        <nav class="navbar">
            <div class="nav-left">
                <a href="../HTML/Home.html" class="nav-link1">INICIO</a>
            </div>
            <div class="nav-logo">
                <img src="../IMG/logoPA.png" alt="Logo" class="logo">
            </div>
            <div class="nav-right">
                <a href="../HTML/Pagina_15.html"><img src="../IMG/icon1.jfif" alt="Ayuda" class="icon"></a>
            </div>
        </nav>
</header>

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

    <label> ¿Este caso necesita voluntarios?
    <input type="checkbox" name="casoAceptaVoluntarios" value="1">
    </label>


    <button type="submit" name="registrarCaso"> Crear</button>
</form>

</body>
</html>