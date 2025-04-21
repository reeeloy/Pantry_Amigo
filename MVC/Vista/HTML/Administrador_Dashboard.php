<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Administrador</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/estiloAdmin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

      <!-- Sección Gestionar Fundaciones -->
      <section id="gestion-fundaciones" class="seccion-activa">
        <div class="search-bar">
          <input type="text" id="filtro-fundacion" placeholder="Buscar fundación por nombre o NIT">
          <button id="btn-filtrar-fundacion">Filtrar</button>
        </div>
        <div id="lista-fundaciones">
          <!-- Aquí se cargarán las fundaciones dinámicamente -->
        </div>
      </section>

      <!-- Sección Casos de Donación -->
      <section id="casos" class="seccion-oculta">
        <h3>Casos de Donación</h3>
        <div id="barra-progreso-casos"></div>
        <div id="lista-casos-donacion"></div>
      </section>

      <!-- Sección Donaciones en Dinero -->
      <section id="donaciones-dinero" class="seccion-oculta">
        <h3>Consulta Donaciones en Dinero</h3>
        <div id="lista-donaciones-dinero"></div>
      </section>

      <!-- Sección Donaciones en Recursos -->
      <section id="donaciones-recursos" class="seccion-oculta">
        <h3>Consulta Donaciones en Recursos</h3>
        <div id="lista-donaciones-recursos"></div>
      </section>
    </main>
  </div>

  <!-- Script para navegación -->
  <script>
    const secciones = {
      'gestion-fundaciones-link': 'gestion-fundaciones',
      'casos-link': 'casos',
      'donaciones-dinero-link': 'donaciones-dinero',
      'donaciones-recursos-link': 'donaciones-recursos'
    };

    const tituloSeccion = document.getElementById('titulo-seccion');

    Object.keys(secciones).forEach(linkId => {
      document.getElementById(linkId).addEventListener('click', () => {
        Object.values(secciones).forEach(sec => {
          document.getElementById(sec).classList.add('seccion-oculta');
        });

        const seccionId = secciones[linkId];
        document.getElementById(seccionId).classList.remove('seccion-oculta');
        document.getElementById(seccionId).classList.add('seccion-activa');

        const texto = document.getElementById(linkId).textContent;
        tituloSeccion.textContent = texto;

        document.querySelectorAll('.menu a').forEach(a => a.classList.remove('active'));
        document.getElementById(linkId).classList.add('active');
      });
    });

    // Función para cargar fundaciones (JS Fetch con íconos integrados)
    function cargarFundaciones() {
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_fundaciones.php')
        .then(response => response.json())
        .then(data => {
          const lista = document.getElementById('lista-fundaciones');
          lista.innerHTML = '';

          if (data.error) {
            lista.innerHTML = `<p>Error: ${data.error}</p>`;
            return;
          }

          data.forEach(fundacion => {
            const div = document.createElement('div');
            div.classList.add('fundacion');
            div.innerHTML = `
              <h3><i class="fas fa-building"></i> ${fundacion.Nombre}</h3>
              <p><i class="fas fa-envelope"></i> ${fundacion.Correo}</p>
              <p><i class="fas fa-phone"></i> ${fundacion.Telefono}</p>
              <button onclick="eliminarFundacion(${fundacion.ID})"><i class="fas fa-trash-alt"></i> Eliminar</button>
              <button onclick="editarFundacion(${fundacion.ID})"><i class="fas fa-edit"></i> Actualizar</button>
            `;
            lista.appendChild(div);
          });
        });
    }

    function eliminarFundacion(id) {
      if (!confirm("¿Seguro que deseas eliminar esta fundación?")) return;

      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_fundacion.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
          alert(data.message);
          cargarFundaciones();
        });
    }

    // Llamar función al cargar la página
    window.onload = () => {
      cargarFundaciones();
    };
  </script>
</body>
</html>
