<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/fundacion_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    /* === Formulario para crear/editar casos === */
    #form-caso {
      display: none;
      background: #fff;
      border: 1px solid #ccc;
      padding: 1em;
      border-radius: 6px;
      margin-bottom: 1em;
    }
    #form-caso h4 {
      margin-top: 0;
      color: #2b577d;
    }
    #form-caso div {
      margin-bottom: .8em;
    }
    #form-caso label {
      display: block;
      font-weight: bold;
      margin-bottom: .3em;
    }
    #form-caso input,
    #form-caso select {
      width: 100%;
      padding: .6em;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    #form-caso .acciones-form {
      text-align: right;
    }
    #form-caso .acciones-form button {
      padding: .6em 1em;
      margin-left: .5em;
    }
    /* Botón Añadir Caso */
    #btn-agregar-caso {
      background: #7ec8a1;
      color: white;
      border: none;
      padding: .6em 1em;
      border-radius: 4px;
      cursor: pointer;
      margin-bottom: 1em;
    }
    #btn-agregar-caso:hover {
      background: #65b28a;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="/Pantry_Amigo/MVC/Vista/IMG/Logo_Pantry-amigo.png" alt="Logo" class="logo-img">
      </div>
      <nav class="nav menu">
        <a href="#" id="perfil-link" class="active"><i class="fas fa-user"></i> Perfil</a>
        <a href="#" id="casos-link"><i class="fas fa-folder-open"></i> Casos</a>
        <a href="#" id="crear-caso-link"><i class="fas fa-plus-circle"></i> Crear Caso</a>
        <a href="#" id="voluntarios-link"><i class="fas fa-users"></i> Voluntarios</a>
        <a href="#" id="historial-link"><i class="fas fa-history"></i> Historial</a>
        <a href="#" id="ayuda-link"><i class="fas fa-question-circle"></i> Ayuda</a>
        <a href="/Pantry_Amigo/logout.php" id="cerrar-sesion-link" class="cerrar-sesion">
          <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="main-content">
      <header class="header">
        <h2 id="titulo-seccion">Perfil</h2>
      </header>

      <!-- Secciones -->
      <section id="perfil" class="seccion-activa">
        <p>Bienvenido a tu dashboard, aquí verás la información de tu fundación.</p>
      </section>

      <section id="casos" class="seccion-oculta">
        <h3>Casos de Donación</h3>

        <!-- Botón Añadir Caso -->
        <button id="btn-agregar-caso"><i class="fas fa-plus"></i> Añadir Caso</button>

        <!-- Formulario para Crear/Editar Caso -->
        <div id="form-caso">
          <h4 id="form-caso-titulo">Agregar Caso</h4>
          <form id="caso-form">
            <input type="hidden" name="tipo" id="caso-tipo" value="dinero">
            <input type="hidden" name="Caso_Id" id="caso-id">

            <div>
              <label for="caso-nombre">Nombre</label>
              <input type="text" id="caso-nombre" name="Caso_Nombre" required>
            </div>

            <div>
              <label for="caso-desc">Descripción</label>
              <input type="text" id="caso-desc" name="Caso_Descripcion" required>
            </div>

            <div>
              <label for="caso-tipo-select">Tipo de Caso</label>
              <select id="caso-tipo-select" name="tipo">
                <option value="dinero">Dinero</option>
                <option value="recurso">Recurso</option>
              </select>
            </div>

            <div id="campos-dinero">
              <div>
                <label for="caso-meta">Monto Meta</label>
                <input type="number" id="caso-meta" name="Caso_Monto_Meta">
              </div>
              <div>
                <label for="caso-recaudado">Monto Recaudado</label>
                <input type="number" id="caso-recaudado" name="Caso_Monto_Recaudado">
              </div>
            </div>

            <div id="campos-recursos" style="display:none;">
              <label for="caso-punto">Punto de Recolección</label>
              <input type="text" id="caso-punto" name="Caso_Punto_Recoleccion">
            </div>

            <div>
              <label for="caso-fecha-inicio">Fecha Inicio</label>
              <input type="date" id="caso-fecha-inicio" name="Caso_Fecha_Inicio" required>
            </div>

            <div>
              <label for="caso-fecha-fin">Fecha Fin</label>
              <input type="date" id="caso-fecha-fin" name="Caso_Fecha_Fin" required>
            </div>

            <div>
              <label for="caso-estado">Estado</label>
              <select id="caso-estado" name="Caso_Estado">
                <option value="Abierto">Abierto</option>
                <option value="Cerrado">Cerrado</option>
              </select>
            </div>

            <div>
              <label for="caso-cat">Categoría</label>
              <input type="text" id="caso-cat" name="Caso_Cat_Nombre">
            </div>

            <div class="acciones-form">
              <button type="button" id="btn-cancelar-caso"><i class="fas fa-times"></i> Cancelar</button>
              <button type="submit"><i class="fas fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>

        <!-- Filtro y Listados -->
        <div class="search-bar">
          <input type="text" id="filtro-casos" placeholder="Buscar caso por ID o nombre">
          <button id="btn-filtrar-casos"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        <div id="lista-casos-dinero"></div>
        <hr>
        <div id="lista-casos-recursos"></div>
      </section>

      <!-- Otras secciones omitidas -->
    </main>
  </div>

  <script>
    // Datos globales
    let casosDineroData = [], casosRecursosData = [];

    // Manejo de navegación (igual que antes)
    const secciones = {
      'perfil-link':'perfil',
      'casos-link':'casos',
      'crear-caso-link':'crearCaso',
      'voluntarios-link':'voluntarios',
      'historial-link':'historial',
      'ayuda-link':'ayuda'
    };
    document.querySelectorAll('.menu a').forEach(a=>{
      a.addEventListener('click', e=>{
        e.preventDefault();
        document.querySelectorAll('main section').forEach(sec=>{
          sec.classList.add('seccion-oculta');
          sec.classList.remove('seccion-activa');
        });
        const sel = secciones[e.currentTarget.id];
        document.getElementById(sel).classList.replace('seccion-oculta','seccion-activa');
        document.getElementById('titulo-seccion').innerText = e.currentTarget.textContent.trim();
        document.querySelectorAll('.menu a').forEach(x=>x.classList.remove('active'));
        e.currentTarget.classList.add('active');
        if(sel==='casos'){
          cargarCasosDinero();
          cargarCasosRecursos();
        }
      });
    });

    // — Mostrar/ocultar y llenar formulario de caso —
    const formCaso      = document.getElementById('form-caso');
    const casoForm      = document.getElementById('caso-form');
    const tipoSelect    = document.getElementById('caso-tipo-select');
    const hiddenTipo    = document.getElementById('caso-tipo');
    const camposDinero  = document.getElementById('campos-dinero');
    const camposRecursos= document.getElementById('campos-recursos');

    document.getElementById('btn-agregar-caso').addEventListener('click', ()=>{
      casoForm.reset();
      document.getElementById('caso-id').value = '';
      hiddenTipo.value = 'dinero';
      tipoSelect.value  = 'dinero';
      document.getElementById('form-caso-titulo').innerText = 'Agregar Caso';
      showCampos('dinero');
      formCaso.style.display = 'block';
    });

    document.getElementById('btn-cancelar-caso')
      .addEventListener('click', ()=> formCaso.style.display='none');

    tipoSelect.addEventListener('change', e=>{
      hiddenTipo.value = e.target.value;
      showCampos(e.target.value);
    });

    function showCampos(tipo){
      camposDinero.style.display   = tipo==='dinero' ? 'block' : 'none';
      camposRecursos.style.display = tipo==='recurso' ? 'block' : 'none';
    }

    // — Crear / Actualizar Caso —
    casoForm.addEventListener('submit', e=>{
      e.preventDefault();
      const fd   = new FormData(casoForm);
      const tipo = fd.get('tipo'); 
      const isUpdate = fd.get('Caso_Id').trim() !== '';
      let url;
      if(tipo==='dinero'){
        url = isUpdate
          ? '/Pantry_Amigo/MVC/Vista/HTML/update_caso_dinero.php'
          : '/Pantry_Amigo/MVC/Vista/HTML/add_caso_dinero.php';
      } else {
        url = isUpdate
          ? '/Pantry_Amigo/MVC/Vista/HTML/update_caso_recurso.php'
          : '/Pantry_Amigo/MVC/Vista/HTML/add_caso_recurso.php';
      }

      fetch(url, { method:'POST', body: fd })
        .then(r=>r.json())
        .then(d=>{
          alert(d.message);
          formCaso.style.display='none';
          cargarCasosDinero();
          cargarCasosRecursos();
        })
        .catch(err=>alert('Error: '+err.message));
    });

    // — Casos de Dinero —
    function cargarCasosDinero(){
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_dinero.php')
        .then(r=>r.json())
        .then(data=>{
          casosDineroData = data.error?[]:data;
          renderCasosDinero(casosDineroData);
        })
        .catch(err=>{
          document.getElementById('lista-casos-dinero').innerHTML = `<p>Error: ${err.message}</p>`;
        });
    }
    function renderCasosDinero(list){
      const c = document.getElementById('lista-casos-dinero');
      c.innerHTML = '<h4>Casos de Dinero</h4>';
      list.forEach(ci=>{
        const d = document.createElement('div');
        d.className = 'caso';
        d.innerHTML = `
          <h4>${ci.Caso_Nombre} (${ci.Caso_Id})</h4>
          <p>${ci.Caso_Descripcion}</p>
          <p><strong>Meta:</strong> ${ci.Caso_Monto_Meta} • <strong>Recaudado:</strong> ${ci.Caso_Monto_Recaudado}</p>
          <p><strong>Fechas:</strong> ${ci.Caso_Fecha_Inicio} → ${ci.Caso_Fecha_Fin}</p>
          <p><strong>Estado:</strong> ${ci.Caso_Estado}</p>
          <div class="acciones">
            <button onclick="editarCaso('dinero', ${ci.Caso_Id})">
              <i class="fas fa-edit"></i> Actualizar
            </button>
            <button onclick="eliminarCasoDinero(${ci.Caso_Id})">
              <i class="fas fa-trash-alt"></i> Eliminar
            </button>
          </div>`;
        c.appendChild(d);
      });
    }
    function editarCaso(tipo, id){
      const data = (tipo==='dinero')
        ? casosDineroData.find(x=>x.Caso_Id===id)
        : casosRecursosData.find(x=>x.Caso_Id===id);
      if(!data) return alert('Caso no encontrado');
      // Llenar formulario
      document.getElementById('caso-id').value          = data.Caso_Id;
      document.getElementById('caso-nombre').value      = data.Caso_Nombre;
      document.getElementById('caso-desc').value        = data.Caso_Descripcion;
      hiddenTipo.value = tipo;
      tipoSelect.value  = tipo;
      document.getElementById('form-caso-titulo').innerText = 'Actualizar Caso';
      if(tipo==='dinero'){
        document.getElementById('caso-meta').value       = data.Caso_Monto_Meta;
        document.getElementById('caso-recaudado').value  = data.Caso_Monto_Recaudado;
      } else {
        document.getElementById('caso-punto').value      = data.Caso_Punto_Recoleccion;
      }
      document.getElementById('caso-fecha-inicio').value = data.Caso_Fecha_Inicio;
      document.getElementById('caso-fecha-fin').value    = data.Caso_Fecha_Fin;
      document.getElementById('caso-estado').value       = data.Caso_Estado;
      document.getElementById('caso-cat').value          = data.Caso_Cat_Nombre;
      showCampos(tipo);
      formCaso.style.display = 'block';
    }
    function eliminarCasoDinero(id){
      if(!confirm('¿Eliminar este caso de dinero?'))return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_dinero.php?id=${id}`)
        .then(r=>r.json())
        .then(d=>{ alert(d.message); if(d.success) cargarCasosDinero(); });
    }

    // — Casos de Recursos —
    function cargarCasosRecursos(){
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_recursos.php')
        .then(r=>r.json())
        .then(data=>{
          casosRecursosData = data.error?[]:data;
          renderCasosRecursos(casosRecursosData);
        })
        .catch(err=>{ document.getElementById('lista-casos-recursos').innerHTML = `<p>Error: ${err.message}</p>`; });
    }
    function renderCasosRecursos(list){
      const c = document.getElementById('lista-casos-recursos');
      c.innerHTML = '<h4>Casos de Recursos</h4>';
      list.forEach(cr=>{
        const d = document.createElement('div');
        d.className = 'caso';
        d.innerHTML = `
          <h4>${cr.Caso_Nombre} (${cr.Caso_Id})</h4>
          <p>${cr.Caso_Descripcion}</p>
          <p><strong>Fechas:</strong> ${cr.Caso_Fecha_Inicio} → ${cr.Caso_Fecha_Fin}</p>
          <p><strong>Estado:</strong> ${cr.Caso_Estado}</p>
          <p><strong>Punto:</strong> ${cr.Caso_Punto_Recoleccion}</p>
          <div class="acciones">
            <button onclick="editarCaso('recurso', ${cr.Caso_Id})">
              <i class="fas fa-edit"></i> Actualizar
            </button>
            <button onclick="eliminarCasoRecurso(${cr.Caso_Id})">
              <i class="fas fa-trash-alt"></i> Eliminar
            </button>
          </div>`;
        c.appendChild(d);
      });
    }
    function eliminarCasoRecurso(id){
      if(!confirm('¿Eliminar este caso de recurso?'))return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_recurso.php?id=${id}`)
        .then(r=>r.json())
        .then(d=>{ alert(d.message); if(d.success) cargarCasosRecursos(); });
    }

    // Filtrar Casos
    document.getElementById('btn-filtrar-casos').addEventListener('click', ()=>{
      const filtro = document.getElementById('filtro-casos').value.trim().toLowerCase();
      renderCasosDinero(casosDineroData.filter(ci=>
        ci.Caso_Id.toString().includes(filtro) ||
        ci.Caso_Nombre.toLowerCase().includes(filtro)
      ));
      renderCasosRecursos(casosRecursosData.filter(cr=>
        cr.Caso_Id.toString().includes(filtro) ||
        cr.Caso_Nombre.toLowerCase().includes(filtro)
      ));
    });

  </script>
</body>
</html>
