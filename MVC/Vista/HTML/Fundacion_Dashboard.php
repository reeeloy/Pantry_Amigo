<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Si no hay sesión iniciada, redirige al login
if (!isset($_SESSION['Usu_Id']) || $_SESSION['tipo'] !== 'fundacion') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/fundacion_dashboard.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    /* ==== Secciones Ocultas ==== */
    .seccion-oculta { display: none; }

    /* ==== Search Bar ==== */
    .search-bar { margin:15px 0; display:flex; gap:10px; }
    .search-bar input {
      flex:1; padding:8px; border:1px solid #ccc; border-radius:5px;
    }
    .search-bar button {
      padding:8px 12px; background:#2b577d; color:#fff;
      border:none; border-radius:5px; cursor:pointer; transition:background .2s;
    }
    .search-bar button:hover { background:#1f3f5c; }

    /* ==== Casos ==== */
    .caso {
      background:#f8f9fa; padding:1em; margin-bottom:.8em;
      border-radius:6px; box-shadow:0 2px 4px rgba(0,0,0,.1);
    }
    .caso h4 { margin:0 0 .5em; color:#2b577d; }
    .caso p { margin:.4em 0; color:#333; }
    section#casos .caso .acciones {
      margin-top:.6em; display:flex; gap:.5em;
    }
    section#casos .caso .acciones button {
      padding:4px 8px; font-size:.8em; border:none;
      border-radius:4px; cursor:pointer; color:#fff; transition:background .2s;
    }
    section#casos .caso .acciones .update { background:#2b577d; }
    section#casos .caso .acciones .delete { background:#e74c3c; }
    section#casos .caso .acciones .update:hover { background:#1f3f5c; }
    section#casos .caso .acciones .delete:hover { background:#c0392b; }

    /* ==== Formulario Inline Editar Caso ==== */
    #form-editar-caso {
      display:none; background:#fff; border:1px solid #ccc;
      padding:1em; border-radius:6px; margin-bottom:1em;
    }
    #form-editar-caso h4 { margin-top:0; color:#2b577d; }
    #form-editar-caso div { margin-bottom:.8em; }
    #form-editar-caso label {
      display:block; font-weight:bold; margin-bottom:.3em;
    }
    #form-editar-caso input,
    #form-editar-caso select,
    #form-editar-caso textarea {
      width:100%; padding:.6em; border:1px solid #ccc; border-radius:4px;
    }
    #form-editar-caso .acciones-form {
      text-align:right;
    }
    #form-editar-caso .acciones-form button {
      padding:.6em 1em; margin-left:.5em; cursor:pointer;
    }

    /* ==== Botón Crear Caso ==== */
    .boton-crear-caso {
      display:inline-block; padding:10px 15px; background:var(--verde-claro);
      color:var(--azul-oscuro); border-radius:5px; text-decoration:none;
      font-weight:bold; margin-top:1em; transition:background .2s;
    }
    .boton-crear-caso:hover { background:#65b28a; }

    /* ==== Voluntarios ==== */
    .voluntario {
      background:#f8f9fa; padding:1em; margin-bottom:.8em;
      border-radius:6px; box-shadow:0 2px 4px rgba(0,0,0,.1);
    }
    .voluntario h4 { margin:0 0 .5em; color:#2b577d; }
    .voluntario p { margin:.4em 0; color:#333; }
    section#voluntarios .voluntario .acciones {
      margin-top:.6em; display:flex; gap:.5em;
    }
    section#voluntarios .voluntario .acciones button {
      padding:4px 8px; font-size:.8em; border:none;
      border-radius:4px; cursor:pointer; color:#fff; transition:background .2s;
    }
    section#voluntarios .voluntario .acciones .delete-vol { background:#e74c3c; }
    section#voluntarios .voluntario .acciones .assign-hor { background:#2b577d; }
    section#voluntarios .voluntario .acciones .delete-vol:hover { background:#c0392b; }
    section#voluntarios .voluntario .acciones .assign-hor:hover { background:#1f3f5c; }
    .voluntario .horarios {
      background:#f0f0f0; color:#333;
      margin-top:.5em; padding:.5em; border-left:2px solid #2b577d;
      border-radius:4px;
    }
    .voluntario .horarios li { margin-bottom:.3em; }

    /* ==== Inline Asignar Horario ==== */
    #form-asignar-horario {
      display:none; background:#fff; border:1px solid #ccc;
      padding:1em; border-radius:6px; margin:1em 0;
    }
    #form-asignar-horario h4 { margin-top:0; color:#2b577d; }
    #form-asignar-horario div { margin-bottom:.8em; }
    #form-asignar-horario label {
      display:block; font-weight:bold; margin-bottom:.3em;
    }
    #form-asignar-horario input {
      width:100%; padding:.6em; border:1px solid #ccc; border-radius:4px;
    }
    #form-asignar-horario .acciones-form {
      text-align:right;
    }
    #form-asignar-horario .acciones-form button {
      padding:.6em 1em; margin-left:.5em; cursor:pointer;
    }

    /* ==== Ayuda ==== */
    #ayuda h3 { color:#2b577d; }
    #ayuda h4 { margin-top:1em; }
    #ayuda ul { margin-left:1.2em; }
    #ayuda ul li { margin-bottom:.5em; }
    #ayuda p { margin:.6em 0; }
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
        <a href="#" id="ayuda-link"><i class="fas fa-question-circle"></i> Ayuda</a>
        <!-- Enlace a logout.php -->
        <a href="logout.php" id="cerrar-sesion-link"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
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
        <!-- Inline Edit Form -->
        <div id="form-editar-caso">
          <h4>Actualizar Caso</h4>
          <form id="editar-caso-form">
            <input type="hidden" name="Caso_Id" id="edit-caso-id">
            <input type="hidden" name="Caso_Fund_Id" value="<?php echo $_SESSION['Usu_Id']; ?>">
            <div><label>Nombre:</label><input type="text" name="Caso_Nombre" id="edit-caso-nombre" required></div>
            <div><label>Descripción:</label><textarea name="Caso_Descripcion" id="edit-caso-desc" required></textarea></div>
            <div><label>Meta:</label><input type="number" name="Caso_Monto_Meta" id="edit-caso-meta" required></div>
            <div><label>Recaudado:</label><input type="number" name="Caso_Monto_Recaudado" id="edit-caso-recaudado" required></div>
            <div><label>Fecha Inicio:</label><input type="date" name="Caso_Fecha_Inicio" id="edit-caso-inicio" required></div>
            <div><label>Fecha Fin:</label><input type="date" name="Caso_Fecha_Fin" id="edit-caso-fin" required></div>
            <div>
              <label>Estado:</label>
              <select name="Caso_Estado" id="edit-caso-estado">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
            </div>
            <div><label>Voluntariado:</label><input type="number" name="Caso_Voluntariado" id="edit-caso-vol" min="0" required></div>
            <div><label>Categoría:</label><input type="text" name="Caso_Cat_Nombre" id="edit-caso-cat" required></div>
            <div class="acciones-form">
              <button type="button" id="btn-cancelar-caso"><i class="fas fa-times"></i> Cancelar</button>
              <button type="submit"><i class="fas fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>

        <!-- Search & List -->
        <div class="search-bar">
          <input type="text" id="filtro-casos" placeholder="Buscar caso por ID o nombre">
          <button id="btn-filtrar-casos"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        <div id="lista-casos-dinero"></div>
      </section>

      <!-- CREAR CASO -->
      <section id="crearCaso" class="seccion-oculta">
        <h3>Crear Caso</h3>
        <a href="/Pantry_Amigo/MVC/Vista/HTML/RegistrarCasoDinero.php" class="boton-crear-caso">
          <i class="fas fa-plus"></i> Registrar Caso de Dinero
        </a>
      </section>

      <!-- VOLUNTARIOS -->
      <section id="voluntarios" class="seccion-oculta">
        <div class="search-bar">
          <input type="text" id="filtro-voluntarios" placeholder="Buscar por cédula o nombre">
          <button id="btn-filtrar-voluntarios"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
        <div id="form-asignar-horario">
          <h4>Asignar Horario</h4>
          <form id="horario-form">
            <input type="hidden" name="Hora_Vol_Cedula" id="hor-vol-cedula">
            <div><label>Hora Citación</label><input type="datetime-local" name="Hora_Citacion" id="hor-citacion" required></div>
            <div><label>Localización</label><input type="text" name="Hora_Localizacion" id="hor-localizacion" required></div>
            <div class="acciones-form">
              <button type="button" id="btn-cancelar-hor"><i class="fas fa-times"></i> Cancelar</button>
              <button type="submit"><i class="fas fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
        <div id="lista-voluntarios"></div>
      </section>

      <!-- AYUDA -->
      <section id="ayuda" class="seccion-oculta">
        <h3>Ayuda / Soporte</h3>
        <h4>Preguntas Frecuentes</h4>
        <ul>
          <li><strong>¿Cómo creo un nuevo caso?</strong> Ve a "Crear Caso" y completa el formulario.</li>
          <li><strong>¿Cómo actualizo un caso?</strong> En "Casos", pulsa "Actualizar" sobre el caso deseado.</li>
          <li><strong>¿Cómo asigno voluntarios?</strong> En "Voluntarios", pulsa "Asignar horario".</li>
        </ul>
        <h4>Contacto</h4>
        <p><i class="fas fa-envelope"></i> soporte@pantryamigo.org</p>
        <p><i class="fas fa-phone"></i> +57 123 456 7890</p>
      </section>
    </main>
  </div>

  <script>
    let casosDineroData = [], voluntariosData = [], horariosData = [];

    const secciones = {
      'perfil-link':'perfil',
      'casos-link':'casos',
      'crear-caso-link':'crearCaso',
      'voluntarios-link':'voluntarios',
      'ayuda-link':'ayuda'
    };

    // Navegación
    document.querySelectorAll('.menu a').forEach(a=>{
      a.addEventListener('click', e=>{
        const id = e.currentTarget.id;
        if (id === 'cerrar-sesion-link') {
          // no interceptar
          return;
        }
        e.preventDefault();
        if (id === 'crear-caso-link') {
          window.location.href = '/Pantry_Amigo/MVC/Vista/HTML/RegistrarCasoDinero.php';
          return;
        }
        Object.values(secciones).forEach(sec=>
          document.getElementById(sec).classList.replace('seccion-activa','seccion-oculta')
        );
        const sel = secciones[id];
        document.getElementById(sel).classList.replace('seccion-oculta','seccion-activa');
        document.getElementById('titulo-seccion').innerText = e.currentTarget.textContent.trim();
        document.querySelectorAll('.menu a').forEach(x=>x.classList.remove('active'));
        e.currentTarget.classList.add('active');
        if (sel==='casos') cargarCasos();
        if (sel==='voluntarios') cargarVoluntarios();
      });
    });

    // — Inline editar Caso —
    const formEditar  = document.getElementById('form-editar-caso'),
          editarForm  = document.getElementById('editar-caso-form');
    document.getElementById('btn-cancelar-caso').addEventListener('click', ()=> formEditar.style.display='none');

    editarForm.addEventListener('submit', e=>{
      e.preventDefault();
      const fd = new FormData(editarForm);
      fetch('/Pantry_Amigo/MVC/Vista/HTML/update_caso_dinero.php', {
        method:'POST', body: fd
      })
      .then(res=>res.json())
      .then(o=>{
        alert(o.message);
        formEditar.style.display='none';
        cargarCasos();
      })
      .catch(err=>alert('Error de red: '+err));
    });

    function cargarCasos(){
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_dinero.php')
        .then(r=>r.json())
        .then(data=>{
          casosDineroData = data.error?[]:data;
          renderCasos(casosDineroData);
        });
    }
    function renderCasos(list){
      const cont = document.getElementById('lista-casos-dinero');
      cont.innerHTML = '<h4>Casos de Dinero</h4><br>';
      list.forEach(ci=>{
        const d = document.createElement('div'); d.className='caso';
        d.innerHTML = `
          <h4>${ci.Caso_Nombre} (${ci.Caso_Id})</h4>
          <p>${ci.Caso_Descripcion}</p>
          <p><strong>Meta:</strong> ${ci.Caso_Monto_Meta} • <strong>Recaudado:</strong> ${ci.Caso_Monto_Recaudado}</p>
          <p><strong>Inicio:</strong> ${ci.Caso_Fecha_Inicio} • <strong>Fin:</strong> ${ci.Caso_Fecha_Fin}</p>
          <p><strong>Estado:</strong> ${ci.Caso_Estado} • <strong>Categoría:</strong> ${ci.Caso_Cat_Nombre}</p>
          <div class="acciones">
            <button class="update" onclick="openEditar(${ci.Caso_Id})"><i class="fas fa-edit"></i> Actualizar</button>
            <button class="delete" onclick="eliminarCaso(${ci.Caso_Id})"><i class="fas fa-trash-alt"></i> Eliminar</button>
          </div>`;
        cont.appendChild(d);
      });
    }
    document.getElementById('btn-filtrar-casos')
      .addEventListener('click', ()=>{
        const t = document.getElementById('filtro-casos').value.trim().toLowerCase();
        renderCasos(casosDineroData.filter(ci=>
          ci.Caso_Id.toString().includes(t) ||
          ci.Caso_Nombre.toLowerCase().includes(t)
        ));
      });

    function openEditar(id){
      const data = casosDineroData.find(c=>c.Caso_Id===id);
      if (!data) return alert('Caso no encontrado');
      document.getElementById('edit-caso-id').value        = data.Caso_Id;
      document.getElementById('edit-caso-nombre').value    = data.Caso_Nombre;
      document.getElementById('edit-caso-desc').value      = data.Caso_Descripcion;
      document.getElementById('edit-caso-meta').value      = data.Caso_Monto_Meta;
      document.getElementById('edit-caso-recaudado').value = data.Caso_Monto_Recaudado;
      document.getElementById('edit-caso-inicio').value    = data.Caso_Fecha_Inicio;
      document.getElementById('edit-caso-fin').value       = data.Caso_Fecha_Fin;
      document.getElementById('edit-caso-estado').value    = data.Caso_Estado;
      document.getElementById('edit-caso-vol').value       = data.Caso_Voluntariado;
      document.getElementById('edit-caso-cat').value       = data.Caso_Cat_Nombre;
      formEditar.style.display = 'block';
      formEditar.scrollIntoView({ behavior:'smooth', block:'start' });
    }
    function eliminarCaso(id){
      if (!confirm('¿Eliminar este caso?')) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_dinero.php?id=${id}`)
        .then(r=>r.json()).then(_=> cargarCasos());
    }

    // — Resto de Voluntarios / Ayuda … ignorado para brevedad …

    // Al arrancar, cargo casos
    window.onload = () => cargarCasos();
  </script>
</body>
</html>
