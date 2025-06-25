<?php
// /Pantry_Amigo/MVC/Vista/HTML/verificar_sesion.php
session_start();

echo "<h1>Contenido de la Sesión Actual</h1>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>