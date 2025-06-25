<?php
// Inicio de sesión y configuración de errores
ini_set('display_errors', 1); error_reporting(E_ALL); session_start();
// Validar si el usuario es un administrador logueado
if (!isset($_SESSION['Usu_Id']) || $_SESSION['tipo'] !== 'Administrador') { 
    header('Location: /Pantry_Amigo/MVC/Vista/HTML/login.php'); 
    exit; 
}
// Incluir la conexión a la base de datos
include_once '../../Modelo/ConexionBD.php';
$conn = new ConexionBD(); 
$conexion = $conn->abrir();
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
        <div class="menu-links">
          <a href="#" id="solicitudes-link" class="nav-link active"><i class="fas fa-file-signature"></i> <span>Solicitudes</span></a>
          <a href="#" id="gestion-fundaciones-link" class="nav-link"><i class="fas fa-hands-helping"></i> <span>Fundaciones</span></a>
          <a href="#" id="casos-link" class="nav-link"><i class="fas fa-bullseye"></i> <span>Casos de Donación</span></a>
          <a href="#" id="admin-link" class="nav-link"><i class="fas fa-user-shield"></i> <span>Registro Administradores</span></a>

        </div>
        <div class="menu-footer">
          <a href="#" id="sidebar-toggle" class="nav-link sidebar-toggle-link"><i class="fas fa-chevron-left"></i> <span>Ocultar</span></a>
          <a href="/Pantry_Amigo/MVC/Vista/HTML/logout.php" id="cerrar-sesion-link" class="nav-link"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a>
        </div>
      </nav>
    </aside>

    <main class="main-content">
      <header class="header d-flex align-items-center">
        <h2 id="titulo-seccion">Solicitudes de Verificación</h2>
      </header>
      
      <section id="solicitudes" class="seccion-activa">
        <div class="alert alert-info d-flex align-items-center" role="alert">
          <i class="fas fa-info-circle fa-2x me-3"></i>
          <div>Aquí se listan las nuevas fundaciones pendientes de aprobación. Revisa sus documentos y datos antes de aceptarlas en la plataforma.</div>
        </div>
        <div id="lista-solicitudes" class="row"></div>
      </section>

      <section id="gestion-fundaciones" class="seccion-oculta">
        <div class="input-group mb-4">
          <input type="text" class="form-control" id="filtro-fundacion" placeholder="Buscar fundación por nombre, ID, NIT o estado...">
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
      <section id="admin" class="seccion-oculta">
  <h3>Administradores Actuales</h3>
  <div id="lista-admins" class="mb-4"></div>
  
  <h4>Crear Nuevo Administrador</h4>
  <form id="form-crear-admin">
    <input type="text" name="username" placeholder="Nombre de Usuario" required class="form-control mb-2">
    <input type="email" name="correo" placeholder="Correo Electrónico" required class="form-control mb-2">
    <input type="password" name="password" placeholder="Contraseña" required class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Crear</button>
  </form>
  <div id="admin-feedback" class="mt-2"></div>
