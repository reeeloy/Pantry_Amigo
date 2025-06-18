<?php
// Tu bloque PHP de sesión y conexión va aquí (sin cambios)
ini_set('display_errors', 1); error_reporting(E_ALL); session_start();
if (!isset($_SESSION['Usu_Id'])) { header('Location: /Pantry_Amigo/MVC/Vista/HTML/login.php'); exit; }
include_once '../../Modelo/ConexionBD.php';
// Nota: El modelo de fundación no se usa en este dashboard, se puede omitir si no se necesita.
// include_once '../../Modelo/fundacionModelo.php'; 
$conn = new ConexionBD(); $conn->abrir();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Administrador</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/admin_dashboard_styles.css">
</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <div class="logo"><img src="/Pantry_Amigo/MVC/Vista/IMG/Logo_Pantry-amigo.png" alt="Logo" class="logo-img"></div>
      <nav class="nav menu flex-column">
        <a href="#" id="gestion-fundaciones-link" class="nav-link active"><i class="fas fa-hands-helping"></i> Gestionar Fundaciones</a>
        <a href="#" id="casos-link" class="nav-link"><i class="fas fa-bullseye"></i> Casos de Donación</a>
        <a href="/Pantry_Amigo/MVC/Vista/HTML/logout.php" id="cerrar-sesion-link" class="nav-link"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
      </nav>
    </aside>

    <main class="main-content">
      <header class="header"><h2 id="titulo-seccion">Gestionar Fundaciones</h2></header>

      <section id="gestion-fundaciones" class="seccion-activa">
        <div class="input-group mb-4">
          <input type="text" class="form-control" id="filtro-fundacion" placeholder="Buscar fundación por nombre o ID...">
          <button class="btn btn-outline-secondary" id="btn-filtrar-fundacion"><i class="fas fa-search"></i></button>
        </div>
        <div id="lista-fundaciones" class="row"></div>
      </section>

      <section id="casos" class="seccion-oculta">
        <div class="input-group mb-4">
          <input type="text" class="form-control" id="filtro-casos" placeholder="Buscar caso por nombre o ID...">
          <button class="btn btn-outline-secondary" id="btn-filtrar-casos"><i class="fas fa-search"></i></button>
        </div>
        <div id="lista-casos-dinero" class="row"></div>
      </section>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let fundacionesData = [], casosDineroData = [];

    const secciones = {
        'gestion-fundaciones-link':'gestion-fundaciones',
        'casos-link':'casos',
    };

    // --- NAVEGACIÓN ---
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', e => {
            if (link.id === 'cerrar-sesion-link') {
                if(confirm('¿Seguro que deseas cerrar sesión?')) window.location.href = link.href;
                e.preventDefault();
                return;
            }
            e.preventDefault();
            
            Object.values(secciones).forEach(secId => document.getElementById(secId).classList.replace('seccion-activa', 'seccion-oculta') || document.getElementById(secId).classList.add('seccion-oculta'));
            const seccionActiva = document.getElementById(secciones[e.currentTarget.id]);
            if(seccionActiva) seccionActiva.classList.replace('seccion-oculta', 'seccion-activa');
            
            document.getElementById('titulo-seccion').innerText = e.currentTarget.textContent.trim();
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            e.currentTarget.classList.add('active');

            if (secciones[e.currentTarget.id] === 'gestion-fundaciones') cargarFundaciones();
            if (secciones[e.currentTarget.id] === 'casos') cargarCasosDinero();
        });
    });

    // --- GESTIÓN DE FUNDACIONES ---
    async function cargarFundaciones() {
        const response = await fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_fundaciones.php');
        const data = await response.json();
        fundacionesData = data.error ? [] : data;
        renderFundaciones(fundacionesData);
    }
    
    function renderFundaciones(lista) {
        const container = document.getElementById('lista-fundaciones');
        container.innerHTML = '';
        if (lista.length === 0) { container.innerHTML = '<div class="alert alert-info">No hay fundaciones para mostrar.</div>'; return; }
        
        lista.forEach(f => {
            const card = document.createElement('div');
            card.className = 'col-md-6 mb-4';
            // TARJETA DE FUNDACIÓN CON TODOS LOS CAMPOS
            card.innerHTML = `
                <div class="card-item h-100">
                    <div class="card-body">
                        <h5 class="card-title">${f.Nombre}</h5>
                        <p class="card-text text-muted">ID: ${f.ID}</p>
                        <p class="card-text"><i class="fas fa-envelope"></i> ${f.Correo}</p>
                        <p class="card-text"><i class="fas fa-phone"></i> ${f.Telefono}</p>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i> ${f.Direccion}</p>
                        <p class="card-text"><i class="fas fa-tasks"></i> Casos Activos: ${f.CasosActivos}</p>
                    </div>
                    <div class="acciones">
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-fundacion"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </div>
                </div>`;
            card.querySelector('.btn-eliminar-fundacion').addEventListener('click', () => eliminarFundacion(f.ID));
            container.appendChild(card);
        });
    }
    
    document.getElementById('btn-filtrar-fundacion').addEventListener('click', () => {
        const filtro = document.getElementById('filtro-fundacion').value.toLowerCase();
        const filtrados = fundacionesData.filter(f => f.ID.toString().includes(filtro) || f.Nombre.toLowerCase().includes(filtro));
        renderFundaciones(filtrados);
    });

    async function eliminarFundacion(id) {
        if (!confirm(`¿Estás seguro de que quieres eliminar la fundación con ID ${id}? Esta acción no se puede deshacer.`)) return;
        const response = await fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_fundacion.php?id=${id}`);
        const data = await response.json();
        alert(data.message);
        if (data.success) cargarFundaciones();
    }

    // --- GESTIÓN DE CASOS DE DINERO ---
    async function cargarCasosDinero() {
        const response = await fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_dinero.php');
        const data = await response.json();
        casosDineroData = data.error ? [] : data;
        renderCasosDinero(casosDineroData);
    }
    
    function renderCasosDinero(lista) {
        const container = document.getElementById('lista-casos-dinero');
        container.innerHTML = '<h4>Casos de Donación</h4>';
        if (lista.length === 0) { container.innerHTML += '<div class="alert alert-info">No hay casos de dinero activos.</div>'; return; }

        lista.forEach(c => {
            const card = document.createElement('div');
            card.className = 'col-md-6 mb-4';
            // TARJETA DE CASO CON TODOS LOS CAMPOS
            card.innerHTML = `
                <div class="card-item h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title">${c.Caso_Nombre}</h5>
                            <span class="badge bg-success">${c.Caso_Estado}</span>
                        </div>
                        <p class="card-text text-muted">ID: ${c.Caso_Id} | Categoría: ${c.Caso_Cat_Nombre}</p>
                        <p class="card-text">${c.Caso_Descripcion}</p>
                        <p class="card-text"><i class="fas fa-bullseye"></i> Meta: $${parseFloat(c.Caso_Monto_Meta).toLocaleString()}</p>
                        <p class="card-text"><i class="fas fa-coins"></i> Recaudado: $${parseFloat(c.Caso_Monto_Recaudado).toLocaleString()}</p>
                        <p class="card-text"><i class="fas fa-calendar-alt"></i> ${c.Caso_Fecha_Inicio} al ${c.Caso_Fecha_Fin}</p>
                    </div>
                    <div class="acciones">
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-caso"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </div>
                </div>`;
            card.querySelector('.btn-eliminar-caso').addEventListener('click', () => eliminarCasoDinero(c.Caso_Id));
            container.appendChild(card);
        });
    }

    document.getElementById('btn-filtrar-casos').addEventListener('click', () => {
        const filtro = document.getElementById('filtro-casos').value.toLowerCase();
        const filtrados = casosDineroData.filter(c => c.Caso_Id.toString().includes(filtro) || c.Caso_Nombre.toLowerCase().includes(filtro));
        renderCasosDinero(filtrados);
    });

    async function eliminarCasoDinero(id) {
        if (!confirm(`¿Estás seguro de que quieres eliminar el caso con ID ${id}?`)) return;
        const response = await fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso_dinero.php?id=${id}`);
        const data = await response.json();
        alert(data.message);
        if (data.success) cargarCasosDinero();
    }
    
    // Carga inicial
    cargarFundaciones();
});
</script>
</body>
</html>