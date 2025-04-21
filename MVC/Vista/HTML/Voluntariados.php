<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voluntariados</title>
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
      <h2>Voluntariados</h2>
    </div>


    <!-- Sección de Casos -->
    <section id="casos" class="seccion-activa">
      <div class="cases" id="lista-casos">
        <!-- Aquí se cargarán los casos dinámicamente -->
      </div>
    </section>
  </main>

  <script>
    function cargarVoluntariados() {
  fetch('/Pantry_Amigo/MVC/Vista/HTML/ObtenerVoluntariados.php')
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      if (!Array.isArray(data)) {
        throw new Error('Respuesta no válida del servidor');
      }

      const listaCasos = document.getElementById('lista-casos');
      listaCasos.innerHTML = '';

      data.forEach(caso => {
        const casoHTML = `
          <div class="case">
            <h3>${caso.Caso_Nombre}</h3>
            <img src="/Pantry_Amigo/${caso.Caso_Imagen}" alt="Imagen del caso">
            <p>ID: ${caso.Caso_Id}</p>
            <p>Descripción: ${caso.Caso_Descripcion}</p>
            <p>Categoría: ${caso.Caso_Cat_Nombre}</p>
            <button onclick="window.location.href='Detalles.php?ID=${caso.Caso_Id}&tipo=${caso.tipo}'">Ver detalles</button>
          </div>
        `;
        listaCasos.insertAdjacentHTML('beforeend', casoHTML);
      });
    })
    .catch(error => {
      console.error('Error al cargar los casos:', error);
      document.getElementById('lista-casos').innerHTML = '<p>Error al cargar los casos.</p>';
    });
}
document.addEventListener("DOMContentLoaded", () => cargarVoluntariados());

  </script>

</body>

</html>