</section>

    </main>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let fundacionesData = [], casosDineroData = [];
    const secciones = { 
        'solicitudes-link':'solicitudes',
        'gestion-fundaciones-link':'gestion-fundaciones',
        'casos-link':'casos',
        'admin-link': 'admin'
    };

    // --- NAVEGACIÓN ---
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.id === 'sidebar-toggle' || link.id === 'cerrar-sesion-link') return;
        link.addEventListener('click', e => {
            e.preventDefault();
            const id = e.currentTarget.id;

            document.getElementById('titulo-seccion').innerText = e.currentTarget.querySelector('span').textContent.trim();
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            e.currentTarget.classList.add('active');

            // OCULTA TODAS LAS SECCIONES
            Object.values(secciones).forEach(secId => {
                const el = document.getElementById(secId);
                if(el) el.classList.add('seccion-oculta');
            });
            // MUESTRA LA SECCIÓN SELECCIONADA
            document.getElementById(secciones[id]).classList.remove('seccion-oculta');
            
            if (id === 'solicitudes-link') cargarSolicitudes();
            if (id === 'gestion-fundaciones-link') cargarFundaciones();
            if (id === 'casos-link') cargarCasosDinero();
            // Si quieres cargar admins, aquí puedes poner una función cargarAdmins();
        });
    });

    // --- LÓGICA DE BOTONES DE ACCIÓN ---
    document.getElementById('cerrar-sesion-link').addEventListener('click', e => {
        e.preventDefault();
        if(confirm('¿Seguro que deseas cerrar sesión?')) {
            window.location.href = e.currentTarget.href;
        }
    });

    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    sidebarToggle.addEventListener('click', e => {
        e.preventDefault();
        sidebar.classList.toggle('collapsed');
        const icon = sidebarToggle.querySelector('i');
        const text = sidebarToggle.querySelector('span');
        if (sidebar.classList.contains('collapsed')) {
            icon.classList.remove('fa-chevron-left');
            icon.classList.add('fa-chevron-right');
            text.textContent = '';
        } else {
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-left');
            text.textContent = 'Ocultar';
        }
    });

    // --- GESTIÓN DE FUNDACIONES Y SOLICITUDES ---
    async function cargarFundaciones() {
        const response = await fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_fundaciones.php');
        const data = await response.json();
        fundacionesData = data.error ? [] : data;
        renderFundaciones(fundacionesData);
    }

    async function cargarSolicitudes() {
        // Siempre volvemos a cargar los datos para tener la información más reciente
        const response = await fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_fundaciones.php');
        const data = await response.json();
        fundacionesData = data.error ? [] : data;
        
        const solicitudes = fundacionesData.filter(f => f.Fund_Estado_Verificacion === 'pendiente');
        renderSolicitudes(solicitudes);
    }
    
    function renderFundaciones(lista) {
        const container = document.getElementById('lista-fundaciones');
        container.innerHTML = '';
        if (lista.length === 0) { container.innerHTML = '<div class="alert alert-info">No hay fundaciones para mostrar.</div>'; return; }
        
        lista.forEach(f => {
            let estadoBadge = '';
            switch(f.Fund_Estado_Verificacion) {
                case 'verificado': estadoBadge = '<span class="badge bg-success">Verificado</span>'; break;
                case 'rechazado': estadoBadge = '<span class="badge bg-danger">Rechazado</span>'; break;
                default: estadoBadge = '<span class="badge bg-warning text-dark">Pendiente</span>';
            }
            const card = document.createElement('div');
            card.className = 'col-md-6 mb-4';
            card.innerHTML = `<div class="card-item h-100"><div class="card-body"><div class="d-flex justify-content-between"><h5>${f.Fund_Username}</h5>${estadoBadge}</div><p class="text-muted">ID: ${f.Fund_Id}</p><p><i class="fas fa-id-card"></i> <strong>NIT:</strong> ${f.Fund_NIT || 'N/A'}</p></div><div class="acciones"><button class="btn btn-sm btn-outline-danger btn-eliminar-fundacion"><i class="fas fa-trash-alt"></i> Eliminar</button></div></div>`;
            card.querySelector('.btn-eliminar-fundacion').addEventListener('click', () => eliminarFundacion(f.Fund_Id));
            container.appendChild(card);
        });
    }

    function renderSolicitudes(lista) {
        const container = document.getElementById('lista-solicitudes');
        container.innerHTML = '';
        if (lista.length === 0) { container.innerHTML = '<div class="alert alert-success">¡Excelente! No hay solicitudes pendientes de verificación.</div>'; return; }
        
        lista.forEach(f => {
            const card = document.createElement('div');
            card.className = 'col-12 mb-4';
            card.innerHTML = `
                <div class="card-item">
                    <div class="card-body">
                        <h5 class="card-title">${f.Fund_Username}</h5>
                        <p class="card-text text-muted">ID de Usuario: ${f.Fund_Usu_Id}</p>
                        <p class="card-text"><i class="fas fa-id-card"></i> <strong>NIT:</strong> ${f.Fund_NIT || 'No proporcionado'}</p>
                        <p class="card-text"><i class="fas fa-envelope"></i> <strong>Correo:</strong> ${f.Fund_Correo}</p>
                        <p class="card-text"><i class="fas fa-file-pdf"></i> <a href="/Pantry_Amigo/uploads/documentos/${f.Fund_Ruta_Documento}" target="_blank" class="link-primary">Ver Documento de Verificación</a></p>
                        <p class="card-text"><i class="fas fa-globe"></i> <a href="https://www.rues.org.co/RM_Consultas" target="_blank" class="link-secondary">Consultar NIT en RUES</a></p>
                    </div>
                    <div class="acciones d-flex justify-content-end">
                        <button class="btn btn-sm btn-warning me-2 btn-rechazar-fundacion"><i class="fas fa-times"></i> Rechazar</button>
                        <button class="btn btn-sm btn-success btn-aprobar-fundacion"><i class="fas fa-check"></i> Aprobar</button>
                    </div>
                </div>`;
            card.querySelector('.btn-rechazar-fundacion').addEventListener('click', () => cambiarEstadoFundacion(f.Fund_Id, 'rechazado'));
            card.querySelector('.btn-aprobar-fundacion').addEventListener('click', () => cambiarEstadoFundacion(f.Fund_Id, 'verificado'));
            container.appendChild(card);
        });
    }

    async function cambiarEstadoFundacion(id, nuevoEstado) {
        let motivo = '';
        if (nuevoEstado === 'rechazado') {
            motivo = prompt("Por favor, introduce el motivo del rechazo para notificar a la fundación:");
            if (motivo === null) return;
        } else {
            if (!confirm(`¿Estás seguro de que quieres APROBAR esta fundación?`)) return;
        }

        const formData = new FormData();
        formData.append('id', id);
        formData.append('estado', nuevoEstado);
        formData.append('motivo', motivo);

        const response = await fetch('/Pantry_Amigo/MVC/Vista/HTML/actualizar_estado_fundacion.php', { method: 'POST', body: formData });
        const data = await response.json();
        alert(data.message);
        if (data.success) {
            fundacionesData = []; // Forzamos la recarga de datos
            cargarSolicitudes();
        }
    }
    
    // --- LÓGICA PARA FILTRAR Y ELIMINAR ---
    async function eliminarFundacion(id) { /* ... Tu código existente ... */ }
    document.getElementById('btn-filtrar-fundacion').addEventListener('click', () => { /* ... Tu código existente ... */ });

    // --- LÓGICA PARA CARGAR CASOS ---
    async function cargarCasosDinero() { /* ... Tu código existente ... */ }
    
    // Carga inicial al entrar al dashboard
    cargarSolicitudes();

    // --- REGISTRO DE NUEVO ADMIN ---
    document.getElementById('form-crear-admin').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const feedback = document.getElementById('admin-feedback');
        feedback.textContent = 'Procesando...';

        const response = await fetch('/Pantry_Amigo/MVC/Modelo/registrarAdmin.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        feedback.textContent = data.message;
        feedback.className = data.success ? 'alert alert-success mt-2' : 'alert alert-danger mt-2';
        if (data.success) form.reset();
    });
});
</script>
</body>
</html>