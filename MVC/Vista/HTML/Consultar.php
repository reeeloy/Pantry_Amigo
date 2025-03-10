<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/estilosConsultar.css">
    <title></title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="nav-left">
                <a href="../HTML/Home.html" class="nav-link1">INICIO</a>
                <a href="../HTML/registro.html" class="nav-link2">REGISTRARSE</a>
            </div>
            <div class="nav-logo">
                <img src="../IMG/logoPA.png" alt="Logo" class="logo">
            </div>
            <div class="nav-right">
                <a href="../HTML/Iniciasesion.html" class="nav-link3">INICIAR SESIÓN</a>
                <a href="../HTML/Pagina_15.html"><img src="../IMG/icon1.jfif" alt="Ayuda" class="icon"></a>
            </div>
        </nav>
    </header>

    <div class="search-container">
        <form id="frmConsultar" action="../../Controlador/Controlador.php" method="POST">
            <input type="text" placeholder="ingrese CC del participante" class="search-input">
            <input type="submit" name="registroEnviar" value="Consultar" id="resEnviar">
        </form>
    </div>


    <div class="results-container">
        <div class="result-item">
            <span><b>Caso</b> 123456789</span>
            <div class="icons">
                <i class="fas fa-eye"></i>
                <i class="fas fa-download"></i>
            </div>
        </div>
        <div class="result-item">
            <span><b>Caso</b> 123456789</span>
            <div class="icons">
                <i class="fas fa-eye"></i>
                <i class="fas fa-download"></i>
            </div>
        </div>
    </div>
</body>

</html>