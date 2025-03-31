<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/estiloDashboard.css">
</head>

<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="/Pantry_Amigo/MVC/Vista/IMG/Logo_Pantry-amigo.png" alt="Logo de la empresa" class="logo-img">
      </div>
      <nav class="menu">
        <ul>
          <li><a href="../../../MVC/Vista/HTML/from_Fundacion.php" id="perfil-link">Perfil</a></li>
          <li><a href="#" id="casos-link" class="active">Casos</a></li>
          <li><a href="#" id="voluntarios-link">Voluntarios</a></li>
          <li><a href="#" id="consultar-link">Consultar</a></li>
          <li><a href="#" id="ayuda-link">Ayuda</a></li>
          <li><a href="#" id="salir-link">Salir</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Contenido Principal -->
    <main class="content">
      <header class="header">
        <h2 id="titulo-seccion">Casos</h2>
        <button class="new-case-button" id="nuevo-caso-button" onclick="window.location.href='RegistrarCaso.php'">Nuevo caso de donación</button>
      </header>

      <!-- Sección de Casos (Visible por defecto) -->
      <section id="casos" class="seccion-activa">
        <!-- Barra de búsqueda para filtrar por ID -->
        <div class="search-bar">
          <input type="text" id="filtro-id" placeholder="Ingrese el ID del caso">
          <button id="btn-filtrar">Filtrar</button>
        </div>

        <div class="cases" id="lista-casos">
          <!-- Aquí se cargarán los casos dinámicamente -->
        </div>

        <!-- Horarios Asignados -->
        <section class="assigned-schedules">
          <h3>Horarios asignados</h3>
          <div id="horarios-asignados">
            <!-- Aquí se cargarán los horarios dinámicamente -->
          </div>
        </section>
      </section>

      <!-- Sección de Voluntarios (Oculta por defecto) -->
      <section id="voluntarios" class="seccion-oculta">
        <h3>Lista de Voluntarios</h3>
        <!-- Barra de búsqueda para filtrar voluntarios por Caso ID -->
        <div class="search-bar">
          <input type="text" id="filtro-voluntario-id" placeholder="Ingrese el ID del caso">
          <button id="btn-filtrar-voluntario">Filtrar</button>
        </div>
        <div id="lista-voluntarios">
          <!-- Aquí se cargarán los voluntarios dinámicamente -->
        </div>
        <button id="agregar-voluntario-button" onclick="window.location.href='RegistrarVoluntario.php'">Agregar Voluntario</button>
      </section>

      <!-- Sección de Ayuda (Oculta por defecto) -->
      <section id="ayuda" class="seccion-oculta">
        <h3>Ayuda</h3>
        <div class="faq">
          <h4>Preguntas Frecuentes</h4>
          <div class="pregunta">
            <p><strong>¿Cómo puedo agregar un nuevo caso?</strong></p>
            <p>Para agregar un nuevo caso, haz clic en el botón "Nuevo caso de donación" en la sección de Casos.</p>
          </div>
          <div class="pregunta">
            <p><strong>¿Cómo gestiono a los voluntarios?</strong></p>
            <p>En la sección de Voluntarios, puedes ver la lista de voluntarios y agregar nuevos.</p>
          </div>
          <div class="pregunta">
            <p><strong>¿Qué hago si tengo un problema técnico?</strong></p>
            <p>Contacta al soporte técnico a través del correo: soporte@fundacion.com.</p>
          </div>
        </div>
        <div class="contacto-soporte">
          <h4>Contactar al Soporte</h4>
          <p>Si necesitas ayuda adicional, no dudes en contactarnos:</p>
          <ul>
            <li><strong>Email:</strong> soporte@fundacion.com</li>
            <li><strong>Teléfono:</strong> +123 456 7890</li>
          </ul>
        </div>
      </section>
    </main>
  </div>

  <!-- Script para manejar la navegación, carga/filtrado de datos y eliminación de casos -->
  <script>
    // Seleccionar elementos del DOM
    const perfilLink = document.getElementById('perfil-link');
    const casosLink = document.getElementById('casos-link');
    const voluntariosLink = document.getElementById('voluntarios-link');
    const ayudaLink = document.getElementById('ayuda-link');
    const salirLink = document.getElementById('salir-link');

    const casosSection = document.getElementById('casos');
    const voluntariosSection = document.getElementById('voluntarios');
    const ayudaSection = document.getElementById('ayuda');
    const tituloSeccion = document.getElementById('titulo-seccion');
    const listaCasos = document.getElementById('lista-casos');
    const listaVoluntarios = document.getElementById('lista-voluntarios');
    const filtroInput = document.getElementById('filtro-id');
    const btnFiltrar = document.getElementById('btn-filtrar');

    let casosData = []; // Variable para almacenar los casos cargados

    // Función para cargar casos desde PHP
    function cargarCasos() {
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos.php')
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.statusText}`);
          }
          return response.json();
        })
        .then(data => {
          if (data.error) {
            listaCasos.innerHTML = `<p>Error: ${data.error}</p>`;
            return;
          }
          casosData = data; // Almacenar la data original
          mostrarCasos(casosData);
        })
        .catch(error => {
          console.error('Error al cargar los casos:', error);
          listaCasos.innerHTML = `<p>Error al cargar los casos: ${error.message}</p>`;
        });
    }

    // Función para mostrar casos en la interfaz
    function mostrarCasos(casos) {
      listaCasos.innerHTML = ''; // Limpiar el contenedor
      casos.forEach(caso => {
        // Se utiliza "Caso_Id" y "Caso_Estado" para mostrar información
        const estado = caso.Caso_Estado;
        const casoHTML = `
          <div class="case" id="caso-${caso.Caso_Id}" data-id="${caso.Caso_Id}">
            <h3>${caso.Caso_Nombre_Caso}</h3>
            <p><strong>${caso.Caso_Descripcion}</strong></p>
            <p>ID: ${caso.Caso_Id}</p>
            <p>Estado: ${estado}</p>
            <p>Fecha de inicio: ${caso.Caso_Fecha_Inicio}</p>
            <p>Fecha de fin: ${caso.Caso_Fecha_Fin}</p>
            <button class="eliminar-caso" data-caso-id="${caso.Caso_Id}">Eliminar caso</button>
          </div>
        `;
        listaCasos.insertAdjacentHTML('beforeend', casoHTML);
      });

      // Añadir event listeners para los botones de eliminar
      document.querySelectorAll('.eliminar-caso').forEach(button => {
        button.addEventListener('click', function() {
          const casoId = this.getAttribute('data-caso-id');
          if (confirm("¿Estás seguro de eliminar este caso?")) {
            eliminarCaso(casoId);
          }
        });
      });
    }

    // Función para filtrar los casos por ID
    function filtrarCasosPorID() {
      const filtro = filtroInput.value.trim();
      if (filtro === '') {
        mostrarCasos(casosData);
        return;
      }
      const casosFiltrados = casosData.filter(caso => String(caso.Caso_Id) === filtro);
      mostrarCasos(casosFiltrados);
    }

    // Función para eliminar un caso
    function eliminarCaso(casoId) {
      fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso.php?caso_id=${encodeURIComponent(casoId)}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Remover el caso del DOM
            const casoElemento = document.getElementById('caso-' + casoId);
            if (casoElemento) {
              casoElemento.remove();
            }
            alert(data.message);
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch(error => {
          console.error("Error al eliminar el caso:", error);
          alert("Ocurrió un error al eliminar el caso.");
        });
    }

    // Función para mostrar la sección de casos
    function mostrarCasosSeccion() {
      casosSection.classList.remove('seccion-oculta');
      casosSection.classList.add('seccion-activa');
      voluntariosSection.classList.remove('seccion-activa');
      voluntariosSection.classList.add('seccion-oculta');
      ayudaSection.classList.remove('seccion-activa');
      ayudaSection.classList.add('seccion-oculta');
      tituloSeccion.textContent = 'Casos';
      cargarCasos();
      resaltarOpcion(casosLink);
    }

    // Función para mostrar la sección de voluntarios
    function mostrarVoluntarios() {
      voluntariosSection.classList.remove('seccion-oculta');
      voluntariosSection.classList.add('seccion-activa');
      casosSection.classList.remove('seccion-activa');
      casosSection.classList.add('seccion-oculta');
      ayudaSection.classList.remove('seccion-activa');
      ayudaSection.classList.add('seccion-oculta');
      tituloSeccion.textContent = 'Voluntarios';
      cargarVoluntarios();
      resaltarOpcion(voluntariosLink);
    }

    // Función para mostrar la sección de ayuda
    function mostrarAyuda() {
      ayudaSection.classList.remove('seccion-oculta');
      ayudaSection.classList.add('seccion-activa');
      casosSection.classList.remove('seccion-activa');
      casosSection.classList.add('seccion-oculta');
      voluntariosSection.classList.remove('seccion-activa');
      voluntariosSection.classList.add('seccion-oculta');
      tituloSeccion.textContent = 'Ayuda';
      resaltarOpcion(ayudaLink);
    }

    // Función para resaltar la opción seleccionada
    function resaltarOpcion(link) {
      const menuLinks = [perfilLink, casosLink, voluntariosLink, ayudaLink, salirLink];
      menuLinks.forEach(menuLink => menuLink.classList.remove('active'));
      link.classList.add('active');
    }

    // Event listener para el botón de filtrar casos
    btnFiltrar.addEventListener('click', filtrarCasosPorID);

    // Event listeners para navegación
    perfilLink.addEventListener('click', () => {
      mostrarCasosSeccion();
      resaltarOpcion(perfilLink);
    });
    casosLink.addEventListener('click', mostrarCasosSeccion);
    voluntariosLink.addEventListener('click', mostrarVoluntarios);
    ayudaLink.addEventListener('click', mostrarAyuda);
    salirLink.addEventListener('click', () => {
      alert('Cerrando sesión...');
      // Lógica para cerrar sesión
    });

    // Función para cargar voluntarios desde PHP
    function cargarVoluntarios() {
      fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_voluntarios.php')
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.statusText}`);
          }
          return response.json();
        })
        .then(data => {
          listaVoluntarios.innerHTML = ''; // Limpiar el contenedor
          if (data.error) {
            listaVoluntarios.innerHTML = `<p>Error: ${data.error}</p>`;
            return;
          }
          data.forEach(voluntario => {
            const voluntarioHTML = `
              <div class="voluntario">
                <p><strong>${voluntario.Vol_Nombre} ${voluntario.Vol_Apellido}</strong></p>
                <p>Correo: ${voluntario.Vol_Correo}</p>
                <p>Celular: ${voluntario.Vol_Celular}</p>
                <p>Caso asignado: ${voluntario.Vol_Caso_Id}</p>
                <button id="asignar-Horario-button" onclick="window.location.href='RegistrarHorario.php?cedula=${voluntario.Vol_Cedula}'">Asignar horario</button>
              </div>
            `;
            listaVoluntarios.insertAdjacentHTML('beforeend', voluntarioHTML);
          });
        })
        .catch(error => {
          listaVoluntarios.innerHTML = `<p>Error al cargar los voluntarios: ${error.message}</p>`;
        });
    }

    // Mostrar la sección de casos por defecto
    mostrarCasosSeccion();
  </script>
  
</body>
</html>
