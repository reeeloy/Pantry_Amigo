<?php
include 'conexionbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nit = $_POST["nit"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $rol = $_POST["rol"]; // usuario, fundacion, administrador

    $sql = "INSERT INTO usuarios (nit, nombre, apellido, direccion, telefono, email, password, rol)
            VALUES ('$nit', '$nombre', '$apellido', '$telefono', '$email', '$password', '$rol')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
