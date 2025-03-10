<?php
require_once 'modelo/ConsultaRecursos.php';

if (isset($_POST['caso_id'])) {
    $caso_id = $_POST['caso_id'];
    $consulta = new ConsultaRecursos();
    $resultado = $consulta->consultarRecursos($caso_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Consulta</title>
</head>
<body>
    <div>
        <h1>Resultado de la Consulta</h1>
        <div>
            <?php if ($resultado->num_rows > 0): ?>
                <table>
                    <tr>
                        <th colspan="2">Recursos del Caso</th>
                    </tr>
                    <?php while ($fila = $resultado->fetch_object()): ?>
                        <tr>
                            <td>Recurso</td>
                            <td><?php echo $fila->recurso; ?></td>
                        </tr>
                        <tr>
                            <td>Cantidad</td>
                            <td><?php echo $fila->cantidad; ?></td>
                        </tr>
                        <tr>
                            <td>Tipo de Donación</td>
                            <td><?php echo $fila->tipo_donacion; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No se encontraron recursos para este caso.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
