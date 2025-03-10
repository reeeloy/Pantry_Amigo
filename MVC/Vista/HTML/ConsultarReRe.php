<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consultar Recursos Recaudados</title>
</head>
<body>
    <div>
        <h1>Consultar Recursos Recaudados</h1>
        <form id="frmConsultar" action="../../Controlador/Controlador.php" method="POST">
            <table>
                <tr>
                    <td>ID del Caso</td>
                    <td><input type="text" name="caso_id" id="caso_id"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="consultar" value="Consultar"></td>
                    <td><input type="reset" value="Limpiar"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
