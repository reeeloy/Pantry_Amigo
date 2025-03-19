<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantry Amigo </title>
    <link rel="stylesheet" href="../CSS/estiloDonar.css">
    <link rel="shortcut icon" href="../IMG/Logo.png">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../IMG/Logo.png" alt="Logo">
            </div>
            <div class="menu">

                <div class="menu-item">INFO
                    <ul class="submenu">
                        <li>SOBRE NOSOTROS</li>
                        <li>FAQ</li>
                        <li>AYUDA</li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="case-details">
                <h1>Caso de donación 1</h1>
                <p>ID: 1234567</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro ipsam dolorem delectus dolores, eum
                    facilis vitae esse ullam beatae minima qui deleniti. Ratione quis reiciendis eos quisquam incidunt
                    libero corporis!</p>
                <img src="../IMG/Tapas.png" alt="Imagen del caso" class="case-image">
                <div class="foundation-info">
                    <img src="../IMG/Fondo.png" alt="Logo de la fundación" class="foundation-logo">
                    <p>Fundacion123</p>
                    <a href="mailto:hello@reallygreatsite.com">hello@reallygreatsite.com</a>
                </div>
            </div>

            <div class="donation-summary">   
                <h2>Resumen</h2>
                <form id="frmDonar" action="../../Controlador/Controlador.php" method="POST">

                    <label for="DonaCedula">Cédula:</label>
                    <input type="text" name="regDonaCedula" id="regDonaCedula" required>

                    <label for="DonaNombre">Nombre:</label>
                    <input type="text" name="regDonaNombre" id="regDonaNombre" required>

                    <label for="DonaApellido">Apellido:</label>
                    <input type="text" name="regDonaApellido" id="regDonaApellido" required>

                    <label for="DonaCorreo">Correo:</label>
                    <input type="email" name="regDonaCorreo" id="regDonaCorreo" required>

                    <button type="submit" name="donarEnviar" value="Enviar" id="DonaEnviar">Continuar</button>
                </form>
            </div>
        </div>
    </main>

</body>

</html>