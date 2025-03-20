<?php
include 'conexionbd.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["usuario"] = $row["nombre"];
            $_SESSION["rol"] = $row["rol"];

            // Redirigir según el rol
            if ($row["rol"] == "administrador") {
                header("Location: admin_dashboard.php");
            } elseif ($row["rol"] == "fundacion") {
                header("Location: fundacion_dashboard.php");
            } else {
                header("Location: usuario_dashboard.php");
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
$conn->close();
?>
