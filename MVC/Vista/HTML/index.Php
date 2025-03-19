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
                        <li>SIGN UP</li>
                        <li>LOGIN</li>
                    </ul>
                </div>
                <div class="menu-item">PARTICIPAR
                    <ul class="submenu">
                        <li>Casos</li>
                        <li>Donar</li>
                        <li>Fundaciones</li>
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
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.</p>
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
            <button class="option-button-donar material-symbols-outlined">loyalty </button>
        </div>

        <div class="circle">
            <button class="option-button-fund material-symbols-rounded">crowdsource</button>
        </div>

        <div class="circulo">
            <button class="option-button-vol material-symbols-rounded">volunteer_activism</button>
        </div>

        <div class="circle">
            <button class="option-button-con material-symbols-outlined">document_search</button>
        </div>
    </div>
    
    <!--historias increibles-->
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
                <!--otra carta-->
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="../IMG/donacion-foto.jpg" alt="card Img" class="card-img">
                        <p class="badge">Fundacion 2</p>
                        <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
                            consectetur.</h2>
                        <button class="card-button material-symbols-rounded">arrow_forward</button>
                    </a>
                </li>
                <!--otra carta-->
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="../IMG/donacionniños.jpg" alt="card Img" class="card-img">
                        <p class="badge">Fundacion 3</p>
                        <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
                            consectetur.</h2>
                        <button class="card-button material-symbols-rounded">arrow_forward</button>
                    </a>
                </li>
                <!--otra carta-->
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="../IMG/donacionjuguetes.jpg" alt="card Img" class="card-img">
                        <p class="badge">Fundacion 4</p>
                        <h2 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum,
                            consectetur.</h2>
                        <button class="card-button material-symbols-rounded">arrow_forward</button>
                    </a>
                </li>
                <!--otra carta-->
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

    <!-- link swiper js-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../JS/swiper.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Asigna eventos a cada botón de ícono
            document.querySelector(".option-button-donar").addEventListener("click", function() {
                window.location.href = "ConsultarCasos.php"; // Redirige a la página de donaciones
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
                        <li><a href="#">Casos de Donación</a></li>
                        <li><a href="#">Fundaciones</a></li>
                        <li><a href="#">Voluntariados</a></li>
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
        
</body>

</html>