<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consultar Donaciones Activas</title>
    <link rel="stylesheet" href="../CSS/estilosCasos.css">
</head>
<body>
<nav>
            <div class="logo">
                <img src="../IMG/Logo.png" alt="Logo">
            </div>
            <div class="menu">
                <div class="menu-item-ubi">INICIO</div>
                <div class="menu-item">CUENTA
                    <ul class="submenu">
                        <li>SIGN UP</li>
                        <li>LOGIN</li>
                    </ul>
                </div>
                <div class="menu-item">PARTICIPAR
                    <ul class="submenu">
                        <li>Casos</li>
                        <li>Donar</li>
                        <li>Fundaciones</li>
                        <li>Voluntariados</li>
                    </ul>
                </div>
                <div class="menu-item">INFO
                    <ul class="submenu">
                        <li>SOBRE NOSOTROS</li>
                        <li>FAQ</li>
                        <li>AYUDA</li>
                    </ul>
                </div>
            </div>
        </nav>
    <div>
        <h1>Consultar Donaciones Activas</h1>
        <form id="frmConsultar" action="../../Controlador/Controlador.php" method="POST">
            <table>
                <tr>
                    <td>ID del Caso</td>
                    <td><input type="text" name="consultarDonaciones" id="consultarDonaciones"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="registroEnviar" value="Consultar" id="resEnviar"></td>
                    <td><input type="reset" value="Limpiar"></td>
                </tr>
            </table>
        </form>

        <h2>Listado de Donaciones Activas</h2>
        <table >
            <thead>
                <tr>
                    <th>ID Donación</th>
                    <th>Monto</th>
                    <th>Método de Pago</th>
                    <th>Nombre Donante</th>
                    <th>Correo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>001</td>
                    <td>$50,000</td>
                    <td>Tarjeta</td>
                    <td>Juan Pérez</td>
                    <td>juanperez@example.com</td>
                    <td>Activa</td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>$100,000</td>
                    <td>Transferencia</td>
                    <td>María López</td>
                    <td>marialopez@example.com</td>
                    <td>Activa</td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>$30,000</td>
                    <td>Paypal</td>
                    <td>Carlos Gómez</td>
                    <td>carlosgomez@example.com</td>
                    <td>Activa</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

