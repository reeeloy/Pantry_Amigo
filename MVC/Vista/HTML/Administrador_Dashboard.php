<!-- Administrador_Dashboard.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Administrador</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/estiloAdmin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    #form-editar-fundacion { display: none; margin: 1em 0; padding: 1em; background: #fffaf3; border: 1px solid #d9d9d9; }
    #form-editar-fundacion div { margin-bottom: 0.5em; }
    #form-editar-fundacion label { display: block; font-weight: bold; margin-bottom: 0.2em; }
    .acciones-form { margin-top: 0.5em; }
    .acciones-form button { margin-right: 0.5em; }
  </style>
</head>
<body>
  <div class="admin-dashboard">
    <!-- Sidebar (igual que antes) -->
    <aside class="sidebar">
      <div class="logo">
        <img src="/Pantry_Amigo/MVC/Vista/IMG/Logo_Pantry-amigo.png" alt="Logo" class="logo-img">
      </div>
      <nav class="menu">
        <ul>
          <li><a href="#" id="gestion-fundaciones-link" class="active"><i class="fas fa-hands-helping"></i> Gestionar Fundaciones</a></li>
          <li><a href="#" id="casos-link"><i class="fas fa-bullseye"></i> Casos de Donación</a></li>
          <li><a href="#" id="donaciones-dinero-link"><i class="fas fa-hand-holding-usd"></i> Donaciones en Dinero</a></li>
          <li><a href="#" id="donaciones-recursos-link"><i class="fas fa-box-open"></i> Donaciones en Recursos</a></li>
          <li><a href="#" id="cerrar-sesion-link"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="content">
      <header class="header">
        <h2 id="titulo-seccion">Gestionar Fundaciones</h2>
      </header>

      <!-- Sección Gestionar Fundaciones -->
      <section id="gestion-fundaciones" class="seccion-activa">
        <div class="search-bar">
          <input type="text" id="filtro-fundacion" placeholder="Buscar fundación por nombre o NIT">
          <button id="btn-filtrar-fundacion">Filtrar</button>
        </div>

        <!-- Contenedor del formulario de edición -->
        <div id="form-editar-fundacion">
          <h3><i class="fas fa-edit"></i> Editar Fundación</h3>
          <form id="editar-form">
            <input type="hidden" name="id" id="edit-id">
            <div>
              <label for="edit-nombre"><i class="fas fa-building"></i> Fund_Username</label>
              <input type="text" id="edit-nombre" name="Nombre" required>
            </div>
            <div>
              <label for="edit-correo"><i class="fas fa-envelope"></i> Fund_Correo</label>
              <input type="email" id="edit-correo" name="Correo" required>
            </div>
            <div>
              <label for="edit-telefono"><i class="fas fa-phone"></i> Fund_Telefono</label>
              <input type="text" id="edit-telefono" name="Telefono" required>
            </div>
            <div>
              <label for="edit-direccion"><i class="fas fa-map-marker-alt"></i> Fund_Direccion</label>
              <input type="text" id="edit-direccion" name="Direccion">
            </div>
            <div>
              <label for="edit-casos"><i class="fas fa-tasks"></i> Fund_Casos_Activos</label>
              <input type="number" id="edit-casos" name="CasosActivos" min="0">
            </div>
            <div class="acciones-form">
              <button type="submit"><i class="fas fa-save"></i> Guardar</button>
              <button type="button" id="btn-cancelar"><i class="fas fa-times"></i> Cancelar</button>
            </div>
          </form>
        </div>

        <!-- Lista de fundaciones -->
        <div id="lista-fundaciones">
          <!-- Se cargan dinámicamente -->
        </div>
      </section>

      <!-- Otras secciones… -->
    </main>
  </div>

  <script>
    // Almacena datos para editar sin pedirlos de nuevo
    let fundacionesMap = {};

    const secciones = {
      'gestion-fundaciones-link': 'gestion-fundaciones',
      'casos-link': 'casos',
      'donaciones-dinero-link': 'donaciones-dinero',
      'donaciones-recursos-link': 'donaciones-recursos'
    };
    const tituloSeccion = document.getElementById('titulo-seccion');

    // Navegación entre secciones
    Object.keys(secciones).forEach(linkId => {
      document.getElementById(linkId).addEventListener('click', () => {
        Object.values(secciones).forEach(sec => document.getElementById(sec).classList.add('seccion-oculta'));
        const actual = secciones[linkId];
        document.getElementById(actual).classList.remove('seccion-oculta');
        document.getElementById(actual).classList.add('seccion-activa');
        tituloSeccion.textContent = document.getElementById(linkId).textContent;
        document.querySelectorAll('.menu a').forEach(a => a.classList.remove('active'));
        document.getElementById(linkId).classList.add('active');
        if (actual === 'gestion-fundaciones') cargarFundaciones();
      });
    });

    // Mostrar / ocultar formulario de edición
    const formContainer = document.getElementById('form-editar-fundacion');
    function mostrarForm() { formContainer.style.display = 'block'; }
    function ocultarForm() { formContainer.style.display = 'none'; }

    // Cargar listado de fundaciones
    function cargarFundaciones() {
      ocultarForm();
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_fundaciones.php')
        .then(res => res.json())
        .then(data => {
          const lista = document.getElementById('lista-fundaciones');
          lista.innerHTML = '';
          fundacionesMap = {};
          if (data.error) {
            lista.innerHTML = `<p>Error: ${data.error}</p>`;
            return;
          }
          data.forEach(f => {
            fundacionesMap[f.ID] = f;
            const div = document.createElement('div');
            div.classList.add('fundacion');
            div.innerHTML = `
              <h3><i class="fas fa-building"></i> ${f.Nombre}</h3>
              <p><i class="fas fa-hashtag"></i> ID: ${f.ID}</p>
              <p><i class="fas fa-envelope"></i> ${f.Correo}</p>
              <p><i class="fas fa-phone"></i> ${f.Telefono}</p>
              <p><i class="fas fa-map-marker-alt"></i> ${f.Direccion}</p>
              <p><i class="fas fa-tasks"></i> Casos Activos: ${f.CasosActivos}</p>
              <div class="acciones">
                <button onclick="eliminarFundacion(${f.ID})">
                  <i class="fas fa-trash-alt"></i> Eliminar
                </button>
                <button onclick="editarFundacion(${f.ID})">
                  <i class="fas fa-edit"></i> Actualizar
                </button>
              </div>
            `;
            lista.appendChild(div);
          });
        })
        .catch(err => {
          document.getElementById('lista-fundaciones').innerHTML = `<p>Error de red: ${err.message}</p>`;
        });
    }

    // Eliminar
    function eliminarFundacion(id) {
      if (!confirm("¿Seguro que deseas eliminar esta fundación?")) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_fundacion.php?id=${id}`)
        .then(res => res.json())
        .then(d => { alert(d.message); cargarFundaciones(); })
        .catch(err => alert("Error al eliminar: " + err.message));
    }

    // Preparar formulario con datos y mostrarlo
    function editarFundacion(id) {
      const f = fundacionesMap[id];
      if (!f) return alert("No se encontraron datos");
      document.getElementById('edit-id').value        = f.ID;
      document.getElementById('edit-nombre').value    = f.Nombre;
      document.getElementById('edit-correo').value    = f.Correo;
      document.getElementById('edit-telefono').value  = f.Telefono;
      document.getElementById('edit-direccion').value = f.Direccion;
      document.getElementById('edit-casos').value     = f.CasosActivos;
      mostrarForm();
    }

    // Cancelar edición
    document.getElementById('btn-cancelar').addEventListener('click', () => {
      ocultarForm();
    });

    // Enviar actualización usando la misma ruta que ya tenías
    document.getElementById('editar-form').addEventListener('submit', e => {
      e.preventDefault();
      const formData = new FormData(e.target);
      fetch('/Pantry_Amigo/MVC/Vista/HTML/update_fundacion.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(d => {
        if (d.success) {
          alert(d.message);
          ocultarForm();
          cargarFundaciones();
        } else {
          alert(d.error || "Error al actualizar");
        }
      })
      .catch(err => alert("Error de red: " + err.message));
    });

    // Al cargar la página
    window.onload = () => cargarFundaciones();
  </script>
</body>
</html>
