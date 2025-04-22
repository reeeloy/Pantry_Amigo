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
    /* === Formulario de edición === */
    #form-editar-fundacion {
      display: none; margin: 1em 0; padding: 1em;
      background: #fffaf3; border: 1px solid #d9d9d9;
    }
    #form-editar-fundacion div { margin-bottom: .5em; }
    #form-editar-fundacion label {
      display: block; font-weight: bold; margin-bottom: .2em;
    }
    .acciones-form { margin-top: .5em; display: flex; gap: .5em; }
    .acciones-form button { flex: 1; }

    /* === Casos de Donación: tarjetas y botones pequeños === */
    .caso {
      background: #f8f9fa; padding: 1em; margin-bottom: .8em;
      border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .caso h4 { margin: 0 0 .5em; color: #2b577d; }
    .caso .acciones {
      margin-top: .5em; display: flex; gap: .5em;
    }
    .caso .acciones button {
      background: #e74c3c; color: white; border: none;
      padding: 4px 8px; border-radius: 4px; cursor: pointer;
      font-size: 0.8em; transition: background 0.2s;
    }
    .caso .acciones button:hover {
      background: #c0392b;
    }

    /* Barra de búsqueda */
    .search-bar { margin: 15px 0; display: flex; gap: 10px; }
    .search-bar input {
      flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 5px;
    }
    .search-bar button {
      padding: 8px 12px; background-color: #2b577d;
      color: white; border: none; border-radius: 5px; cursor: pointer;
      transition: background 0.2s;
    }
    .search-bar button:hover { background-color: #1f3e5b; }
  </style>
</head>
<body>
  <div class="admin-dashboard">
    <!-- Sidebar -->
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

      <!-- Gestionar Fundaciones -->
      <section id="gestion-fundaciones" class="seccion-activa">
        <div class="search-bar">
          <input type="text" id="filtro-fundacion" placeholder="Buscar fundación por nombre o NIT">
          <button id="btn-filtrar-fundacion"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        <div id="form-editar-fundacion">
          <h3><i class="fas fa-edit"></i> Editar Fundación</h3>
          <form id="editar-form">
            <input type="hidden" name="id" id="edit-id">
            <div><label for="edit-nombre">Fund_Username</label><input type="text" id="edit-nombre" name="Nombre" required></div>
            <div><label for="edit-correo">Fund_Correo</label><input type="email" id="edit-correo" name="Correo" required></div>
            <div><label for="edit-telefono">Fund_Telefono</label><input type="text" id="edit-telefono" name="Telefono" required></div>
            <div><label for="edit-direccion">Fund_Direccion</label><input type="text" id="edit-direccion" name="Direccion"></div>
            <div><label for="edit-casos">Fund_Casos_Activos</label><input type="number" id="edit-casos" name="CasosActivos" min="0"></div>
            <div class="acciones-form">
              <button type="submit"><i class="fas fa-save"></i> Guardar</button>
              <button type="button" id="btn-cancelar"><i class="fas fa-times"></i> Cancelar</button>
            </div>
          </form>
        </div>
        <div id="lista-fundaciones"></div>
      </section>

      <!-- Casos de Donación -->
      <section id="casos" class="seccion-oculta">
        <h3>Casos de Donación</h3>
        <div class="search-bar">
          <input type="text" id="filtro-casos" placeholder="Buscar caso por ID o nombre">
          <button id="btn-filtrar-casos"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        <div id="lista-casos-dinero"></div>
        <hr>
        <div id="lista-casos-recursos"></div>
      </section>

      <!-- Donaciones en Dinero -->
      <section id="donaciones-dinero" class="seccion-oculta">
        <!-- ... -->
      </section>

      <!-- Donaciones en Recursos -->
      <section id="donaciones-recursos" class="seccion-oculta">
        <!-- ... -->
      </section>
    </main>
  </div>

  <script>
    // Datos en memoria
    let fundacionesData = [], casosDineroData = [], casosRecursosData = [];

    // Mapeo de secciones
    const secciones = {
      'gestion-fundaciones-link':'gestion-fundaciones',
      'casos-link':'casos',
      'donaciones-dinero-link':'donaciones-dinero',
      'donaciones-recursos-link':'donaciones-recursos'
    };

    const tituloSeccion = document.getElementById('titulo-seccion');
    const formEd = document.getElementById('form-editar-fundacion');

    // Muestra/oculta el formulario de edición
    function ocultarForm(){ formEd.style.display = 'none'; }
    function mostrarForm(){ formEd.style.display = 'block'; }

    // Manejo de navegación
    Object.keys(secciones).forEach(linkId => {
      document.getElementById(linkId).addEventListener('click', () => {
        // Oculta todas
        Object.values(secciones).forEach(sec =>
          document.getElementById(sec).classList.add('seccion-oculta')
        );
        // Muestra la activa
        const act = secciones[linkId];
        document.getElementById(act).classList.remove('seccion-oculta');
        document.getElementById(act).classList.add('seccion-activa');

        // Activa el menú
        document.querySelectorAll('.menu a').forEach(a => a.classList.remove('active'));
        document.getElementById(linkId).classList.add('active');
        tituloSeccion.textContent = document.getElementById(linkId).textContent;

        // Carga datos según sección
        if (act === 'gestion-fundaciones') { 
          ocultarForm();
          cargarFundaciones();
        }
        if (act === 'casos') {
          cargarCasosDinero();
          cargarCasosRecursos();
        }
      });
    });

    // — Gestionar Fundaciones —
    function cargarFundaciones(){
      ocultarForm();
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_fundaciones.php')
        .then(r => r.json())
        .then(data => {
          fundacionesData = data.error ? [] : data;
          renderFundaciones(fundacionesData);
        })
        .catch(e => {
          document.getElementById('lista-fundaciones').innerHTML =
            `<p>Error de red: ${e.message}</p>`;
        });
    }
    function renderFundaciones(list){
      const c = document.getElementById('lista-fundaciones');
      c.innerHTML = '';
      list.forEach(f => {
        const d = document.createElement('div');
        d.classList.add('fundacion');
        d.innerHTML = `
          <h3><i class="fas fa-building"></i> ${f.Nombre}</h3>
          <p><i class="fas fa-hashtag"></i> ID: ${f.ID}</p>
          <p><i class="fas fa-envelope"></i> ${f.Correo}</p>
          <p><i class="fas fa-phone"></i> ${f.Telefono}</p>
          <p><i class="fas fa-map-marker-alt"></i> ${f.Direccion}</p>
          <p><i class="fas fa-tasks"></i> Casos Activos: ${f.CasosActivos}</p>
          <div class="acciones">
            <button onclick="eliminarFundacion(${f.ID})"><i class="fas fa-trash-alt"></i> Eliminar</button>
            <button onclick="editarFundacion(${f.ID})"><i class="fas fa-edit"></i> Actualizar</button>
          </div>`;
        c.appendChild(d);
      });
    }
    document.getElementById('btn-filtrar-fundacion').addEventListener('click', ()=>{
      const filtro = document.getElementById('filtro-fundacion').value.trim().toLowerCase();
      renderFundaciones(fundacionesData.filter(f =>
        f.ID.toString().includes(filtro) ||
        f.Nombre.toLowerCase().includes(filtro)
      ));
    });
    function eliminarFundacion(id){
      if (!confirm("¿Eliminar esta fundación?")) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_fundacion.php?id=${id}`)
        .then(r => r.json())
        .then(d => { alert(d.message); if (d.success) cargarFundaciones(); })
        .catch(e => alert("Error de red: " + e.message));
    }
    function editarFundacion(id){
      const f = fundacionesData.find(x => x.ID === id);
      if (!f) return alert("No encontrado");
      document.getElementById('edit-id').value = f.ID;
      document.getElementById('edit-nombre').value = f.Nombre;
      document.getElementById('edit-correo').value = f.Correo;
      document.getElementById('edit-telefono').value = f.Telefono;
      document.getElementById('edit-direccion').value = f.Direccion;
      document.getElementById('edit-casos').value = f.CasosActivos;
      mostrarForm();
    }
    document.getElementById('btn-cancelar').addEventListener('click', ocultarForm);
    document.getElementById('editar-form').addEventListener('submit', e => {
      e.preventDefault();
      const fd = new FormData(e.target);
      fetch('/Pantry_Amigo/MVC/Vista/HTML/update_fundacion.php',{
        method:'POST', body: fd
      })
      .then(r=>r.json())
      .then(d=>{ alert(d.message); if(d.success){ ocultarForm(); cargarFundaciones(); }})
      .catch(e=>alert("Error de red: "+e.message));
    });

    // — Casos de Dinero —
    function cargarCasosDinero(){
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_dinero.php')
        .then(r=>r.json())
        .then(data=>{
          casosDineroData = data.error ? [] : data;
          renderCasosDinero(casosDineroData);
        })
        .catch(e => {
          document.getElementById('lista-casos-dinero').innerHTML =
            `<p>Error de red: ${e.message}</p>`;
        });
    }
    function renderCasosDinero(list){
      const c = document.getElementById('lista-casos-dinero');
      c.innerHTML = '<h4>Casos de Dinero</h4>';
      list.forEach(ci=>{
        const d = document.createElement('div');
        d.classList.add('caso');
        d.innerHTML = `
          <h4>${ci.Caso_Nombre} (${ci.Caso_Id})</h4>
          <p>${ci.Caso_Descripcion}</p>
          <p><strong>Meta:</strong> ${ci.Caso_Monto_Meta} • <strong>Recaudado:</strong> ${ci.Caso_Monto_Recaudado}</p>
          <p><strong>Inicio:</strong> ${ci.Caso_Fecha_Inicio} • <strong>Fin:</strong> ${ci.Caso_Fecha_Fin}</p>
          <p><strong>Estado:</strong> ${ci.Caso_Estado} • <strong>Categoría:</strong> ${ci.Caso_Cat_Nombre}</p>
          <div class="acciones">
            <button onclick="eliminarCasoDinero(${ci.Caso_Id})">
              <i class="fas fa-trash-alt"></i> Eliminar
            </button>
          </div>`;
        c.appendChild(d);
      });
    }
    function eliminarCasoDinero(id){
      if (!confirm("¿Eliminar este caso de dinero?")) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_dinero.php?id=${id}`)
        .then(r=>r.json())
        .then(d=>{ alert(d.message); if(d.success) cargarCasosDinero(); })
        .catch(e=>alert("Error de red: "+e.message));
    }

    // — Casos de Recursos —
    function cargarCasosRecursos(){
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_recursos.php')
        .then(r=>r.json())
        .then(data=>{
          casosRecursosData = data.error ? [] : data;
          renderCasosRecursos(casosRecursosData);
        })
        .catch(e => {
          document.getElementById('lista-casos-recursos').innerHTML =
            `<p>Error de red: ${e.message}</p>`;
        });
    }
    function renderCasosRecursos(list){
      const c = document.getElementById('lista-casos-recursos');
      c.innerHTML = '<h4>Casos de Recursos</h4>';
      list.forEach(cr=>{
        const d = document.createElement('div');
        d.classList.add('caso');
        d.innerHTML = `
          <h4>${cr.Caso_Nombre} (${cr.Caso_Id})</h4>
          <p>${cr.Caso_Descripcion}</p>
          <p><strong>Inicio:</strong> ${cr.Caso_Fecha_Inicio} • <strong>Fin:</strong> ${cr.Caso_Fecha_Fin}</p>
          <p><strong>Estado:</strong> ${cr.Caso_Estado} • <strong>Punto Recolección:</strong> ${cr.Caso_Punto_Recoleccion}</p>
          <p><strong>Voluntariado:</strong> ${cr.Caso_Voluntariado} • <strong>Categoría:</strong> ${cr.Caso_Cat_Nombre}</p>
          <div class="acciones">
            <button onclick="eliminarCasoRecurso(${cr.Caso_Id})">
              <i class="fas fa-trash-alt"></i> Eliminar
            </button>
          </div>`;
        c.appendChild(d);
      });
    }
    function eliminarCasoRecurso(id){
      if (!confirm("¿Eliminar este caso de recurso?")) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_recursos.php?id=${id}`)
        .then(r=>r.json())
        .then(d=>{ alert(d.message); if(d.success) cargarCasosRecursos(); })
        .catch(e=>alert("Error de red: "+e.message));
    }

    // Filtrar Casos
    document.getElementById('btn-filtrar-casos').addEventListener('click', ()=>{
      const f = document.getElementById('filtro-casos').value.trim().toLowerCase();
      renderCasosDinero(casosDineroData.filter(ci =>
        ci.Caso_Id.toString().includes(f) ||
        ci.Caso_Nombre.toLowerCase().includes(f)
      ));
      renderCasosRecursos(casosRecursosData.filter(cr =>
        cr.Caso_Id.toString().includes(f) ||
        cr.Caso_Nombre.toLowerCase().includes(f)
      ));
    });

    // Inicial
    window.onload = () => cargarFundaciones();
  </script>
</body>
</html>
