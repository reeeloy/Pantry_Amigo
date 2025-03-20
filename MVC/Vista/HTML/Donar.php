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
                <p>ID: C006</p>
                <img src="../IMG/Tapas.png" alt="Imagen del caso" class="case-image">
                <div class="foundation-info">
                    <img src="../IMG/Fondo.png" alt="Logo de la fundación" class="foundation-logo">
                    <p>Fundacion123</p>
                    <a href="mailto:hello@reallygreatsite.com">hello@reallygreatsite.com</a>
                </div>
                <div class="donation-summary">

                    <h2>Datos de Donación</h2>
                    <form id="frmDonar" action="../../Controlador/Controlador.php" method="POST">

                        <input type="hidden" name="regDonCasoId" value="C006">

                        <label>Monto:</label>
                        <input type="text" name="regDonMonto" id="regDonMonto" required>

                        <label>Para Pantry Amigo:</label>
                        <input type="text" name="regDonComision" id="regDonComision" required>

                        <fieldset>
                            <h2>Datos del Donante</h2>

                            <label>Cédula:</label>
                            <input type="text" name="regDonCedula" required>

                            <label>Nombre:</label>
                            <input type="text" name="regDonNombre" required>

                            <label>Apellido:</label>
                            <input type="text" name="regDonApellido" required>

                            <label>Correo:</label>
                            <input type="email" name="regDonCorreo" required>

                        </fieldset>
                        <label for="regDonMetodoPago">Método de Pago:</label>
                        <select name="regDonMetodoPago" id="regDonMetodoPago" required>
                            <option value="" disabled selected>Selecciona un método</option>
                            <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>

                        <label for="regDonCatNombre">Categoría de Donación:</label>
                        <select name="regDonCatNombre" id="regDonCatNombre" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <option value="Alimentos">Alimentos</option>
                            <option value="Ropa">Ropa</option>
                            <option value="Medicinas">Medicinas</option>
                            <option value="Educación">Educación</option>
                            <option value="Otros">Otros</option>
                        </select>

                        <button type="submit" name="donarEnviar" value="Enviar" id="DonaEnviar">Continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>

</html>