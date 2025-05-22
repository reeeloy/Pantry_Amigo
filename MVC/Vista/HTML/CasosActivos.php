<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Casos de Donación</title>
  <link rel="stylesheet" href="../CSS/estilosCasosActivos.css">
</head>

<body>
  <header>
    <div class="navbar section-content">
      <a href="#" class="nav-logo">
        <img src="../IMG/logosinfondo.png" alt="img">
        <h2 class="logo-text">PANTRY</h2>
      </a>
      <ul class="nav-menu">
        <button id="menu-close-button" class="fas fa-times"></button>
        <li class="nav-item">
          <a href="../HTML/index.Php" class="nav-link">HOME</a>
        </li>
        <li class="nav-item">
          <a href="#sobre-nosotros" class="nav-link">ABOUT US</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link">ACOUNT</a>
          <ul class="submenu">
            <li><a href="../HTML/registro.php">SIGN UP</a></li>
            <li><a href="../HTML/login.php">LOGIN</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="../HTML/ConsultarFundacion.php" class="nav-link">COLABORATORS</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">INFO</a>
        </li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars"></button>

    </div>
  </header>


  <main class="content">
    <div class="section-title">
      <h2>Casos De Donacion</h2>
    </div>

    <!-- Filtro por Categoría -->
    <div class="botones">
      <!-- Select oculto al principio -->
       <label for="filtro-categoria">Filtrar por categoría:</label>
       <select id="filtro-categoria" onchange="filtrarPorCategoria(this.value)">
        <option value="">Seleccione una categoría</option>
        <option value="Salud">Salud</option>
        <option value="Educación">Educación</option>
        <option value="Alimentación">Alimentación</option>
        <option value="Emergencias">Emergencias</option>
        <option value="Tecnología">Tecnología</option>
        <option value="Medio Ambiente">Medio Ambiente</option>

      </select>
    </div>

    <!-- Sección de Casos -->
    <section id="casos" class="seccion-activa">
      <div class="cases" id="lista-casos">
        <!-- Aquí se cargarán los casos dinámicamente -->
      </div>
    </section>
  </main>

  <script>
  let todosLosCasos = []; // Variable global para guardar todos los casos

  function cargarCasos() {
    fetch('/Pantry_Amigo/MVC/Vista/HTML/ObtenerCasosDinero.php')
      .then(response => {
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        return response.json();
      })
      .then(data => {
        if (!Array.isArray(data)) throw new Error('La respuesta no es un array');

        todosLosCasos = data; // Guardamos todos los casos para filtrar localmente
        mostrarCasos(data);
      })
      .catch(error => {
        console.error('Error al cargar los casos:', error);
        document.getElementById('lista-casos').innerHTML = '<p>Error al cargar los casos.</p>';
      });
  }

  function mostrarCasos(casos) {
    const listaCasos = document.getElementById('lista-casos');
    listaCasos.innerHTML = '';

    if (casos.length === 0) {
      listaCasos.innerHTML = '<p>No hay casos en esta categoría.</p>';
      return;
    }

    casos.forEach(caso => {
      const casoHTML = `
        <div class="case">
          <h3>${caso.Caso_Nombre}</h3>
          <img src="/Pantry_Amigo/${caso.Caso_Imagen}" alt="Imagen del caso">
          <p>ID: ${caso.Caso_Id}</p>
          <p>Descripción: ${caso.Caso_Descripcion}</p>
          <p>Categoría: ${caso.Caso_Cat_Nombre}</p>
          <button onclick="window.location.href='Detalles.php?ID=${caso.Caso_Id}&tipo=dinero'">Ver detalles</button>
        </div>
      `;
      listaCasos.insertAdjacentHTML('beforeend', casoHTML);
    });
  }

  function filtrarPorCategoria(categoria) {
    if (!categoria) {
      mostrarCasos(todosLosCasos); // Mostrar todos si no hay categoría seleccionada
    } else {
      const filtrados = todosLosCasos.filter(caso => caso.Caso_Cat_Nombre === categoria);
      mostrarCasos(filtrados);
    }
  }
  // Carga inicial
  document.addEventListener("DOMContentLoaded", cargarCasos);
</script>


</body>

</html> 