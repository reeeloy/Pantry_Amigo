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

      if (!casoId) {
        document.getElementById('detalle-info').innerHTML = "<p>Error: falta el parámetro del ID en la URL.</p>";
        return;
      }

      const endpoint = '/Pantry_Amigo/MVC/Vista/HTML/ObtenerDetallesDinero.php';

      fetch(`${endpoint}?ID=${casoId}`)
        .then(response => response.json())
        .then(data => {
          const detalleInfo = document.getElementById('detalle-info');
          if (data.error) {
            detalleInfo.innerHTML = `<p>${data.error}</p>`;
          } else {
            const botones = `
            <div class="botones-detalle">
              <button onclick="window.location.href='Donar.php?ID=${data.Caso_Id}&categoria=${encodeURIComponent(data.Caso_Cat_Nombre)}'">Donar</button>
              ${data.Caso_Voluntariado == 1 ? `<button onclick="window.location.href='RegistrarVoluntario.php?ID=${data.Caso_Id}'">Voluntariado</button>` : ''}
            </div>`;

            const contenido = `
          
          <div class="caso">
            <div class="info-caso">
             <h3>${data.Caso_Nombre}</h3>
             <p><strong>Descripción:</strong> ${data.Caso_Descripcion}</p>
             <div class="monto-caso">
              <p><strong>Monto Meta:</strong> ${data.Caso_Monto_Meta}</p>
             </div>    
             ${botones}          
           </div>

            <div class="imagen-container">
              <img src="/Pantry_Amigo/${data.Caso_Imagen}" alt="Imagen del caso" />
            </div>

            <div class="porcentaje">       
            <p><strong>Recaudado:</strong> $${data.Caso_Monto_Recaudado}</p>
            </div>        
          </div>

          <div class="detalles-caso-wrapper">
            <div class="detalles-header">
              <h4 class="margin"> Detalles del Caso</h4>
              <div class="num-id"> <p><strong>id:</strong> ${data.Caso_Id}</p> </div>
               line-----------------
            </div>

            <div class="detalles"> 

            <div class="detalles-caso-fundacion"> 
              <p> Esta causa es administrado por la <strong>Fundación: ${data.Fundacion_Nombre}</strong></p>
              <p> Quieres comunicarte con la fundacion? <br> <strong>Correo</strong> ${data.Fundacion_Correo}</p>
              <p><strong>Teléfono:</strong> ${data.Fundacion_Telefono}</p>
              <p><strong>Dirección:</strong> ${data.Fundacion_Direccion}</p>
            </div>
            
           <div class="detalles-caso-table">
            <div class="celda"> <p>Fecha de Inicio:</p> </div>
            <div class="celda-info"> <strong> ${data.Caso_Fecha_Inicio}</strong></div>

            <div class="celda"> <p>Fecha de Fin:</p> </div>
            <div class="celda-info"> <strong> ${data.Caso_Fecha_Fin}</strong></div>
             
            <div class="celda"> <p>Categoría:</p> </div>
            <div class="celda-info"> <strong> ${data.Caso_Cat_Nombre}</strong></div>

            <div class="celda"> <p>Voluntariado:</p> </div>
            <div class="celda-info"> <strong> ${data.Caso_Voluntariado == 1 ? 'Sí' : 'No'}</strong></div>

            </div>
          </div>             
        </div>
           `;

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
    .detalles-caso-wrapper { /*arreglar ancho*/
      background:rgb(255, 255, 255);
      padding: 30px 20px;
      width: 750px;
      margin: 20px auto 0 auto;
    }
    .detalles{
      background: #f9f9f9;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(60,60,60,0.08);
      padding: 30px 20px;
      width: 700px;
      margin: 20px auto 0 auto;
      display: flex;
       gap: 40px;
    }

   .detalles-caso-table {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(60,60,60,0.08);
  padding: 24px 20px;
  width: 320px;
  margin: 30px auto 0 auto;
  display: flex;
  flex-direction: column;
  gap: 0;
  border: 1px solid #eee;
}

.celda, .celda-info {
  display: flex;
  align-items: center;
  padding: 10px 0;
  border: none;
  font-size: 1rem;
}

.celda {
  color: #444;
  flex: 2;
  font-weight: 500;
  justify-content: flex-start;
}

.celda-info {
  color: #222;
  flex: 3;
  font-weight: bold;
  justify-content: flex-end;
}
  </style>

</body>

</html>