<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Detalles del Caso</title>
  <link rel="stylesheet" href="../CSS/estilosDetalles.css">
  <link rel="stylesheet" href="../CSS/estilosIndex.css">
</head>

<body>
  <!--HEADER and navbar-->
  <header>
    <div class="navbar section-content">
      <a href="#" class="nav-logo">
        <img src="../IMG/logosinfondo.png" alt="img">
        <h2 class="logo-text">PANTRY</h2>
      </a>
      <ul class="nav-menu">
        <button id="menu-close-button" class="fas fa-times"></button>
        <li class="nav-item">
          <a href="#" class="nav-link">HOME</a>
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
          <a href="#" class="nav-link">PARTICIPATE</a>
          <ul class="submenu">
            <li><a href="#casos">DONATE</a></li>
            <li><a href="Voluntariados.php">VOLUNTEERING</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#opciones" class="nav-link">OPTIONS</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">INFO</a>
        </li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars"></button>
    </div>
  </header>

  <main class="content">
    <div class="titulo">
      <h2>Detalles del Caso</h2>
    </div>

    <section id="detalle-caso">
      <div id="detalle-info">
        <!-- Aquí se mostrará la información del caso -->
      </div>
    </section>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const urlParams = new URLSearchParams(window.location.search);
      const casoId = urlParams.get('ID');
      const tipo = urlParams.get('tipo');

      if (!casoId || !tipo) {
        document.getElementById('detalle-info').innerHTML = "<p>Error: faltan parámetros en la URL.</p>";
        return;
      }

      const endpoint = tipo === 'dinero' ?
        '/Pantry_Amigo/MVC/Vista/HTML/ObtenerDetallesDinero.php' :
        '/Pantry_Amigo/MVC/Vista/HTML/ObtenerDetallesRecursos.php';

      fetch(`${endpoint}?ID=${casoId}`)
        .then(response => response.json())
        .then(data => {
          const detalleInfo = document.getElementById('detalle-info');
          if (data.error) {
            detalleInfo.innerHTML = `<p>${data.error}</p>`;
          } else {
            const botones = `
              <div class="botones-detalle">
                ${tipo === 'dinero' ? `<button onclick="window.location.href='Donar.php?ID=${data.Caso_Id}&categoria=${encodeURIComponent(data.Caso_Cat_Nombre)}'">Donar</button>` : ''}
                ${data.Caso_Voluntariado == 1 ? `<button onclick="window.location.href='RegistrarVoluntario.php?ID=${data.Caso_Id}'">Voluntariado</button>` : ''}
              </div>`;

            // Cálculo de porcentaje de recaudación
            const recaudado = data.Caso_Monto_Recaudado;
            const meta = data.Caso_Monto_Meta;
            const porcentaje = (recaudado / meta) * 100;  // Calcula el porcentaje de recaudación

            // Barra de recaudación
            const barraRecaudacion = `
              <div class="barra-recaudacion">
                <div class="progreso" style="width: ${porcentaje}%;">${recaudado} / ${meta}</div>
              </div>
            `;

            const contenido = `
              <h3>${data.Caso_Nombre}</h3>
              <div class="imagen-container">
                <img src="/Pantry_Amigo/${data.Caso_Imagen}" alt="Imagen del caso" />
              </div>
              <p><strong>Descripción:</strong> ${data.Caso_Descripcion}</p>
              ${tipo === 'dinero'
                ? `
                  <p><strong>Monto Meta:</strong> $${data.Caso_Monto_Meta}</p>
                  <p><strong>Recaudado:</strong> $${recaudado}</p>
                  <p><strong>Fecha de Fin:</strong> ${data.Caso_Fecha_Fin}</p>
                  ${barraRecaudacion}
                `
                : `
                  <p><strong>Punto de Recolección:</strong> ${data.Caso_Punto_Recoleccion}</p>
                  <p><strong>Fecha de Inicio:</strong> ${data.Caso_Fecha_Inicio}</p>
                `
              }
              <p><strong>Estado:</strong> ${data.Caso_Estado}</p>
              <p><strong>Categoría:</strong> ${data.Caso_Cat_Nombre}</p>
              ${botones}`;

            detalleInfo.innerHTML = contenido;
          }
        })
        .catch(error => {
          document.getElementById('detalle-info').innerHTML = `<p>Error al cargar los detalles del caso.</p>`;
          console.error(error);
        });
    });
  </script>

  <style>
    .barra-recaudacion {
      width: 100%;
      background-color: #d9d9d9;
      border-radius: 10px;
      overflow: hidden;
      height: 25px;
      margin-top: 10px;
    }

    .progreso {
      font-family: 'Yusei Magic';
      height: 100%;
      background-color: #7ec8a1;
      color: #2b577d;
      text-align: center;
      padding: 0 10px 10px;
      line-height: 25px;
      white-space: nowrap;
    }
  </style>
</body>

</html>
