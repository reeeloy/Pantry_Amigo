<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalles del Caso</title>
  <link rel="stylesheet" href="../CSS/estilosDetalles.css">
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
      const tipo = urlParams.get('tipo'); // 'dinero' o 'recursos'

      if (!casoId || !tipo) {
        document.getElementById('detalle-info').innerHTML = "<p>Error: faltan parámetros en la URL.</p>";
        return;
      }

      const endpoint = tipo === 'dinero'
        ? '/Pantry_Amigo/MVC/Vista/HTML/ObtenerDetallesDinero.php'
        : '/Pantry_Amigo/MVC/Vista/HTML/ObtenerDetallesRecursos.php';

      fetch(`${endpoint}?ID=${casoId}`)
        .then(response => response.json())
        .then(data => {
          const detalleInfo = document.getElementById('detalle-info');
          if (data.error) {
            detalleInfo.innerHTML = `<p>${data.error}</p>`;
          } else {
            if (tipo === 'dinero') {
              detalleInfo.innerHTML = `
                <h3>${data.Caso_Nombre}</h3>
                <img src="/Pantry_Amigo/${data.Caso_Imagen}" alt="Imagen del caso" style="max-width: 300px;">
                <p><strong>Descripción:</strong> ${data.Caso_Descripcion}</p>
                <p><strong>Monto Meta:</strong> $${data.Caso_Monto_Meta}</p>
                <p><strong>Recaudado:</strong> $${data.Caso_Monto_Recaudado}</p>
                <p><strong>Fecha de Fin:</strong> ${data.Caso_Fecha_Fin}</p>
                <p><strong>Estado:</strong> ${data.Caso_Estado}</p>
                <p><strong>Categoria:</strong> ${data.Caso_Cat_Nombre}</p>
              `;
            } else {
              detalleInfo.innerHTML = `
                <h3>${data.Caso_Nombre}</h3>
                <img src="/Pantry_Amigo/Assets/imagenes_casos/${data.Caso_Imagen}" alt="Imagen del caso" style="max-width: 300px; border-radius: 10px; margin-bottom: 10px;" />
                <p><strong>Descripción:</strong> ${data.Caso_Descripcion}</p>
                <p><strong>Punto de Recolección:</strong> ${data.Caso_Punto_Recoleccion}</p>
                <p><strong>Fecha de Inicio:</strong> ${data.Caso_Fecha_Inicio}</p>
                <p><strong>Estado:</strong> ${data.Caso_Estado}</p>
                <p><strong>Categoria:</strong> ${data.Caso_Cat_Nombre}</p>
              `;
            }
          }
        })
        .catch(error => {
          document.getElementById('detalle-info').innerHTML = `<p>Error al cargar los detalles del caso.</p>`;
          console.error(error);
        });
    });
  </script>
</body>
</html>


