<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Fundación</title>
  <link rel="stylesheet" href="../CSS/fundacion_dashboard.css"> <!-- Asegúrate que esta ruta es correcta -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="logo.png" alt="Logo Fundación">
    </div>
    <nav class="menu">
      <ul>
        <li><a href="#" class="active"><i class="fas fa-user"></i> Perfil</a></li>
        <li><a href="#"><i class="fas fa-hands-helping"></i> Casos</a></li>
        <li><a href="#"><i class="fas fa-plus-circle"></i> Crear Caso</a></li>
        <li><a href="#"><i class="fas fa-users"></i> Voluntarios</a></li>
        <li><a href="#"><i class="fas fa-history"></i> Historial</a></li>
        <li><a href="#"><i class="fas fa-question-circle"></i> Ayuda</a></li>
        <li><a href="#"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
      </ul>
    </nav>
  </div>

  <!-- Contenido principal -->
  <div class="content">
    <div class="header">
      <h2>Bienvenido al Panel de Fundación</h2>
    </div>

    <!-- Área para contenido dinámico -->
    <div class="fundacion">
      <h3>Ejemplo de tarjeta</h3>
      <p><i class="fas fa-calendar-alt"></i> Fecha de creación: 2025-04-21</p>
      <p><i class="fas fa-map-marker-alt"></i> Ubicación: Bogotá</p>
      <button>Editar</button>
      <button>Eliminar</button>
    </div>

    <div class="search-bar">
      <input type="text" placeholder="Buscar caso o voluntario...">
      <button><i class="fas fa-search"></i> Buscar</button>
    </div>
  </div>

</body>
</html>
