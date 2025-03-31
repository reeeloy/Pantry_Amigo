<?php
require_once __DIR__ . '../../../../MVC/Controlador/fundacionControlador.php';
$controller = new FundacionControlador();

$fundacion = [];
if (isset($_GET['Fund_Id'])) {
    $fundacion = $controller->obtenerFundacion($_GET['Fund_Id']);
}

$mensaje = $_GET['mensaje'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y Actualización de Fundación</title>
    <link rel="stylesheet" href="../../../MVC/Vista/CSS/stylee.css">
</head>
<body>

<div class="container">
    <h2>Registro y Actualización de Fundación</h2>

    <?php if ($mensaje) echo "<p style='color:green;'>$mensaje</p>"; ?>

    <div class="profile-section">
        <div class="image-container">
            <img id="profilePreview" src="../../../MVC/Vista/Imagenes/default-profile.png" alt="Imagen de perfil">
            <input type="file" id="profileImage" accept="image/*" hidden>
            <label for="profileImage" class="btn btn-blue">Seleccionar imagen</label>
        </div>
    </div>
    
    <form id="fundacionForm" action="../../../MVC/Controlador/fundacionControlador.php" method="post">
        <div class="form-group">
            <input type="number" name="Fund_Id" id="Fund_Id" value="<?= $fundacion['Fund_Id'] ?? '' ?>" placeholder="ID Fundación" required>
            <input type="email" name="Fund_Correo" id="Fund_Correo" value="<?= $fundacion['Fund_Correo'] ?? '' ?>" placeholder="Correo" required>
        </div>
        <div class="form-group">
            <input type="text" name="Fund_Username" id="Fund_Username" value="<?= $fundacion['Fund_Username'] ?? '' ?>" placeholder="Nombre de Usuario" required>
            <input type="text" name="Fund_Direccion" id="Fund_Direccion" value="<?= $fundacion['Fund_Direccion'] ?? '' ?>" placeholder="Dirección" required>
        </div>
        <div class="form-group">
            <input type="number" name="Fund_Casos_Activos" id="Fund_Casos_Activos" value="<?= $fundacion['Fund_Casos_Activos'] ?? 0 ?>" placeholder="Casos Activos">
            <input type="text" name="Fund_Telefono" id="Fund_Telefono" value="<?= $fundacion['Fund_Telefono'] ?? '' ?>" placeholder="Teléfono" required>
        </div>
        <input type="number" name="Fund_Usu_Id" id="Fund_Usu_Id" class="full-width" value="<?= $fundacion['Fund_Usu_Id'] ?? '' ?>" placeholder="Usuario ID">

        <button type="submit" name="accion" value="registrar" class="btn btn-register">Registrar</button>
        <button type="submit" name="accion" value="actualizar" class="btn btn-update">Actualizar</button>
        <button type="button" onclick="window.location.href='Dashboard.php'" class="btn btn-blue">Regresar</button>
    </form>
</div>

<script>
    document.getElementById("profileImage").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("profilePreview").src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById("fundacionForm").addEventListener("submit", function(event) {
        let id = document.getElementById("Fund_Id").value;
        let correo = document.getElementById("Fund_Correo").value;
        let username = document.getElementById("Fund_Username").value;
        let direccion = document.getElementById("Fund_Direccion").value;
        let telefono = document.getElementById("Fund_Telefono").value;

        if (id === "" || correo === "" || username === "" || direccion === "" || telefono === "") {
            alert("Todos los campos son obligatorios");
            event.preventDefault();
            return;
        }

        let accion = document.activeElement.value;
        if (accion === "registrar") {
            alert("Fundación registrada correctamente");
        } else if (accion === "actualizar") {
            alert("Fundación actualizada correctamente");
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const buttons = document.querySelectorAll("button");
        buttons.forEach(button => {
            button.addEventListener("mouseenter", function() {
                this.style.transform = "scale(1.05)";
            });

            button.addEventListener("mouseleave", function() {
                this.style.transform = "scale(1)";
            });
        });
    });
</script>

</body>
</html>
