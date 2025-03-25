<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalles del Caso</title>
  <link rel="stylesheet" href="/Pantry-amigo/MVC/Vista/CSS/estiloDashboard.css">
</head>

<body>
  <div class="dashboard">
    <main class="content">
      <header class="header">
        <h2>Detalles del Caso</h2>
      </header>

      <section id="detalle-caso">
        <div id="detalle-info">
          <!-- Aquí se mostrará la información del caso -->
        </div>
      </section>
    </main>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      const casoId = urlParams.get('ID');

      if (casoId) {
        cargarDetalleCaso(casoId);
      } else {
        document.getElementById('detalle-info').innerHTML = "<p>Error: No se especificó un caso.</p>";
      }
    });

    function cargarDetalleCaso(id) {
        fetch(`/Pantry-amigo/MVC/Vista/HTML/obtener_detalle_caso.php?ID=${id}`)
        .then(response => response.json())
        .then(data => {
          const detalleInfo = document.getElementById('detalle-info');

          if (data.error) {
            detalleInfo.innerHTML = `<p>${data.error}</p>`;
          } else {
            detalleInfo.innerHTML = `
              <h3>${data.Caso_Nombre_Caso}</h3>
              <p><strong>Descripción:</strong> ${data.Caso_Descripcion}</p>
              <p><strong>Fecha de inicio:</strong> ${data.Caso_Fecha_Inicio}</p>
              <p><strong>Fecha de fin:</strong> ${data.Caso_Fecha_Fin}</p>
              <p><strong>Estado:</strong> ${data.Caso_Estado == 1 ? 'Activo' : 'Inactivo'}</p>
            `;
          }
        })
        .catch(error => {
          console.error('Error al cargar los detalles del caso:', error);
          document.getElementById('detalle-info').innerHTML = '<p>Error al cargar los detalles del caso.</p>';
        });
    }
  </script>
</body>

</html>
