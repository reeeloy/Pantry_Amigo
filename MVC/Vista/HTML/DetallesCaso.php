<?php
require_once '../Controlador/CasoControlador.php';

$caso_id = $_GET['caso_id'];
$controlador = new CasoControlador();
$caso = $controlador->verDetallesCaso($caso_id);
?>

<h2><?php echo $caso['Caso_Nombre_Caso']; ?></h2>
<p><strong>Descripción:</strong> <?php echo $caso['Caso_Descripcion']; ?></p>
<p><strong>Fecha Inicio:</strong> <?php echo $caso['Caso_Fecha_Inicio']; ?></p>
<p><strong>Fecha Fin:</strong> <?php echo $caso['Caso_Fecha_Fin']; ?></p>
<p><strong>Estado:</strong> <?php echo $caso['Caso_Estado']; ?></p>

<?php if ($caso['Caso_Acep_Vol'] == 1): ?>
    <form action="inscribir_voluntario.php" method="POST">
        <input type="hidden" name="caso_id" value="<?php echo $caso_id; ?>">
        <button type="submit">Inscribirse como voluntario</button>
    </form>
<?php else: ?>
    <p>Este caso no acepta voluntarios.</p>
<?php endif; ?>
