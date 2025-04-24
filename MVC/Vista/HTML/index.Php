<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&family=Material+Symbols+Rounded&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../CSS/estilosIndex.css">

  <title>Pantry Amigo</title>
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
          <a href="../HTML/ConsultarFundacion.php" class="nav-link">COLABORATORS</a>
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

  <main>
    <!-- herr-->
    <section class="hero-section">
      <div class="section-content">
        <div class="hero-details">
          <h2 class="title">Pantry Amigo</h2>
          <h3 class="subtitle">Brinda una mano amiga</h3>
          <p class="description">En Pantry Amigo conectamos a quienes necesitan ayuda con personas y fundaciones dispuestas a brindar apoyo. Juntos podemos hacer la diferencia, una donación, un voluntario o un recurso a la vez.</p>
          <div class="buttons">
            <a href="#casos" class="button donar">Donar</a>
            <a href="#opciones" class="button participar">Participar</a>
          </div>
        </div>
        <div class="hero-image-wrapper">
          <img src="../IMG/hero.png" alt="Hero" class="hero-image">
        </div>
      </div>
    </section>
  </main>

  <!--About us-->
  <section class="about-section" id="sobre-nosotros">
    <div class="section-content">
      <div class="about-image-wrapper">
        <img src="../IMG/aboutus.jpg" alt="about us" class="about-image">
      </div>
      <div class="about-details">
        <h2 class="section-title">Sobre Nosotros</h2>
        <p class="text">Pantry Amigo es una plataforma que conecta donantes con comunidades vulnerables, facilitando la entrega de recursos esenciales. Junto a fundaciones y voluntarios, promovemos la solidaridad y generamos un impacto social positivo y sostenible.</p>

        <div class="social-link-list">
          <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
        </div>
      </div>
    </div>
  </section>


  <!--Options-->
  <section class="options-section" id="opciones">
    <h1 class="options-section-title"> Juntos <span>Ayudamos</span></h1>
    <p class="options-section-description">Descubre cómo puedes unirte a causas, apoyar fundaciones y ayuda donde más se necesita. Cada acción cuenta.</p>
    <div class="options-section-cards">
      <div class="options-section-card" onclick="window.location.href='CasosActivos.php'">
        <div class="options-section-card-icon">
          <i class='bx bx-donate-heart'></i>
        </div>
        <h1 class="options-section-card-title">Casos activos</h1>
        <p>Elige un caso y dona.</p>
      </div>

      <div class="options-section-card" onclick="window.location.href='Fundaciones.php'">
        <div class="options-section-card-icon">
          <i class='bx bx-home-heart'></i>
        </div>
        <h1 class="options-section-card-title">Fundaciones aliadas</h1>
        <p>Conoce nuestras fundaciones.</p>
      </div>

      <div class="options-section-card" onclick="window.location.href='Voluntariados.php'">
        <div class="options-section-card-icon">
          <i class='bx bx-user-pin'></i>
        </div>
        <h1 class="options-section-card-title">Voluntariado</h1>
        <p>Súmate como voluntario.</p>
      </div>

      <div class="options-section-card" onclick="window.location.href='ConsultarParticipacion.php'">
        <div class="options-section-card-icon">
          <i class='bx bx-file-find'></i>
        </div>
        <h1 class="options-section-card-title">Consultar Participación</h1>
        <p>Revisa tu historial por cédula.</p>
      </div>

    </div>
  </section>


  <!--carrusel-->
  <section class="container-slider swiper" id="casos">
    <h1 class="swiper-title">Historias increibles</h1>
    <p class="swiper-description">Descubre cómo cada donación cambia vidas y genera un impacto real en las comunidades.</p>
    <div class="card-wrapper">
      <ul class="card-list swiper-wrapper">
        <li class="card-item swiper-slide">
          <a href="#" class="card-link" onclick="window.location.href='Detalles.php?ID=9&tipo=recursos'">
            <img src="../../../imagenes_casos/donacionalimentos.webp" alt="card Img" class="card-img">
            <p class="badge">Fundacion 13</p>
            <h2 class="card-title">Donacion de alimentos</h2>
            <p class="description">Estamos haciendo recolecta de alimentos para la cena de caridad mensual.</p>
            <button class="card-button material-symbols-rounded" onclick="window.location.href='Detalles.php?ID=9&tipo=recursos'">arrow_forward</button>

          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide">
          <a href="#" class="card-link" onclick="window.location.href='Detalles.php?ID=10&tipo=dinero'">
            <img src="../imagenes_casos/Daniela.jpg" alt="card Img" class="card-img">
            <p class="badge">Fundacion 2</p>
            <h2 class="card-title">Cambio de genero de Daniela</h2>
            <p class="description">Daniela dejará su identidad anterior y será mujer</p>
            <button class="card-button material-symbols-rounded" onclick="window.location.href='Detalles.php?ID=10&tipo=dinero'">arrow_forward</button>
          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide" onclick="window.location.href='Detalles.php?ID=8&tipo=recursos'">
          <a href="#" class="card-link">
            <img src="../imagenes_casos/Croquetas.jpg" alt="card Img" class="card-img">
            <p class="badge">Fundacion 3</p>
            <h2 class="card-title">Croquetas para todos</h2>
            <p class="description">Necesitamos reunir croquetas dogchow adulto para una fundación de perritos</p>
            <button class="card-button material-symbols-rounded" onclick="window.location.href='Detalles.php?ID=8&tipo=recursos'">arrow_forward</button>
          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacionjuguetes.jpg" alt="card Img" class="card-img">
            <p class="badge">Fundacion 4</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded" onclick="window.location.href='detalleHistoria.php?id=1'">arrow_forward</button>
          </a>
        </li>
        <!-- Otra carta -->
        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacionutiles.png" alt="card Img" class="card-img">
            <p class="badge">Fundacion 5</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded" onclick="window.location.href='detalleHistoria.php?id=1'">arrow_forward</button>
          </a>
        </li>

        <li class="card-item swiper-slide">
          <a href="#" class="card-link">
            <img src="../IMG/donacionutiles.png" alt="card Img" class="card-img">
            <p class="badge">Fundacion 5</p>
            <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
              consectetur.</h2>
            <button class="card-button material-symbols-rounded" onclick="window.location.href='detalleHistoria.php?id=1'">arrow_forward</button>
          </a>
        </li>
      </ul>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </section>
  
  <!-- Team members-->
  <section class="members-section">
        <h2 class="section-title">Team Members</h2>
        <div class="section-content">
            <ul class="members-list">
                <li class="member">
                    <img src="../IMG/aboutus.jpg" alt="user" class="user-image">
                    <h3 class="name">Laura Bolívar</h3>
                    <i class="feedback">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, qui?"</i>
                </li>

                <li class="member">
                    <img src="../IMG/aboutus.jpg" alt="user" class="user-image">
                    <h3 class="name">Daniel Martinez</h3>
                    <i class="feedback">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, qui?"</i>
                </li>

                <li class="member">
                    <img src="../IMG/aboutus.jpg" alt="user" class="user-image">
                    <h3 class="name">Alejandro Gómez</h3>
                    <i class="feedback">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, qui?"</i>
                </li>
            </ul>
        </div>
    </section>


  <!-- Footer -->
  <footer class="footer-section">
    <div class="section-content">
      <p class="copyright-text">© 2025 Pantry Amigo</p>

      <div class="social-link-list">
        <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
        <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
      </div>
      <p class="policy-text">
        <a href="#" class="policy-link"> Privacy Policy</a>
      </p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="../JS/swiper.js"></script>
  <script src="../JS/indexscript.js"></script>

</body>

</html>