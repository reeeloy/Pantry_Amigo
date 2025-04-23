<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/fundacion_dashboard.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    /* ===== Formularios ===== */
    .form-caso {
      display: none; background: #fff; border: 1px solid #ccc;
      padding: 1em; border-radius: 6px; margin-bottom: 1em;
    }
    .form-caso h4 { margin-top:0; color:#2b577d; }
    .form-caso div { margin-bottom:.8em; }
    .form-caso label { font-weight:bold; margin-bottom:.3em; display:block; }
    .form-caso input, .form-caso select, .form-caso textarea {
      width:100%; padding:.6em; border:1px solid #ccc; border-radius:4px;
    }
    .form-caso .acciones-form { text-align:right; }
    .form-caso .acciones-form button { padding:.6em 1em; margin-left:.5em; }
    /* ===== Botones ===== */
    #btn-agregar-caso {
      background:#7ec8a1; color:#fff; border:none;
      padding:.6em 1em; border-radius:4px; cursor:pointer;
      margin-bottom:1em;
    }
    #btn-agregar-caso:hover { background:#65b28a; }
    /* ===== Tarjeta de Caso ===== */
    .caso {
      background:#f8f9fa; padding:1em; margin-bottom:.8em;
      border-radius:6px; box-shadow:0 2px 4px rgba(0,0,0,0.1);
    }
    .caso h4 { margin:0 0 .5em; color:#2b577d; }
    .caso p { margin:.4em 0; color:#333; }
    /* Sólo en sección “Casos” */
    section#casos .caso .acciones {
      margin-top:.6em; display:flex; gap:.5em;
    }
    section#casos .caso .acciones button {
      padding:4px 8px; font-size:.8em; border:none; border-radius:4px; cursor:pointer;
      transition:background .2s;
    }
    section#casos .caso .acciones button:first-child {
      background:#2b577d; color:#fff;
    }
    section#casos .caso .acciones button:last-child {
      background:#e74c3c; color:#fff;
    }
    section#casos .caso .acciones button:first-child:hover {
      background:#1e3f5c;
    }
    section#casos .caso .acciones button:last-child:hover {
      background:#c0392b;
    }
    /* ===== Barra de búsqueda ===== */
    .search-bar { margin:15px 0; display:flex; gap:10px; }
    .search-bar input {
      flex:1; padding:8px; border:1px solid #ccc; border-radius:5px;
    }
    .search-bar button {
      padding:8px 12px; background:#2b577d; color:#fff; border:none;
      border-radius:5px; cursor:pointer; transition:background .2s;
    }
    .search-bar button:hover { background:#1f3e5b; }
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
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <h2 id="titulo-seccion">Perfil</h2>
      </header>

      <!-- PERFIL -->
      <section id="perfil" class="seccion-activa">
        <p>Bienvenido a tu dashboard, aquí verás la información de tu fundación.</p>
      </section>

      <!-- CASOS -->
      <section id="casos" class="seccion-oculta">
        <h3>Casos de Donación</h3>

        <!-- Formulario INLINE de actualización -->
        <div id="form-editar-caso" class="form-caso">
          <h4>Actualizar Caso</h4>
          <form id="editar-caso-form">
            <input type="hidden" name="Caso_Id" id="edit-caso-id">
            <input type="hidden" name="Caso_Fund_Id" value="<?php echo $_SESSION['id_fundacion']; ?>">
            <div><label><strong>ID:</strong></label><input type="text" id="edit-caso-id-display" readonly></div>
            <div><label for="edit-caso-nombre"><strong>Nombre:</strong></label><input type="text" id="edit-caso-nombre" name="Caso_Nombre" required></div>
            <div><label for="edit-caso-desc"><strong>Descripción:</strong></label><textarea id="edit-caso-desc" name="Caso_Descripcion" required></textarea></div>
            <div><label for="edit-caso-meta"><strong>Meta:</strong></label><input type="number" id="edit-caso-meta" name="Caso_Monto_Meta" required></div>
            <div><label for="edit-caso-recaudado"><strong>Recaudado:</strong></label><input type="number" id="edit-caso-recaudado" name="Caso_Monto_Recaudado" required></div>
            <div><label for="edit-caso-fecha-inicio"><strong>Inicio:</strong></label><input type="date" id="edit-caso-fecha-inicio" name="Caso_Fecha_Inicio" required></div>
            <div><label for="edit-caso-fecha-fin"><strong>Fin:</strong></label><input type="date" id="edit-caso-fecha-fin" name="Caso_Fecha_Fin" required></div>
            <div><label for="edit-caso-estado"><strong>Estado:</strong></label><select id="edit-caso-estado" name="Caso_Estado" required>
              <option value="Activo">Activo</option><option value="Inactivo">Inactivo</option>
            </select></div>
            <div><label for="edit-caso-vol"><strong>Voluntariado:</strong></label><input type="number" id="edit-caso-vol" name="Caso_Voluntariado" min="0" required></div>
            <div><label for="edit-caso-cat"><strong>Categoría:</strong></label><input type="text" id="edit-caso-cat" name="Caso_Cat_Nombre" required></div>
            <div class="acciones-form">
              <button type="button" id="btn-cancelar-editar"><i class="fas fa-times"></i> Cancelar</button>
              <button type="submit"><i class="fas fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>

        <!-- Búsqueda -->
        <div class="search-bar">
          <input type="text" id="filtro-casos" placeholder="Buscar caso por ID o nombre">
          <button id="btn-filtrar-casos"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        <!-- Listado -->
        <div id="lista-casos-dinero"></div>
      </section>

      <!-- CREAR CASO -->
      <section id="crearCaso" class="seccion-oculta">
        <h3>Crear Caso</h3>
        <button id="btn-agregar-caso"><i class="fas fa-plus"></i> Añadir Caso</button>
        <div id="form-crear-caso" class="form-caso">
          <h4>Agregar Caso</h4>
          <form id="crear-caso-form">
            <input type="hidden" name="Caso_Fund_Id" value="<?php echo $_SESSION['id_fundacion']; ?>">
            <div><label for="new-caso-nombre"><strong>Nombre:</strong></label><input type="text" id="new-caso-nombre" name="Caso_Nombre" required></div>
            <div><label for="new-caso-desc"><strong>Descripción:</strong></label><textarea id="new-caso-desc" name="Caso_Descripcion" required></textarea></div>
            <div><label for="new-caso-meta"><strong>Meta:</strong></label><input type="number" id="new-caso-meta" name="Caso_Monto_Meta" required></div>
            <div><label for="new-caso-recaudado"><strong>Recaudado:</strong></label><input type="number" id="new-caso-recaudado" name="Caso_Monto_Recaudado" required></div>
            <div><label for="new-caso-fecha-inicio"><strong>Inicio:</strong></label><input type="date" id="new-caso-fecha-inicio" name="Caso_Fecha_Inicio" required></div>
            <div><label for="new-caso-fecha-fin"><strong>Fin:</strong></label><input type="date" id="new-caso-fecha-fin" name="Caso_Fecha_Fin" required></div>
            <div><label for="new-caso-estado"><strong>Estado:</strong></label><select id="new-caso-estado" name="Caso_Estado" required>
              <option value="Activo">Activo</option><option value="Inactivo">Inactivo</option>
            </select></div>
            <div><label for="new-caso-vol"><strong>Voluntariado:</strong></label><input type="number" id="new-caso-vol" name="Caso_Voluntariado" min="0" required></div>
            <div><label for="new-caso-cat"><strong>Categoría:</strong></label><input type="text" id="new-caso-cat" name="Caso_Cat_Nombre" required></div>
            <div class="acciones-form">
              <button type="button" id="btn-cancelar-crear"><i class="fas fa-times"></i> Cancelar</button>
              <button type="submit"><i class="fas fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
        <div class="search-bar">
          <input type="text" id="filtro-casos-crear" placeholder="Buscar caso por ID o nombre">
          <button id="btn-filtrar-casos-crear"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        <div id="lista-casos-dinero-crear"></div>
      </section>
    </main>
  </div>

  <script>
    let casosDineroData = [];

    // Pestañas
    const secciones = {
      'perfil-link':'perfil',
      'casos-link':'casos',
      'crear-caso-link':'crearCaso'
    };
    document.querySelectorAll('.menu a').forEach(a=>{
      a.addEventListener('click', e=>{
        e.preventDefault();
        Object.values(secciones).forEach(sec=>{
          document.getElementById(sec).classList.add('seccion-oculta');
          document.getElementById(sec).classList.remove('seccion-activa');
        });
        const sel = secciones[e.currentTarget.id];
        document.getElementById(sel).classList.replace('seccion-oculta','seccion-activa');
        document.getElementById('titulo-seccion').innerText = e.currentTarget.textContent.trim();
        document.querySelectorAll('.menu a').forEach(x=>x.classList.remove('active'));
        e.currentTarget.classList.add('active');
        if (sel==='casos' || sel==='crearCaso') cargarCasosDinero();
      });
    });

    // EDICIÓN INLINE
    const formEditar = document.getElementById('form-editar-caso');
    const editarForm = document.getElementById('editar-caso-form');
    document.getElementById('btn-cancelar-editar').addEventListener('click', ()=>formEditar.style.display='none');
    editarForm.addEventListener('submit', e=>{
      e.preventDefault();
      const fd = new FormData(editarForm);
      console.log(Object.fromEntries(fd.entries())); // mira qué envías
      fetch('/Pantry_Amigo/MVC/Vista/HTML/update_caso_dinero.php', {
        method:'POST', body: fd
      })
      .then(r=>r.json())
      .then(d=>{
        alert(d.message);
        formEditar.style.display='none';
        cargarCasosDinero();
      })
      .catch(err=>alert('Error de red: '+err.message));
    });

    // CREACIÓN
    const formCrear = document.getElementById('form-crear-caso');
    const crearForm = document.getElementById('crear-caso-form');
    document.getElementById('btn-agregar-caso').addEventListener('click', ()=>formCrear.style.display='block');
    document.getElementById('btn-cancelar-crear').addEventListener('click', ()=>formCrear.style.display='none');
    crearForm.addEventListener('submit', e=>{
      e.preventDefault();
      const fd = new FormData(crearForm);
      console.log('crear→', Object.fromEntries(fd.entries())); // mira qué envías
      fetch('/Pantry_Amigo/MVC/Vista/HTML/add_caso_dinero.php', {
        method:'POST', body: fd
      })
      .then(r=>r.json())
      .then(d=>{
        alert(d.message);
        formCrear.style.display='none';
        cargarCasosDinero();
      })
      .catch(err=>alert('Error de red: '+err.message));
    });

    // Carga + render
    function cargarCasosDinero(){
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_dinero.php')
        .then(r=>r.json())
        .then(data=>{
          casosDineroData = data.error?[]:data;
          renderCasos(casosDineroData,'lista-casos-dinero',true);
          renderCasos(casosDineroData,'lista-casos-dinero-crear',false);
        })
        .catch(err=> document.getElementById('lista-casos-dinero').innerHTML = `<p>Error: ${err.message}</p>`);
    }
    function renderCasos(list, containerId, withActions){
      const cont = document.getElementById(containerId);
      cont.innerHTML = '<h4>Casos de Dinero</h4>';
      list.forEach(ci=>{
        const card = document.createElement('div');
        card.className='caso';
        let html = `
          <h4>${ci.Caso_Nombre} (${ci.Caso_Id})</h4>
          <p>${ci.Caso_Descripcion}</p>
          <p><strong>Meta:</strong> ${ci.Caso_Monto_Meta} • <strong>Recaudado:</strong> ${ci.Caso_Monto_Recaudado}</p>
          <p><strong>Inicio:</strong> ${ci.Caso_Fecha_Inicio} • <strong>Fin:</strong> ${ci.Caso_Fecha_Fin}</p>
          <p><strong>Estado:</strong> ${ci.Caso_Estado} • <strong>Categoría:</strong> ${ci.Caso_Cat_Nombre}</p>`;
        if(withActions){
          html += `
            <div class="acciones">
              <button onclick="openEditar(${ci.Caso_Id})"><i class="fas fa-edit"></i> Actualizar</button>
              <button onclick="eliminarCaso(${ci.Caso_Id})"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </div>`;
        }
        card.innerHTML = html;
        cont.appendChild(card);
      });
    }

    // Abre inline-edit
    function openEditar(id){
      const d = casosDineroData.find(x=> x.Caso_Id===id);
      if(!d) return alert('Caso no encontrado');
      document.getElementById('edit-caso-id').value         = d.Caso_Id;
      document.getElementById('edit-caso-id-display').value = d.Caso_Id;
      document.getElementById('edit-caso-nombre').value     = d.Caso_Nombre;
      document.getElementById('edit-caso-desc').value       = d.Caso_Descripcion;
      document.getElementById('edit-caso-meta').value       = d.Caso_Monto_Meta;
      document.getElementById('edit-caso-recaudado').value  = d.Caso_Monto_Recaudado;
      document.getElementById('edit-caso-fecha-inicio').value = d.Caso_Fecha_Inicio;
      document.getElementById('edit-caso-fecha-fin').value    = d.Caso_Fecha_Fin;
      document.getElementById('edit-caso-estado').value     = d.Caso_Estado;
      document.getElementById('edit-caso-vol').value        = d.Caso_Voluntariado;
      document.getElementById('edit-caso-cat').value        = d.Caso_Cat_Nombre;
      formEditar.style.display = 'block';
    }

    // Eliminar
    function eliminarCaso(id){
      if(!confirm('¿Eliminar este caso?')) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_dinero.php?id=${id}`)
        .then(r=>r.json()).then(_=> cargarCasosDinero());
    }

    // Filtrar en ambas
    document.getElementById('btn-filtrar-casos').addEventListener('click', ()=>{
      const t = document.getElementById('filtro-casos').value.trim().toLowerCase();
      renderCasos(casosDineroData.filter(ci=>
        ci.Caso_Id.toString().includes(t) ||
        ci.Caso_Nombre.toLowerCase().includes(t)
      ), 'lista-casos-dinero', true);
    });
    document.getElementById('btn-filtrar-casos-crear').addEventListener('click', ()=>{
      const t = document.getElementById('filtro-casos-crear').value.trim().toLowerCase();
      renderCasos(casosDineroData.filter(ci=>
        ci.Caso_Id.toString().includes(t) ||
        ci.Caso_Nombre.toLowerCase().includes(t)
      ), 'lista-casos-dinero-crear', false);
    });

    // Inicio
    window.onload = cargarCasosDinero;
  </script>
</body>
</html>
