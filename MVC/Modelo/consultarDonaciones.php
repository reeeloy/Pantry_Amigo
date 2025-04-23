<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Donaciones</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
        }
        th, td {
            border: 1px solid #888;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #b9dfff;
        }
    </style>
</head>
<body>

<form method="POST" style="text-align: center; margin-top: 20px;">
    <input type="text" name="cedula" placeholder="Ingrese CC del donante">
    <button type="submit">Consultar</button>
</form>

<?php if (!empty($donaciones)) { ?>
    <table>
        <thead>
            <tr>
                <th>Monto</th>
                <th>Comisión</th>
                <th>Cédula Donante</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donaciones as $don) { ?>
                <tr>
                    <td><?php echo $don['Don_Monto']; ?></td>
                    <td><?php echo $don['Don_Comision']; ?></td>
                    <td><?php echo $don['Don_Cedula_Donante']; ?></td>
                    <td><?php echo $don['Don_Nombre_Donante']; ?></td>
                    <td><?php echo $don['Don_Apellido_Donante']; ?></td>
                    <td><?php echo $don['Don_Correo']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p style="text-align:center; margin-top:20px;">No se encontraron donaciones.</p>
<?php } ?>

</body>
</html>
