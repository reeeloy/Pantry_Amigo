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

// Cargar modelos y conexión
include_once '../../Modelo/ConexionBD.php';
include_once '../../Modelo/fundacionModelo.php';

// Establecer conexión y obtener datos
$conn_obj = new ConexionBD(); 
$conexion = $conn_obj->abrir();
$usuarioId = $_SESSION['Usu_Id'];
$modelo = new FundacionModelo($conexion); 
$datos = $modelo->obtenerPorUsuario($usuarioId) ?? [];

// Solución al problema de sesión
if (!empty($datos) && isset($datos['Fund_Id']) && !isset($_SESSION['Fund_Id'])) {
    $_SESSION['Fund_Id'] = $datos['Fund_Id'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Fundación - Pantry Amigo</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/dashboard_styles.css">

</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar" id="sidebar">
      <div class="logo">
        <img src="/Pantry_Amigo/MVC/Vista/IMG/Logo_Pantry-amigo.png" alt="Logo Pantry Amigo" class="logo-img">
      </div>
      
      <nav class="nav menu d-flex flex-column h-100">
        <div class="menu-links">
            <a href="#" id="perfil-link" class="nav-link active">
              <i class="fas fa-user"></i> 
              <span>Perfil</span>
            </a>
            <a href="#" id="casos-link" class="nav-link">
              <i class="fas fa-folder-open"></i> 
              <span>Casos</span>
            </a>
            <a href="#" id="crear-caso-link" class="nav-link">
              <i class="fas fa-plus-circle"></i> 
              <span>Crear Caso</span>
            </a>
            <a href="#" id="voluntarios-link" class="nav-link">
              <i class="fas fa-users"></i> 
              <span>Voluntarios</span>
            </a>
            <a href="#" id="ayuda-link" class="nav-link">
              <i class="fas fa-question-circle"></i> 
              <span>Ayuda</span>
            </a>
        </div>
        
        <div class="menu-footer">
            <a href="#" id="sidebar-toggle" class="nav-link sidebar-toggle-link">
                <i class="fas fa-chevron-left"></i> 
                <span>Ocultar</span>
            </a>
            <a href="/Pantry_Amigo/MVC/Vista/HTML/logout.php" id="cerrar-sesion-link" class="nav-link">
              <i class="fas fa-sign-out-alt"></i> 
              <span>Cerrar Sesión</span>
            </a>
        </div>
      </nav>
    </aside>

    <main class="main-content">
      <header class="header">
        <h2 id="titulo-seccion">Perfil de la Fundación</h2>
      </header>

      <!-- SECCIÓN PERFIL -->
      <section id="perfil" class="seccion-activa">
        <div class="container-perfil">
          <div class="image-box">
            <img src="../imagenes/<?= htmlspecialchars($datos['Fund_Imagen'] ?? 'default.png') ?>" alt="Foto Fundación" id="preview">
            <label for="foto" class="custom-file-upload">
              <i class="fas fa-camera"></i> Seleccionar imagen
            </label>
            <input type="file" name="foto" id="foto" accept="image/*" onchange="loadImage(event)" form="form-perfil" style="display:none;">
          </div>
          <div class="flex-grow-1">
            <form method="POST" enctype="multipart/form-data" id="form-perfil" action="../../Controlador/guardarPerfil.php">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre de la Fundación:</label>
                  <input type="text" class="form-control" name="Fund_Username" value="<?= htmlspecialchars($datos['Fund_Username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Correo:</label>
                  <input type="email" class="form-control" name="Fund_Correo" value="<?= htmlspecialchars($datos['Fund_Correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Dirección:</label>
                  <input type="text" class="form-control" name="Fund_Direccion" value="<?= htmlspecialchars($datos['Fund_Direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Teléfono:</label>
                  <input type="text" class="form-control" name="Fund_Telefono" value="<?= htmlspecialchars($datos['Fund_Telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Casos Activos:</label>
                <input type="number" class="form-control" name="Fund_Casos_Activos" value="<?= htmlspecialchars($datos['Fund_Casos_Activos'] ?? '', ENT_QUOTES, 'UTF-8') ?>" min="0" required>
              </div>
              <div class="text-center mt-4">
                <?php if (!empty($datos)): ?>
                  <button type="submit" name="actualizar" class="btn btn-success-custom">
                    <i class="fas fa-save"></i> Actualizar Perfil
                  </button>
                <?php else: ?>
                  <button type="submit" name="registrar" class="btn btn-primary-custom">
                    <i class="fas fa-plus"></i> Registrar Perfil
                  </button>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>
      </section>
      
      <!-- SECCIÓN CASOS -->
      <section id="casos" class="seccion-oculta">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3><i class="fas fa-folder-open me-2"></i>Mis Casos</h3>
          <button class="btn btn-primary-custom" onclick="abrirModalCaso('crear')">
            <i class="fas fa-plus me-2"></i>Nuevo Caso
          </button>
        </div>
        <div id="lista-casos-container" class="row"></div>
      </section>

      <!-- SECCIÓN VOLUNTARIOS -->
      <section id="voluntarios" class="seccion-oculta">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3><i class="fas fa-users me-2"></i>Voluntarios</h3>
        </div>
        <div class="search-container input-group mb-4">
            <input type="text" class="form-control" id="filtro-voluntarios" placeholder="Buscar por cédula o nombre...">
            <button class="btn btn-outline-secondary" id="btn-filtrar-voluntarios">
              <i class="fas fa-search"></i>
            </button>
        </div>
        <div id="form-asignar-horario" class="form-asignar-horario" style="display:none;">
            <h4 class="form-title"><i class="fas fa-clock me-2"></i>Asignar Horario</h4>
            <form id="horario-form">
                <input type="hidden" name="Hora_Vol_Cedula" id="hor-vol-cedula">
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Hora Citación:</label>
                      <input type="datetime-local" class="form-control" id="hor-citacion" name="Hora_Citacion" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Localización:</label>
                      <input type="text" class="form-control" id="hor-localizacion" name="Hora_Localizacion" placeholder="Dirección del encuentro" required>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-secondary me-2" id="btn-cancelar-hor">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">
                      <i class="fas fa-save me-1"></i>Guardar Horario
                    </button>
                </div>
            </form>
        </div>
        <div id="lista-voluntarios" class="row"></div>
      </section>
      
      <!-- SECCIÓN AYUDA -->
      <section id="ayuda" class="seccion-oculta">
          <h3><i class="fas fa-life-ring me-2"></i>Ayuda y Soporte</h3>
          <hr>
          <div class="row mt-4">
              <div class="col-md-8">
                  <h4><i class="fas fa-question-circle me-2"></i>Preguntas Frecuentes</h4>
                  <div class="accordion" id="faqAccordion">
                      <div class="accordion-item">
                          <h2 class="accordion-header">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                  ¿Cómo creo un nuevo caso?
                              </button>
                          </h2>
                          <div id="faq1" class="accordion-collapse collapse show">
                              <div class="accordion-body">
                                  Haz clic en "Crear Caso" en el menú de la izquierda. Se abrirá una ventana donde podrás llenar todos los campos del formulario con la información del caso que deseas crear.
                              </div>
                          </div>
                      </div>
                      <div class="accordion-item">
                          <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                  ¿Cómo actualizo un caso existente?
                              </button>
                          </h2>
                          <div id="faq2" class="accordion-collapse collapse">
                              <div class="accordion-body">
                                  En la sección "Casos", busca el caso que deseas modificar y haz clic en "Actualizar". Se abrirá la misma ventana, pero con los datos del caso listos para editar.
                              </div>
                          </div>
                      </div>
                      <div class="accordion-item">
                          <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                  ¿Cómo asigno horarios a voluntarios?
                              </button>
                          </h2>
                          <div id="faq3" class="accordion-collapse collapse">
                              <div class="accordion-body">
                                  En "Voluntarios", busca al voluntario y haz clic en "Asignar horario". Se desplegará un formulario para que completes la fecha, hora y ubicación del encuentro.
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="card">
                      <div class="card-header bg-primary text-white">
                          <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contacto</h5>
                      </div>
                      <div class="card-body">
                          <p><i class="fas fa-envelope me-2"></i>soporte@pantryamigo.org</p>
                          <p><i class="fas fa-phone me-2"></i>+57 123 456 7890</p>
                          <p><i class="fas fa-clock me-2"></i>Lun-Vie: 8:00 AM - 6:00 PM</p>
                      </div>
                  </div>
              </div>
          </div>
      </section>
    </main>
  </div>

  <!-- MODAL PARA CASOS -->
  <div class="modal fade" id="modal-caso" tabindex="-1" aria-labelledby="modal-caso-titulo" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-caso-titulo">
            <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Caso
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="caso-form" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="action" id="caso-action" value="crear">
                <input type="hidden" name="id" id="caso-id">
                <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Nombre del Caso</label>
                      <input type="text" class="form-control" name="Caso_Nombre" placeholder="Ej: Ayuda para cirugía" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Categoría</label>
                      <select name="Caso_Cat_Id" class="form-select" required>
                        <option value="" disabled selected>Seleccione una categoría...</option>
                        <option value="1">Salud</option>
                        <option value="2">Educación</option>
                        <option value="3">Emergencias</option>
                        <option value="4">Alimentación</option>
                        <option value="5">Tecnología</option>
                        <option value="6">Medio Ambiente</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Estado</label>
                      <select name="Caso_Estado" class="form-select" required>
                        <option value="" disabled selected>Seleccione el estado...</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Descripción</label>
                      <textarea class="form-control" name="Caso_Descripcion" rows="4" placeholder="Describe detalladamente el caso y por qué necesita ayuda..." required></textarea>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Monto Meta ($)</label>
                      <input type="number" class="form-control" name="Caso_Monto_Meta" min="1" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" id="caso-imagen-label">Imagen del Caso</label>
                      <input type="file" class="form-control" name="Caso_Imagen" accept="image/*">
                      <small class="form-text text-muted">Opcional. Formatos: JPG, PNG, GIF (máx. 5MB)</small>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Fecha de Inicio</label>
                      <input type="date" class="form-control" name="Caso_Fecha_Inicio" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Fecha de Fin</label>
                      <input type="date" class="form-control" name="Caso_Fecha_Fin" required>
                    </div>
                    <div class="col-12">
                      <div class="form-check form-switch pt-2">
                        <input class="form-check-input" type="checkbox" role="switch" name="Caso_Voluntariado" value="1" id="voluntariado-switch">
                        <label class="form-check-label" for="voluntariado-switch">
                          <strong>¿Requiere voluntariado?</strong>
                          <small class="d-block text-muted">Marca esta opción si el caso necesita voluntarios para ayudar</small>
                        </label>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-primary-custom" id="btn-submit-caso">
                  <i class="fas fa-plus-circle me-1"></i>Crear Caso
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      console.log('Dashboard inicializado correctamente');
      
      // Variables globales
      const modalCaso = new bootstrap.Modal(document.getElementById('modal-caso'));
      const casoForm = document.getElementById('caso-form');
      const secciones = { 
        'perfil-link': 'perfil', 
        'casos-link': 'casos', 
        'crear-caso-link': 'crear-caso-link', 
        'voluntarios-link': 'voluntarios', 
        'ayuda-link': 'ayuda' 
      };
      let casosData = [];
      let voluntariosData = [];
      let horariosData = [];

      // --- NAVEGACIÓN DEL SIDEBAR ---
      document.querySelectorAll('.nav-link').forEach(link => {
          if (link.id === 'sidebar-toggle' || link.id === 'cerrar-sesion-link') return;
          
          link.addEventListener('click', function(e) {
              e.preventDefault();
              const id = e.currentTarget.id;
              
              // Caso especial: crear caso
              if (id === 'crear-caso-link') {
                  abrirModalCaso('crear');
                  return;
              }
              
              // Actualizar título
              const textoLink = e.currentTarget.querySelector('span').textContent.trim();
              document.getElementById('titulo-seccion').innerText = textoLink;
              
              // Actualizar estado activo
              document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
              e.currentTarget.classList.add('active');
              
              // Ocultar todas las secciones
              Object.values(secciones).forEach(secId => {
                  const elemento = document.getElementById(secId.replace('-link', ''));
                  if (elemento) {
                      elemento.classList.remove('seccion-activa');
                      elemento.classList.add('seccion-oculta');
                  }
              });
              
              // Mostrar sección activa
              const seccionActiva = document.getElementById(secciones[id]);
              if (seccionActiva) {
                  seccionActiva.classList.remove('seccion-oculta');
                  seccionActiva.classList.add('seccion-activa');
              }
              
              // Cargar datos si es necesario
              if (id === 'casos-link') cargarCasos();
              if (id === 'voluntarios-link') cargarVoluntarios();
          });
      });

      // --- CERRAR SESIÓN ---
      document.getElementById('cerrar-sesion-link').addEventListener('click', function(e) {
          e.preventDefault();
          if (confirm('¿Estás seguro de que deseas cerrar la sesión?')) {
              window.location.href = e.currentTarget.href;
          }
      });

      // --- SIDEBAR TOGGLE ---
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebar-toggle');
      sidebarToggle.addEventListener('click', function(e) {
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

      // --- FUNCIONES API ---
      async function apiCall(url, options = {}) {
          try {
              console.log('Llamada API a:', url);
              const response = await fetch(url, options);
              
              if (!response.ok) {
                  throw new Error(`Error HTTP: ${response.status}`);
              }
              
              const data = await response.json();
              console.log('Respuesta API:', data);
              return data;
          } catch (error) {
              console.error('Error en API Call:', error);
              mostrarNotificacion('Error de conexión con el servidor.', 'danger');
              return null;
          }
      }

      // --- GESTIÓN DE CASOS ---
      async function cargarCasos() {
          console.log('Cargando casos...');
          const data = await apiCall('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_dinero.php');
          casosData = data && !data.error ? data : [];
          renderCasos(casosData);
      }

      function renderCasos(lista) {
          const container = document.getElementById('lista-casos-container');
          container.innerHTML = '';
          
          if (lista.length === 0) {
              container.innerHTML = `
                  <div class="col-12">
                      <div class="alert alert-info text-center">
                          <i class="fas fa-info-circle me-2"></i>
                          No se encontraron casos. ¡Crea tu primer caso haciendo clic en "Crear Caso"!
                      </div>
                  </div>
              `;
              return;
          }
          
          lista.forEach(caso => {
              const progreso = caso.Caso_Monto_Meta > 0 ? 
                  (caso.Caso_Monto_Recaudado / caso.Caso_Monto_Meta * 100).toFixed(1) : 0;
              
              const casoElement = document.createElement('div');
              casoElement.className = 'col-lg-6 col-xl-4 mb-4';
              casoElement.innerHTML = `
                  <div class="caso-card h-100">
                      <div class="card-body">
                          <div class="d-flex justify-content-between align-items-start mb-3">
                              <h5 class="card-title">${caso.Caso_Nombre}</h5>
                              <span class="badge bg-success">${caso.Caso_Estado}</span>
                          </div>
                          <h6 class="card-subtitle mb-2 text-muted">
                              ID: ${caso.Caso_Id} | ${caso.Caso_Cat_Nombre}
                          </h6>
                          <p class="card-text">${caso.Caso_Descripcion}</p>
                          <div class="progress mb-2">
                              <div class="progress-bar" style="width: ${progreso}%" 
                                   role="progressbar" aria-valuenow="${progreso}" 
                                   aria-valuemin="0" aria-valuemax="100">
                              </div>
                          </div>
                          <small class="text-muted">
                              Recaudado: $${parseFloat(caso.Caso_Monto_Recaudado || 0).toLocaleString()} 
                              de $${parseFloat(caso.Caso_Monto_Meta).toLocaleString()} (${progreso}%)
                          </small>
                      </div>
                      <div class="acciones">
                          <button class="btn btn-sm btn-outline-primary btn-actualizar-caso">
                              <i class="fas fa-edit"></i> Actualizar
                          </button>
                          <button class="btn btn-sm btn-outline-danger btn-eliminar-caso">
                              <i class="fas fa-trash-alt"></i> Eliminar
                          </button>
                      </div>
                  </div>
              `;
              
              // Event listeners para botones
              casoElement.querySelector('.btn-actualizar-caso')
                  .addEventListener('click', () => abrirModalCaso('actualizar', caso.Caso_Id));
              casoElement.querySelector('.btn-eliminar-caso')
                  .addEventListener('click', () => eliminarCaso(caso.Caso_Id));
              
              container.appendChild(casoElement);
          });
      }

      // --- MODAL DE CASOS ---
      window.abrirModalCaso = function(action, id = null) {
          console.log('Abriendo modal:', action, id);
          casoForm.reset();
          
          const titulo = document.getElementById('modal-caso-titulo');
          const boton = document.getElementById('btn-submit-caso');
          const actionInput = document.getElementById('caso-action');
          const idInput = document.getElementById('caso-id');
          const imagenLabel = document.getElementById('caso-imagen-label');
          
          if (action === 'crear') {
              titulo.innerHTML = '<i class="fas fa-plus-circle me-2"></i>Crear Nuevo Caso';
              boton.innerHTML = '<i class="fas fa-plus-circle me-1"></i>Crear Caso';
              actionInput.value = 'crear';
              idInput.value = '';
              imagenLabel.innerText = 'Imagen del Caso';
          } else if (action === 'actualizar') {
              const caso = casosData.find(c => c.Caso_Id == id);
              if (!caso) {
                  mostrarNotificacion('Caso no encontrado', 'danger');
                  return;
              }
              
              titulo.innerHTML = '<i class="fas fa-edit me-2"></i>Actualizar Caso';
              boton.innerHTML = '<i class="fas fa-save me-1"></i>Guardar Cambios';
              actionInput.value = 'actualizar';
              idInput.value = caso.Caso_Id;
              imagenLabel.innerText = 'Cambiar Imagen (Opcional)';
              
              // Llenar formulario - EXCLUYENDO inputs de tipo file
              for (const key in caso) {
                  const input = casoForm.querySelector(`[name="${key}"]`);
                  if (input && input.type !== 'file') {
                      if (input.type === 'checkbox') {
                          input.checked = (caso[key] == 1);
                      } else {
                          input.value = caso[key];
                      }
                  }
              }
          }
          
          modalCaso.show();
      };

      // --- SUBMIT FORMULARIO CASOS ---
      casoForm.addEventListener('submit', async function(e) {
          e.preventDefault();
          console.log('Enviando formulario de caso...');
          
          const formData = new FormData(this);
          
          // Debug: mostrar datos del formulario
          for (let [key, value] of formData.entries()) {
              console.log(`${key}: ${value}`);
          }
          
          try {
              const response = await fetch('/Pantry_Amigo/MVC/Vista/HTML/manejador_casos.php', {
                  method: 'POST',
                  body: formData
              });
              
              console.log('Response status:', response.status);
              
              if (!response.ok) {
                  throw new Error(`HTTP error! status: ${response.status}`);
              }
              
              const data = await response.json();
              console.log('Response data:', data);
              
              if (data && data.success) {
                  mostrarNotificacion(data.message, 'success');
                  modalCaso.hide();
                  cargarCasos(); // Recargar lista de casos
              } else {
                  mostrarNotificacion(data ? data.message : 'Error desconocido', 'danger');
              }
          } catch (error) {
              console.error('Error en submit:', error);
              mostrarNotificacion('Error al procesar la solicitud: ' + error.message, 'danger');
          }
      });

      // --- ELIMINAR CASO ---
      window.eliminarCaso = async function(id) {
          if (!confirm('¿Seguro que deseas eliminar este caso? Esta acción no se puede deshacer.')) return;
          
          const data = await apiCall(`/Pantry_Amigo/MVC/Vista/HTML/manejador_casos.php?action=eliminar&id=${id}`, {
              method: 'GET'
          });
          
          if (data && data.success) {
              mostrarNotificacion(data.message, 'success');
              cargarCasos();
          } else {
              mostrarNotificacion(data ? data.message : 'Error al eliminar.', 'danger');
          }
      };

      // --- GESTIÓN DE VOLUNTARIOS ---
      async function cargarVoluntarios() {
          console.log('Cargando voluntarios...');
          const [vols, horas] = await Promise.all([
              apiCall('/Pantry_Amigo/MVC/Vista/HTML/obtener_voluntarios.php'),
              apiCall('/Pantry_Amigo/MVC/Vista/HTML/obtener_horarios_voluntarios.php')
          ]);
          
          voluntariosData = vols && !vols.error ? vols : [];
          horariosData = horas && !horas.error ? horas : [];
          renderVoluntarios(voluntariosData);
      }

      function renderVoluntarios(lista) {
          const container = document.getElementById('lista-voluntarios');
          container.innerHTML = '';
          
          if (lista.length === 0) {
              container.innerHTML = `
                  <div class="col-12">
                      <div class="alert alert-info text-center">
                          <i class="fas fa-info-circle me-2"></i>
                          No hay voluntarios registrados en el sistema.
                      </div>
                  </div>
              `;
              return;
          }
          
          lista.forEach(voluntario => {
              const horarios = horariosData.filter(h => h.Hora_Vol_Cedula === voluntario.Vol_Cedula);
              
              let horariosHtml = '';
              if (horarios.length > 0) {
                  horariosHtml = `
                      <div class="horarios mt-3">
                          <strong><i class="fas fa-calendar-alt me-1"></i>Horarios Asignados:</strong>
                          <ul class="list-unstyled mt-2">
                  `;
                  horarios.forEach(h => {
                      horariosHtml += `
                          <li><small><i class="fas fa-clock me-1"></i>
                              ${new Date(h.Hora_Citacion).toLocaleString()} en ${h.Hora_Localizacion}
                          </small></li>
                      `;
                  });
                  horariosHtml += '</ul></div>';
              }
              
              const voluntarioElement = document.createElement('div');
              voluntarioElement.className = 'col-md-6 col-xl-4 mb-4';
              voluntarioElement.innerHTML = `
                  <div class="voluntario h-100">
                      <h4>${voluntario.Vol_Nombre} ${voluntario.Vol_Apellido}</h4>
                      <p class="text-muted mb-2">
                          <i class="fas fa-id-card me-1"></i>Cédula: ${voluntario.Vol_Cedula}
                      </p>
                      <p class="mb-2">
                          <i class="fas fa-envelope me-1"></i>${voluntario.Vol_Correo}
                      </p>
                      <p class="mb-3">
                          <i class="fas fa-phone me-1"></i>${voluntario.Vol_Celular || 'No registrado'}
                      </p>
                      ${horariosHtml}
                      <div class="acciones mt-3">
                          <button class="btn btn-sm btn-outline-danger btn-eliminar-vol">
                              <i class="fas fa-trash-alt me-1"></i>Eliminar
                          </button>
                          <button class="btn btn-sm btn-primary-custom btn-asignar-horario">
                              <i class="fas fa-clock me-1"></i>Asignar Horario
                          </button>
                      </div>
                  </div>
              `;
              
              // Event listeners
              voluntarioElement.querySelector('.btn-eliminar-vol')
                  .addEventListener('click', () => eliminarVoluntario(voluntario.Vol_Cedula));
              voluntarioElement.querySelector('.btn-asignar-horario')
                  .addEventListener('click', () => abrirAsignarHorario(voluntario.Vol_Cedula));
              
              container.appendChild(voluntarioElement);
          });
      }

      async function eliminarVoluntario(cedula) {
          if (!confirm('¿Seguro que deseas eliminar a este voluntario?')) return;
          
          const data = await apiCall(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_voluntario.php?cedula=${cedula}`);
          if (data && data.success) {
              mostrarNotificacion('Voluntario eliminado exitosamente.', 'success');
              cargarVoluntarios();
          } else {
              mostrarNotificacion(data ? data.message : 'Error al eliminar voluntario.', 'danger');
          }
      }

      // --- HORARIOS DE VOLUNTARIOS ---
      const formHorarioContainer = document.getElementById('form-asignar-horario');
      const formHorario = document.getElementById('horario-form');
      
      function abrirAsignarHorario(cedula) {
          document.getElementById('hor-vol-cedula').value = cedula;
          formHorarioContainer.style.display = 'block';
          
          // Scroll hacia el formulario
          formHorarioContainer.scrollIntoView({ behavior: 'smooth' });
      }
      
      document.getElementById('btn-cancelar-hor').addEventListener('click', function() {
          formHorarioContainer.style.display = 'none';
          formHorario.reset();
      });
      
      formHorario.addEventListener('submit', async function(e) {
          e.preventDefault();
          
          const data = await apiCall('/Pantry_Amigo/MVC/Vista/HTML/add_horario_voluntario.php', {
              method: 'POST',
              body: new FormData(this)
          });
          
          if (data && data.success) {
              mostrarNotificacion('Horario asignado exitosamente.', 'success');
              formHorarioContainer.style.display = 'none';
              this.reset();
              cargarVoluntarios();
          } else {
              mostrarNotificacion(data ? data.message : 'Error al asignar horario.', 'danger');
          }
      });

      // --- UTILIDADES ---
      function mostrarNotificacion(mensaje, tipo = 'success') {
          const alertContainer = document.createElement('div');
          alertContainer.className = `alert alert-${tipo === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
          alertContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1055; min-width: 300px;';
          alertContainer.innerHTML = `
              <strong><i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
              ${tipo === 'success' ? 'Éxito' : 'Error'}:</strong> ${mensaje}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          `;
          
          document.body.appendChild(alertContainer);
          
          // Auto-cerrar después de 5 segundos
          setTimeout(() => {
              if (alertContainer.parentNode) {
                  bootstrap.Alert.getOrCreateInstance(alertContainer).close();
              }
          }, 5000);
      }

      function loadImage(event) {
          const file = event.target.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  document.getElementById('preview').src = e.target.result;
              };
              reader.readAsDataURL(file);
          }
      }

      // Hacer loadImage global para que funcione con el onchange del HTML
      window.loadImage = loadImage;

      // --- INICIALIZACIÓN ---
      console.log('Configurando página inicial...');
      document.getElementById('perfil-link').click();
  });
  </script>
</body>
</html>