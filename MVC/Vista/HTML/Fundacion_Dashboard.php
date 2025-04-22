<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="../CSS/fundacion_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="dashboard-container">
    <!-- Barra lateral -->
    <aside class="sidebar">
      <h2 class="logo">Fundación</h2>
      <nav class="nav">
        <a href="#" id="perfil"><i class="fas fa-user"></i> Perfil</a>
        <a href="#" id="casos"><i class="fas fa-folder-open"></i> Casos</a>
        <a href="#" id="crearCaso"><i class="fas fa-plus-circle"></i> Crear Caso</a>
        <a href="#" id="voluntarios"><i class="fas fa-users"></i> Voluntarios</a>
        <a href="#" id="historial"><i class="fas fa-history"></i> Historial</a>
        <a href="#" id="ayuda"><i class="fas fa-question-circle"></i> Ayuda</a>
        <a href="../logout.php" class="cerrar-sesion"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="main-content">
      <section id="contenido-principal">
        <h1>Bienvenido, Fundación</h1>
        <p>Selecciona una opción del menú para comenzar.</p>
      </section>
    </main>
  </div>

  
</body>
</html>
