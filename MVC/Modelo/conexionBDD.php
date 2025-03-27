<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Pantry_Amigo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>