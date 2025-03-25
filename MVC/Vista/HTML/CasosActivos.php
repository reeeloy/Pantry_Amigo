<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Casos de Donación</title>
  <link rel="stylesheet" href="/Pantry-amigo/MVC/Vista/CSS/estiloDashboard.css">
</head>

<body>
  <div class="dashboard">
    <main class="content">
      <header class="header">
        <h2>Casos de Donación</h2>
      </header>

      <!-- Sección de Casos -->
      <section id="casos" class="seccion-activa">
        <div class="cases" id="lista-casos">
          <!-- Aquí se cargarán los casos dinámicamente -->
        </div>
      </section>
    </main>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      cargarCasos();
    });

    function cargarCasos() {
      fetch('/Pantry-amigo/MVC/Vista/HTML/obtener_casos.php')
        .then(response => response.json())
        .then(data => {
          const listaCasos = document.getElementById('lista-casos');
          listaCasos.innerHTML = '';
          data.forEach(caso => {
            const casoHTML = `
              <div class="case">
                <h3>${caso.Caso_Nombre_Caso}</h3>
                <p><strong>${caso.Caso_Descripcion}</strong></p>
                <p>ID: ${caso.Caso_Id}</p>
                <p>Estado: ${caso.Caso_Estado == 1 ? 'Activo' : 'Inactivo'}</p>
                <p>Fecha de inicio: ${caso.Caso_Fecha_Inicio}</p>
                <p>Fecha de fin: ${caso.Caso_Fecha_Fin}</p>
                <button id="DetallesCaso" onclick="window.location.href='Detalles.php?ID=${caso.Caso_Id}'">Ver detalles </button>
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
  </script>
</body>

</html>
