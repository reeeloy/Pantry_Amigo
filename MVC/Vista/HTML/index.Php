<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Importación correcta de íconos de Google Fonts -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&family=Material+Symbols+Rounded&display=swap">
  <!-- link swiper-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <title>Pantry Amigo</title>
  <link rel="stylesheet" href="../CSS/Home1.css">
  <style>
    /* Estilos adicionales para la sección "Sobre Nosotros" */
    .sobre-nosotros {
      background-color: #fff;
      padding: 40px 20px;
      margin: 40px auto;
      max-width: 800px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-radius: 8px;
      text-align: center;
    }
    .sobre-nosotros h2 {
      font-size: 28px;
      color: #4CAF50; /* Color corporativo */
      margin-bottom: 20px;
    }
    .sobre-nosotros p {
      font-size: 16px;
      line-height: 1.6;
      color: #333;
    }
  </style>
</head>

<body>
  <header>
    <nav>
      <div class="logo">
        <img src="../IMG/Logo.png" alt="Logo">
      </div>
      <div class="menu">
        <div class="menu-item-ubi">INICIO</div>
        <div class="menu-item">CUENTA
          <ul class="submenu">
            <li><button><a href="../HTML/registro.php">SIGN UP</a></button></li>
            <li><button><a href="../HTML/login.php">LOGIN</a></button></li>
          </ul>
        </div>
        <div class="menu-item">PARTICIPAR
          <ul class="submenu">
            <li><button><a href="../HTML//ConsultarParticipacion.php">Casos</a></button></li>
            <li><button><a href="../HTML/ConsultarFundacion.php">Donar</a></button></li>
            <li><button><a href="../HTML/ConsultarFundacion.php">Fundaciones</a></button></li>
            <li>Voluntariados</li>
          </ul>
        </div>
        <div class="menu-item">INFO
          <ul class="submenu">
            <li>SOBRE NOSOTROS</li>
            <li>FAQ</li>
            <li>AYUDA</li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div class="banner">
    <div class="banner-box">
      <div id="banner-left">
        <h1>Pantry <br> Amigo</h1>
        <p>Donando con inspiracion</p>
        <button>DONAR</button>
      </div>
      <div id="banner-right">
        <img src="../IMG/imgbanner.png" alt="bannerimg">
      </div>
    </div>
  </div>

  <div class="band">
    <h3>500k</h3>
    <h4>Elementos entregados</h4>
  </div>

  <!-- Opciones -->
  <div class="opciones">
    <div class="circulo">
      <button class="option-button-donar material-symbols-outlined" href=RevisarFundacion.php>loyalty </button>
    </div>
    <div class="circle">
      <button class="option-button-fund material-symbols-rounded"><a href="../HTML/ConsultarFundacion.php">crowdsource</a></button>
    </div>
    <div class="circulo">
      <button class="option-button-vol material-symbols-rounded"><a href="../HTML/ConsultarFundacion.php">volunteer_activism</a></button>
    </div>
    <div class="circle">
      <button class="option-button-con material-symbols-outlined">document_search</button>
    </div>
  </div>
  
  <!-- Historias Increíbles -->
  <section class="container swiper">
    <h2 class="swiper-title">Historias increibles</h2>
    <p class="swiper-description">Descubre cómo cada donación cambia vidas y genera un impacto real en las comunidades.</p>
    <div class="card-wrapper">
      <ul class="card-list swiper-wrapper">
        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacionalimentos.webp" alt="card Img" class="card-img">
            <p class="badge">Fundacion 1</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacion-foto.jpg" alt="card Img" class="card-img">
            <p class="badge">Fundacion 2</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacionniños.jpg" alt="card Img" class="card-img">
            <p class="badge">Fundacion 3</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacionjuguetes.jpg" alt="card Img" class="card-img">
            <p class="badge">Fundacion 4</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacionutiles.png" alt="card Img" class="card-img">
            <p class="badge">Fundacion 5</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>
      </ul>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </section>
  
  <!-- Sección Sobre Nosotros -->
  <section class="sobre-nosotros">
    <h2>Sobre Nosotros</h2>
    <p>
      Pantry Amigo es una plataforma comprometida con la transformación social. Conectamos a donantes con
      organizaciones y comunidades vulnerables, facilitando la entrega de recursos esenciales para mejorar la
      calidad de vida. Trabajamos con fundaciones, voluntarios y aliados estratégicos para generar un impacto
      positivo y sostenible en la sociedad.
    </p>
    <br/>
    <p>
      Nuestra misión es impulsar un cambio real, promoviendo la solidaridad y la cooperación a través de la
      innovación y la eficiencia en la gestión de donaciones. En Pantry Amigo, cada aporte cuenta y cada
      acción transforma vidas.
    </p>
  </section>

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-logo">
        <h2>Pantry Amigo</h2>
        <p>Conectando ayuda con quienes más la necesitan.</p>
      </div>
      <div class="footer-links">
        <h3>Enlaces</h3>
        <ul>
          <li><a href="#">Inicio</a></li>
          <li><a href="ConsultarCasos.php">Casos de Donación</a></li>
          <li><a href="ConsultarFundacion.php">Fundaciones</a></li>
          <li><a href="ConsultarVoluntario.php">Voluntariados</a></li>
          <li><a href="#">Contacto</a></li>
        </ul>
      </div>
      <div class="footer-social">
        <h3>Síguenos</h3>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Pantry Amigo - Todos los derechos reservados.</p>
    </div>
  </footer>
  
  <!-- link swiper js-->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="../JS/swiper.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Asigna eventos a cada botón de ícono
      document.querySelector(".option-button-donar").addEventListener("click", function() {
        window.location.href = "CasosActivos.php"; // Redirige a la página de donaciones
      });

      document.querySelector(".option-button-fund").addEventListener("click", function() {
        window.location.href = "fundaciones.html"; // Redirige a la página de fundaciones
      });

      document.querySelector(".option-button-vol").addEventListener("click", function() {
        window.location.href = "Voluntariados.php"; // Redirige a la página de voluntariados
      });

      document.querySelector(".option-button-con").addEventListener("click", function() {
        window.location.href = "ConsultarCasos.php"; // Redirige a la página de casos de donación
      });
    });
  </script>
</body>
</html>