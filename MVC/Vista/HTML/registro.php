<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="../CSS/styleee.css">
    <style>
        .campos-fundacion { display: none; }
        #mensaje-final { display: none; padding: 20px; border-radius: 5px; text-align: center; margin-top: 20px; }
        .mensaje-exito { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .mensaje-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
<div class="container">
    <h1>Regístrate</h1>
    <form id="form-registro" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Nombre de Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="email" name="correo" placeholder="Correo Electrónico" required>
        <select name="tipo" id="tipo-usuario" required>
            <option value="" disabled selected>Selecciona un tipo de cuenta</option>
            <option value="Usuario">Fundación</option>
            <option value="Administrador">Administrador</option>
        </select>
        <div id="campos-fundacion" class="campos-fundacion">
            <hr><p style="text-align: center; font-weight: bold;">Información de Verificación</p>
            <input type="text" name="Fund_NIT" placeholder="NIT de la Fundación">
            <label for="documento" style="margin-top: 10px; text-align: left; font-size: 0.9em;">Certificado de Existencia (PDF):</label>
            <input type="file" id="documento" name="Fund_Documento" accept=".pdf">
            <hr>
        </div>
        <button type="submit" name="register">Registrarse</button>
    </form>
    <div id="mensaje-final"></div>
</div>

<script>
    document.getElementById('tipo-usuario').addEventListener('change', function() {
        const camposFundacion = document.getElementById('campos-fundacion');
        const nitInput = camposFundacion.querySelector('input[name="Fund_NIT"]');
        const docInput = camposFundacion.querySelector('input[name="Fund_Documento"]');
        if (this.value === 'Usuario') {
            camposFundacion.style.display = 'block';
            nitInput.required = true;
            docInput.required = true;
        } else {
            camposFundacion.style.display = 'none';
            nitInput.required = false;
            docInput.required = false;
        }
    });

    document.getElementById('form-registro').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        // Es necesario añadir el name del botón al FormData para que el PHP lo detecte
        formData.append('register', 'true');

        const button = form.querySelector('button[type="submit"]');
        const mensajeDiv = document.getElementById('mensaje-final');
        button.disabled = true;
        button.textContent = 'Enviando...';
        mensajeDiv.style.display = 'none';

        fetch('../../Controlador/usuarioControlador.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                form.style.display = 'none';
                mensajeDiv.innerHTML = '<h3>¡Solicitud Enviada!</h3><p>Tu solicitud ha sido enviada, por favor espere a ser aceptado.</p>';
                mensajeDiv.className = 'mensaje-exito';
                mensajeDiv.style.display = 'block';
                setTimeout(() => { window.location.href = 'index.php'; }, 5000);
            } else {
                mensajeDiv.textContent = 'Error: ' + data.message;
                mensajeDiv.className = 'mensaje-error';
                mensajeDiv.style.display = 'block';
                button.disabled = false;
                button.textContent = 'Registrarse';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mensajeDiv.textContent = 'Ocurrió un error de comunicación con el servidor.';
            mensajeDiv.className = 'mensaje-error';
            mensajeDiv.style.display = 'block';
            button.disabled = false;
            button.textContent = 'Registrarse';
        });
    });
</script>
</body>
</html>