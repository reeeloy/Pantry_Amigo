<!DOCTYPE html>
<html>

<head>
    <title>Registro de Voluntariado</title>
</head>

<body>
    <h2>Registro de Voluntarios</h2>

    <form id="frmDonar" action="../../Controlador/Controlador.php" method="POST">

        <label>CC:</label>
        <input type="text" name="regVolCedula" id="regDonaCedula" required><br>

        <label>Nombre:</label>
        <input type="text" name="regVolNombre" id="regDonaNombre" required><br>
 
        <label>Apellido:</label>
        <input type="text" name="regVolApellido" id="regDonaApellido" required><br>

        <label>Correo:</label>
        <input type="email" name="regVolCorreo" id="regVolCorreo" required><br>

        <label>Celular:</label>
        <input type="text" name="regVolCelular" id="regVolCorreo" required><br>

        <label>Caso Id:</label>
        <input type="text" name="regVolCasoId" id="regVolCasoId" required><br>


        <button type="submit" name="donarEnviar" value="Enviar" id="DonaEnviar">Registrar</button>
    </form>

</body>

</html>