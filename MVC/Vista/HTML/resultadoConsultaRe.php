<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta id recursos</title>
</head>
<body>
    <div>Consulta de recursos recaudados caso: <?php echo htmlspecialchars($caso_id); ?></div>
    <div>
        <table>
            <tr><th colspan="6">Datos de recursos recaudados</th></tr>
            <tr>
                <th>Nombre del Recurso</th>
                <th>Cantidad</th>
                <th>Disponibilidad</th>
                <th>Descripción</th>
                <th>Fecha de Caducidad</th>
                <th>Categoría</th>
            </tr>
            <?php while ($fila = $result->fetch_object()) { ?>
            <tr>
                <td><?php echo $fila->Rec_Nombre; ?></td>
                <td><?php echo $fila->Rec_Cantidad; ?></td>
                <td><?php echo $fila->Rec_Disponibilidad; ?></td>
                <td><?php echo $fila->Rec_Descripcion; ?></td>
                <td><?php echo $fila->Rec_Fecha_Caducidad; ?></td>
                <td><?php echo $fila->Rec_Cat_Nombre; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>





