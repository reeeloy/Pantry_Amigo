<?php
// Inicio de sesión y configuración de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Validar si el usuario está logueado
if (!isset($_SESSION['Usu_Id'])) {
    header('Location: /Pantry_Amigo/MVC/Vista/HTML/login.php');
    exit;
}

// Cargar modelo de fundación
include_once '../../Modelo/ConexionBD.php';
include_once '../../Modelo/fundacionModelo.php';

// Establecer conexión
$conn = new ConexionBD();
$conn->abrir(); // Asegúrate de abrir la conexión

$usuarioId = $_SESSION['Usu_Id'];
$modelo = new FundacionModelo($conn);
$datos = $modelo->obtenerPorUsuario($usuarioId) ?? [];
?>

<!-- Fundacion_Dashboard.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/fundacion_dashboard.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>  
  <style>
    /* ==== Tarjeta de Caso ==== */
    .caso {
      background: #f8f9fa;
      padding: 1em;
      margin-bottom: .8em;
      border-radius: 6px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .caso h4 { margin: 0 0 .5em; color: #2b577d; }
    .caso p { margin: .4em 0; color: #333; }
    /* ==== Acciones en “Casos” ==== */
    section#casos .caso .acciones {
      margin-top: .6em; display: flex; gap: .5em;
    }
    section#casos .caso .acciones button {
      padding: 4px 8px; font-size: .8em; border: none;
      border-radius: 4px; cursor: pointer; transition: background .2s;
      color: white;
    }
    section#casos .caso .acciones button.update { background: #2b577d; }
    section#casos .caso .acciones button.delete { background: #e74c3c; }
    section#casos .caso .acciones button.update:hover { background: #1f3f5c; }
    section#casos .caso .acciones button.delete:hover { background: #c0392b; }
    /* ==== Barra de búsqueda ==== */
    .search-bar {
      margin: 15px 0; display: flex; gap: 10px;
    }
    .search-bar input {
      flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 5px;
    }
    .search-bar button {
      padding: 8px 12px; background-color: #2b577d;
      color: white; border: none; border-radius: 5px;
      cursor: pointer; transition: background .2s;
    }
    .search-bar button:hover { background-color: #1f3e5b; }
    /* ==== Botón externo Crear Caso ==== */
    .boton-crear-caso {
      display: inline-block; padding: 10px 15px;
      background-color: var(--verde-claro); color: var(--azul-oscuro);
      border-radius: 5px; text-decoration: none; font-weight: bold;
      margin-top: 1em; transition: background .2s;
    }
    .boton-crear-caso:hover { background-color: #65b28a; }
    /* ==== Tarjeta de Voluntario ==== */
    .voluntario {
      background: #f8f9fa; padding: 1em; margin-bottom: .8em;
      border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .voluntario h4 { margin: 0 0 .5em; color: #2b577d; }
    .voluntario p { margin: .4em 0; color: #333; }
    /* ==== Acciones en Voluntarios ==== */
    section#voluntarios .voluntario .acciones {
      margin-top: .6em; display: flex; gap: .5em;
    }
    section#voluntarios .voluntario .acciones button {
      padding: 4px 8px; font-size: .8em; border: none;
      border-radius: 4px; cursor: pointer; transition: background .2s;
      color: white;
    }
    section#voluntarios .voluntario .acciones button.delete-vol {
      background: #e74c3c;
    }
    section#voluntarios .voluntario .acciones button.delete-vol:hover {
      background: #c0392b;
    }
    section#voluntarios .voluntario .acciones button.assign-hor {
      background: #2b577d;
    }
    section#voluntarios .voluntario .acciones button.assign-hor:hover {
      background: #1f3f5c;
    }
    /* ==== Horarios: fondo claro y texto oscuro ==== */
    .voluntario .horarios {
      background-color: #f0f0f0;
      color: #333;
      margin-top: .5em; padding: .5em; border-left: 2px solid #2b577d;
      border-radius: 4px;
    }
    .voluntario .horarios li {
      margin-bottom: .3em;
    }
    /* ==== Formulario Inline Asignar Horario ==== */
    #form-asignar-horario {
      display: none; background: #fff; border: 1px solid #ccc;
      padding: 1em; border-radius: 6px; margin: 1em 0;
    }
    #form-asignar-horario h4 { margin-top:0; color:#2b577d; }
    #form-asignar-horario div { margin-bottom:.8em; }
    #form-asignar-horario label { font-weight:bold; display:block; margin-bottom:.3em; }
    #form-asignar-horario input {
      width:100%; padding:.6em; border:1px solid #ccc; border-radius:4px;
    }
    #form-asignar-horario .acciones-form { text-align:right; }
    #form-asignar-horario .acciones-form button {
      padding:.6em 1em; margin-left:.5em; cursor:pointer;
    }
    /* ==== Ayuda ==== */
    #ayuda h3 { color: #2b577d; }
    #ayuda h4 { margin-top: 1em; }
    #ayuda ul { margin-left: 1.2em; }
    #ayuda ul li { margin-bottom: .5em; }
    #ayuda p { margin: .6em 0; }
    /* Secciones ocultas */
    .seccion-oculta { display: none; }

    /* Estilos personalizados para el Perfil */
    body {
      font-family: 'Segoe UI', sans-serif;
      background:rgb(255, 255, 255);
    }
    .mensaje-exito {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    margin: 20px auto;
    width: 80%;
    text-align: center;
    border-radius: 5px;
}
    .container-perfil {
      width: 80%;
      margin: auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: black;
    }
    .image-box {
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .image-box img {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #007bff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      margin-bottom: 15px;
    }
    .custom-file-upload {
      display: inline-block;
      background-color: #007bff;
      color: #fff;
      padding: 12px 25px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
      text-align: center;
    }
    .custom-file-upload:hover {
      background-color: #0056b3;
    }
    input[type="file"] {
      display: none;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      border: 2px solid #ccc;
      border-radius: 8px;
    }
    .btn {
      padding: 10px 25px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      color: white;
      cursor: pointer;
      margin: 10px 5px;
    }
    .btn-green {
      background-color: #28a745;
    }
    .btn-blue {
      background-color: #007bff;
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
        <a href="#" id="ayuda-link"><i class="fas fa-question-circle"></i> Ayuda</a>
        <a href="/Pantry_Amigo/MVC/Vista/HTML/logout.php" id="cerrar-sesion-link"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <h2 id="titulo-seccion">Perfil</h2>
      </header>

      <!-- PERFIL -->
      <section id="perfil" class="seccion-activa">
        <div class="container-perfil">
          <div class="image-box">
            <img src="../imagenes/<?= htmlspecialchars($datos['Fund_Imagen'] ?? 'default.png') ?>" alt="Foto Fundación" id="preview">
            <label for="foto" class="custom-file-upload">📁 Seleccionar imagen</label>
            <input type="file" name="foto" id="foto" accept="image/*" onchange="loadImage(event)" form="form-perfil">
          </div>

            <form method="POST" enctype="multipart/form-data" id="form-perfil" action="../../Controlador/guardarPerfil.php">
            <div class="form-group">
              <label>Nombre de la Fundación:</label>
              <input type="text" name="Fund_Username" value="<?= htmlspecialchars($datos['Fund_Username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group">
              <label>Correo:</label>
              <input type="email" name="Fund_Correo" value="<?= htmlspecialchars($datos['Fund_Correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group">
              <label>Dirección:</label>
              <input type="text" name="Fund_Direccion" value="<?= htmlspecialchars($datos['Fund_Direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group">
              <label>Casos Activos:</label>
              <input type="number" name="Fund_Casos_Activos" value="<?= htmlspecialchars($datos['Fund_Casos_Activos'] ?? '', ENT_QUOTES, 'UTF-8') ?>" min="0" required>
            </div>
            <div class="form-group">
              <label>Teléfono:</label>
              <input type="text" name="Fund_Telefono" value="<?= htmlspecialchars($datos['Fund_Telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <?php if (!empty($datos)): ?>
              <button type="submit" name="actualizar" class="btn btn-green">Actualizar</button>
            <?php else: ?>
              <button type="submit" name="registrar" class="btn btn-blue">Registrar</button>
            <?php endif; ?>
          </form>
        </div>
      </section>
      <!-- CASOS -->
      <section id="casos" class="seccion-oculta">
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
        <!-- Formulario inline Asignar Horario -->
        <div id="form-asignar-horario">
          <h4>Asignar Horario</h4>
          <form id="horario-form">
            <input type="hidden" name="Hora_Vol_Cedula" id="hor-vol-cedula">
            <div>
              <label for="hor-citacion">Hora Citación</label>
              <input type="datetime-local" id="hor-citacion" name="Hora_Citacion" required>
            </div>
            <div>
              <label for="hor-localizacion">Localización</label>
              <input type="text" id="hor-localizacion" name="Hora_Localizacion" required>
            </div>
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
        <br><br>
        <h4>Contacto</h4>
        <p><i class="fas fa-envelope"></i> soporte@pantryamigo.org</p>
        <p><i class="fas fa-phone"></i> +57 123 456 7890</p>
      </section>
    </main>
  </div>

  <script>
    let casosDineroData = [], voluntariosData = [], horariosData = [];
    const secciones = {
      'perfil-link':    'perfil',
      'casos-link':     'casos',
      'crear-caso-link':'crearCaso',
      'voluntarios-link':'voluntarios',
      'ayuda-link':     'ayuda'
    };
    document.querySelectorAll('.menu a').forEach(a => {
      a.addEventListener('click', e => {
        const id = e.currentTarget.id;
        // Cerrar sesión deja comportamiento por defecto
        if (id === 'cerrar-sesion-link') return;
        e.preventDefault();
        // Crear Caso → formulario externo
        if (id === 'crear-caso-link') {
          window.location.href = '/Pantry_Amigo/MVC/Vista/HTML/RegistrarCasoDinero.php';
          return;
        }
        // Ocultar todas
        Object.values(secciones).forEach(sec =>
          document.getElementById(sec).classList.replace('seccion-activa','seccion-oculta')
        );
        // Mostrar la seleccionada
        const sel = secciones[id];
        document.getElementById(sel).classList.replace('seccion-oculta','seccion-activa');
        // Título y menú activo
        document.getElementById('titulo-seccion').innerText = e.currentTarget.textContent.trim();
        document.querySelectorAll('.menu a').forEach(x=>x.classList.remove('active'));
        e.currentTarget.classList.add('active');
        // Carga de datos
        if (sel === 'casos')       cargarCasos();
        if (sel === 'voluntarios') cargarVoluntarios();
      });
    });

    // — CASOS —
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
        const d = document.createElement('div');
        d.className = 'caso';
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
    document.getElementById('btn-filtrar-casos').addEventListener('click', ()=>{
      const t = document.getElementById('filtro-casos').value.trim().toLowerCase();
      renderCasos(casosDineroData.filter(ci=>
        ci.Caso_Id.toString().toLowerCase().includes(t) ||
        ci.Caso_Nombre.toLowerCase().includes(t)
      ));
    });
    function openEditar(id){
      window.location.href = `/Pantry_Amigo/MVC/Vista/HTML/RegistrarCasoDinero.php?id=${id}`;
    }
    function eliminarCaso(id){
      if(!confirm('¿Eliminar este caso?')) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_dinero.php?id=${id}`)
        .then(r=>r.json()).then(_=> cargarCasos());
    }

    // — VOLUNTARIOS & HORARIOS —
    function cargarVoluntarios(){
      Promise.all([
        fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_voluntarios.php').then(r=>r.json()),
        fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_horarios_voluntarios.php').then(r=>r.json())
      ]).then(([vols, horas])=>{
        voluntariosData = vols.error?[]:vols;
        horariosData    = horas.error?[]:horas;
        renderVoluntarios(voluntariosData);
      });
    }
    function renderVoluntarios(list){
      const cont = document.getElementById('lista-voluntarios');
      cont.innerHTML = '<h4>Voluntarios</h4><br>';
      list.forEach(v=>{
        const d = document.createElement('div');
        d.className = 'voluntario';
        let html = `
          <h4>${v.Vol_Nombre} ${v.Vol_Apellido} (${v.Vol_Cedula})</h4>
          <p><strong>Correo:</strong> ${v.Vol_Correo} • <strong>Cel:</strong> ${v.Vol_Celular}</p>
          <p><strong>Caso ID:</strong> ${v.Vol_Caso_Id} • <strong>Tipo:</strong> ${v.Vol_Caso_Tipo}</p>
          <div class="acciones">
            <button class="delete-vol" onclick="eliminarVol('${v.Vol_Cedula}')"><i class="fas fa-trash-alt"></i> Eliminar</button>
            <button class="assign-hor" onclick="openAsignar('${v.Vol_Cedula}')"><i class="fas fa-clock"></i> Asignar horario</button>
          </div>`;
        const hs = horariosData.filter(h=>h.Hora_Vol_Cedula===v.Vol_Cedula);
        if(hs.length){
          html += `<div class="horarios"><strong>Horarios:</strong><ul>`;
          hs.forEach(h=> html += `<li>${h.Hora_Citacion} en ${h.Hora_Localizacion}</li>`);
          html += `</ul></div>`;
        }
        d.innerHTML = html;
        cont.appendChild(d);
      });
    }
    function eliminarVol(ced){
      if(!confirm('¿Eliminar voluntario?')) return;
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_voluntario.php?cedula=${ced}`)
        .then(r=>r.json()).then(_=> cargarVoluntarios());
    }

    // Formularios inline de horarios
    const formHor = document.getElementById('form-asignar-horario'),
          horForm = document.getElementById('horario-form');
    document.getElementById('btn-cancelar-hor').addEventListener('click', ()=>formHor.style.display='none');
    function openAsignar(ced){
      document.getElementById('hor-vol-cedula').value = ced;
      formHor.style.display = 'block';
    }
    horForm.addEventListener('submit', e=>{
      e.preventDefault();
      const fd = new FormData(horForm);
      fetch('/Pantry_Amigo/MVC/Vista/HTML/add_horario_voluntario.php',{
        method:'POST', body: fd
      })
      .then(r=>r.json()).then(d=>{
        alert(d.message);
        formHor.style.display='none';
        cargarVoluntarios();
      });
    });

    // Filtrar voluntarios
    document.getElementById('btn-filtrar-voluntarios')
      .addEventListener('click', ()=>{
        const t = document.getElementById('filtro-voluntarios').value.trim().toLowerCase();
        renderVoluntarios(
          voluntariosData.filter(v =>
            v.Vol_Cedula.toString().toLowerCase().includes(t) ||
            (`${v.Vol_Nombre} ${v.Vol_Apellido}`).toLowerCase().includes(t)
          )
        );
      });

    // Vista previa de imagen
    function loadImage(event) {
      var image = document.getElementById('preview');
      image.src = URL.createObjectURL(event.target.files[0]);
    }
  </script>
</body>
</html>