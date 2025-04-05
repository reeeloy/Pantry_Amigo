<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="estilos.css" />
  <style>/* Reset básico */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  color: #333;
}

.dashboard {
  display: flex;
  min-height: 100vh;
}

/* Sidebar */
.sidebar {
  width: 250px;
  background-color: #2c3e50;
  color: #fff;
  padding: 20px;
}

.sidebar .logo h1 {
  font-size: 24px;
  margin-bottom: 10px;
}

.sidebar .logo p {
  font-size: 14px;
  color: #ccc;
}

.sidebar .menu ul {
  list-style: none;
  margin-top: 20px;
}

.sidebar .menu ul li {
  margin: 15px 0;
}

.sidebar .menu ul li a {
  color: #fff;
  text-decoration: none;
  font-size: 16px;
  transition: color 0.3s ease;
  padding: 8px 12px;
  border-radius: 5px;
  display: block;
}

.sidebar .menu ul li a.active {
  color: #fff;
  font-weight: bold;
  background-color: #4CAF50;
  position: relative;
}

.sidebar .menu ul li a.active::before {
  content: '';
  position: absolute;
  left: -10px;
  top: 0;
  height: 100%;
  width: 5px;
  background-color: #2ecc71;
  border-radius: 5px 0 0 5px;
}

.sidebar .menu ul li a:hover {
  color: #4CAF50;
}

/* Contenido Principal */
.content {
  flex: 1;
  padding: 20px;
  background-color: #fff;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.header h2 {
  font-size: 24px;
}

.new-case-button {
  background-color: #4CAF50;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}
.new-case-button::before {
  content: "➕ ";
}

.new-case-button:hover {
  background-color: #45a049;
}

/* Sección de Casos */
.cases {
  margin-bottom: 30px;
}

.case {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}
.case:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.case h3 {
  font-size: 18px;
  margin-bottom: 5px;
}

.case p {
  font-size: 14px;
  color: #555;
}

/* Horarios Asignados */
.assigned-schedules {
  margin-bottom: 30px;
}

.schedule {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}
.schedule:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.schedule h4 {
  font-size: 16px;
  margin-bottom: 5px;
}

.schedule p {
  font-size: 14px;
  color: #555;
}

/* Tabla de Análisis */
.analysis-table {
  margin-bottom: 30px;
}

.analysis-table h3 {
  font-size: 20px;
  margin-bottom: 10px;
}

.analysis-table table {
  width: 100%;
  border-collapse: collapse;
}

.analysis-table th,
.analysis-table td {
  padding: 10px;
  border: 1px solid #ddd;
  text-align: left;
}

.analysis-table th {
  background-color: #f4f4f4;
  font-weight: bold;
}

/* Estilos para secciones */
.seccion-activa {
  display: block;
}

.seccion-oculta {
  display: none;
}

/* Estilos para la lista de voluntarios */
.voluntario {
  background-color: #f9f9f9;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}
.voluntario:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.voluntario p {
  margin: 0;
  font-size: 14px;
  color: #555;
}

/* Botones */
#agregar-voluntario-button,
#asignar-Horario-button {
  background-color: #4CAF50;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 20px;
}
#agregar-voluntario-button::before {
  content: "👥 ";
}
#asignar-Horario-button::before {
  content: "🕒 ";
}
#agregar-voluntario-button:hover,
#asignar-Horario-button:hover {
  background-color: #45a049;
}

/* Notificaciones */
.notificacion {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.notificacion h4 {
  font-size: 16px;
  margin-bottom: 5px;
  color: #333;
}

.notificacion p {
  font-size: 14px;
  color: #555;
  margin-bottom: 5px;
}

.notificacion small {
  font-size: 12px;
  color: #888;
}

/* Sección de Ayuda */
#ayuda {
  max-width: 800px;
  margin: 0 auto;
}

.faq {
  margin-bottom: 30px;
}

.faq h4 {
  font-size: 20px;
  margin-bottom: 15px;
  color: #333;
}

