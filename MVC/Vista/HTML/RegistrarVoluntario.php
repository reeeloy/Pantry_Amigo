<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../CSS/estiloRegVoluntario.css">
    <title>Registro de Voluntariado</title>
</head>
<body>
<?php
$casoId = isset($_GET['ID']) ? $_GET['ID'] : '';
?>
<div class="voluntario-card">
    <div class="voluntario-formulario">
        <h2>Registro de Voluntarios</h2>
        <form id="frmDonar" action="../../Controlador/Controlador.php" method="POST" target="dummyFrame">
            <label>CC:</label>
            <input type="text" name="regVolCedula" required>

            <label>Nombre:</label>
            <input type="text" name="regVolNombre" required>

            <label>Apellido:</label>
            <input type="text" name="regVolApellido" required>

            <label>Correo:</label>
            <input type="email" name="regVolCorreo" required>

            <label>Celular:</label>
            <input type="text" name="regVolCelular" required>

            <input type="hidden" name="regVolCasoId" value="<?php echo $casoId; ?>">

            <button type="submit" name="registrarVoluntario">Registrar</button>
        </form>
    </div>
</div>

<!-- Iframe oculto para evitar recargar la página -->
<iframe name="dummyFrame" style="display: none;"></iframe>

<script>
    // Este script espera la respuesta del backend y envía mensaje al padre
    window.addEventListener("load", function () {
        const form = document.getElementById("frmDonar");
        form.addEventListener("submit", function () {
            // Esperamos unos segundos a que se procese
            setTimeout(() => {
                window.parent.postMessage('voluntariado_exito', '*');
            }, 1000);
        });
    });
</script>
</body>
</html>
