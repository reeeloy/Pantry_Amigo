<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../vista/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Registrar Usuario</h2>
        <form method="POST" action="../controlador/registroControl.php">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="text" name="tipo" placeholder="Tipo de Usuario" required>
            <input type="email" name="correo" placeholder="Correo Electrónico" required>
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
