<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Donaciones</title>
    <link rel="stylesheet" href="../CSS/estilosConsultar.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-left">
                <a href="../HTML/index.php" class="nav-link1">INICIO</a>
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
        <form id="frmConsultar" action="../../Controlador/donacionDineroControlador.php" method="POST">
            <input type="text" name="cedula" placeholder="Ingrese CC del donante" class="search-input">
            <input type="submit" value="Consultar" id="resEnviar">
        </form>
    </div>

    <div class="results-container">
        <?php if (!empty($donaciones)): ?>
            <?php foreach ($donaciones as $don): ?>
                <div class="result-item">
                    <span><b>Donante:</b> <?= $don['Don_Nombre_Donante'] . ' ' . $don['Don_Apellido_Donante'] ?></span><br>
                    <span><b>Cédula:</b> <?= $don['Don_Cedula_Donante'] ?></span><br>
                    <span><b>Monto:</b> $<?= number_format($don['Don_Monto'], 0, ',', '.') ?></span><br>
                    <span><b>Comisión:</b> $<?= number_format($don['Don_Comision'], 0, ',', '.') ?></span><br>
                    <span><b>Correo:</b> <?= $don['Don_Correo'] ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No se encontraron donaciones.</p>
        <?php endif; ?>
    </div>
</body>
</html>
