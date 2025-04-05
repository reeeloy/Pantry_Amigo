<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Casos de Donación</title>
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/estiloDashboard.css">
  <link rel="stylesheet" href="../CSS/estilosCasosActivos.css">
</head>
<body>
  <div class="dashboard">
    <main class="content">
      <header class="header">
        <h2>Casos de Donación</h2>
      </header>

      <!-- Botones para seleccionar el tipo de caso -->
      <div class="botones">
        <button onclick="cargarCasos('dinero')">Casos de Dinero</button>
        <button onclick="cargarCasos('recursos')">Casos de Recursos</button>
      </div>

      <!-- Sección de Casos -->
      <section id="casos" class="seccion-activa">
        <div class="cases" id="lista-casos">
          <!-- Aquí se cargarán los casos dinámicamente -->
        </div>
      </section>
    </main>
  </div>

  <script>
    function cargarCasos(tipo) {
      let url = tipo === 'dinero' 
        ? '/Pantry_Amigo/MVC/Vista/HTML/ObtenerCasosDinero.php' 
        : '/Pantry_Amigo/MVC/Vista/HTML/ObtenerCasosRecursos.php';

      fetch(url)
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
                <p> IMG: ${caso.Caso_Imagen}</p>
                <p><strong>${caso.Caso_Descripcion}</strong></p>
                <p>ID: ${caso.Caso_Id}</p>
                <p>Descripcion: ${caso.Caso_Descripcion}</p>
                <p>Categoria: ${caso.Caso_Cat_Nombre}</p>
                <button onclick="window.location.href='Detalles.php?ID=${caso.Caso_Id}'">Ver detalles</button>
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

    // Cargar casos de dinero por defecto al abrir la página
    document.addEventListener("DOMContentLoaded", () => cargarCasos('dinero'));
  </script>
</body>
</html>