.pregunta {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.pregunta p {
  font-size: 14px;
  color: #555;
  margin-bottom: 5px;
}

.pregunta p strong {
  color: #333;
}

.contacto-soporte {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.contacto-soporte h4 {
  font-size: 20px;
  margin-bottom: 15px;
  color: #333;
}

.contacto-soporte p {
  font-size: 14px;
  color: #555;
  margin-bottom: 10px;
}

.contacto-soporte ul {
  list-style: none;
  padding: 0;
}

.contacto-soporte ul li {
  font-size: 14px;
  color: #555;
  margin-bottom: 5px;
}

.contacto-soporte ul li strong {
  color: #333;
}

/* Logo */
.logo-img {
  width: 170px;
  height: auto;
  margin-bottom: 10px;
  margin-left: 20px;
}

/* Botón para eliminar caso */
.eliminar-caso {
  background-color: #e74c3c;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
  margin-top: 10px;
}
.eliminar-caso::before {
  content: "🗑 ";
}
.eliminar-caso:hover {
  background-color: #c0392b;
}

.actualizar-caso::before {
  content: "✏️ ";
}

/* Contenedor crear caso */
.crear-casos {
  padding: 10px;
  display: flex;
  justify-content: end;
  gap: 10px;
}

/* Modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  margin: 10% auto;
  padding: 20px;
  border-radius: 5px;
  width: 60%;
  max-width: 600px;
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover {
  color: #000;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input,
.form-group textarea,
.form-group select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.form-buttons {
  text-align: right;
  margin-top: 20px;
}

.actualizar-caso {
  background-color: #4CAF50;
  color: white;
  margin-right: 10px;
}

.eliminar-caso,
.actualizar-caso-btn {
  margin-right: 10px;
}

/* Responsividad */
@media (max-width: 768px) {
  .dashboard {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    text-align: center;
  }

  .content {
    padding: 10px;
  }
}
</style>
</head>
<body>
  <div class="dashboard">
    <div class="sidebar">
      <img src="logo.png" alt="Logo" class="logo-img" />
      <div class="logo">
        <h1>Pantry Amigo</h1>
        <p>Fundación</p>
      </div>
      <div class="menu">
        <ul>
          <li><a href="#" onclick="mostrarSeccion('overview')">🏠 Overview</a></li>
          <li><a href="#" onclick="mostrarSeccion('casos')" class="active">📁 Casos</a></li>
          <li><a href="#" onclick="mostrarSeccion('voluntarios')">👥 Voluntarios</a></li>
          <li><a href="#" onclick="mostrarSeccion('donaciones')">💰 Donaciones</a></li>
          <li><a href="#" onclick="mostrarSeccion('participacion')">🤝 Participación</a></li>
          <li><a href="#" onclick="mostrarSeccion('ayuda')">❓ Ayuda</a></li>
          <li><a href="logout.php">🚪 Cerrar sesión</a></li>
        </ul>
      </div>
    </div>
    <div class="content">
      <div class="header">
        <h2>Casos Activos</h2>
        <button class="new-case-button" onclick="abrirModal()">Nuevo Caso</button>
      </div>

      <div id="overview" class="seccion-oculta">
        <p>Contenido de overview...</p>
      </div>

      <div id="casos" class="seccion-activa">
        <div class="crear-casos">
          <button id="asignar-Horario-button">Asignar horario</button>
          <button id="agregar-voluntario-button">Agregar voluntario</button>
        </div>
        <div class="cases">
          <!-- Casos dinámicos aquí -->
        </div>
        <div class="assigned-schedules">
          <!-- Horarios asignados aquí -->
        </div>
        <div class="analysis-table">
          <!-- Tabla de análisis aquí -->
        </div>
      </div>

      <div id="voluntarios" class="seccion-oculta">
        <!-- Lista de voluntarios aquí -->
      </div>

      <div id="donaciones" class="seccion-oculta">
        <!-- Donaciones -->
      </div>

      <div id="participacion" class="seccion-oculta">
        <!-- Participación -->
      </div>

      <div id="ayuda" class="seccion-oculta">
        <div class="faq">
          <h4>Preguntas Frecuentes</h4>
          <div class="pregunta">
            <p><strong>¿Cómo agrego un caso nuevo?</strong></p>
            <p>Haz clic en el botón "Nuevo Caso" y completa el formulario.</p>
          </div>
          <div class="pregunta">
            <p><strong>¿Cómo veo los horarios asignados?</strong></p>
            <p>Ve a la sección de "Casos" y revisa la lista bajo "Horarios Asignados".</p>
          </div>
        </div>
        <div class="contacto-soporte">
          <h4>Soporte Técnico</h4>
          <p>Si necesitas ayuda adicional, contacta con nuestro equipo:</p>
          <ul>
            <li><strong>Email:</strong> soporte@pantryamigo.org</li>
            <li><strong>Teléfono:</strong> +34 600 123 456</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="modalFormulario" class="modal">
    <div class="modal-content">
      <span class="close" onclick="cerrarModal()">&times;</span>
      <form id="formularioCaso">
        <div class="form-group">
          <label for="titulo">Título del caso</label>
          <input type="text" id="titulo" name="titulo" required />
        </div>
        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="form-group">
          <label for="categoria">Categoría</label>
          <select id="categoria" name="categoria">
            <option value="dinero">Dinero</option>
            <option value="recursos">Recursos</option>
          </select>
        </div>
        <div class="form-buttons">
          <button type="submit" class="actualizar-caso">Crear Caso</button>
        </div>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
