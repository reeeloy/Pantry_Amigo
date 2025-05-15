<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
session_unset();
session_destroy();
// Si logout.php está en Pantry_Amigo/, entonces esta es la URL correcta:
header("Location: http://localhost/Pantry_Amigo/MVC/Vista/HTML/index.php");
exit;
