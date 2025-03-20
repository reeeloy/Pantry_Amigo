<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../vista/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Recuperar Contraseña</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (isset($mensaje)) echo "<p style='color:green;'>$mensaje</p>"; ?>
        <form method="POST" action="../controlador/usuarioControlador.php">
            <input type="email" name="correo" placeholder="Correo Electrónico" required>
            <button type="submit" name="recuperar">Recuperar Contraseña</button>
        </form>
        <p><a href="IniciarSesionFrom.php">Volver al inicio de sesión</a></p>
    </div>
</body>
</html>
