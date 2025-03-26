<?php
require_once '../Modelo/ConexionBD.php';
class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario($username, $password, $tipo, $correo) {
        $checkSql = "SELECT COUNT(*) FROM tbl_usuario WHERE Usu_Username = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            return "El usuario ya existe.";
        }

        $sql = "INSERT INTO tbl_usuario (Usu_Username, Usu_Password, Usu_Tipo, Usu_Correo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $password, $tipo, $correo);

        return $stmt->execute() ? true : "Error al registrar el usuario.";
    }

    public function iniciarSesion($username, $password) {
        $sql = "SELECT Usu_Password FROM tbl_usuario WHERE Usu_Username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        if ($stmt->fetch()) {
            return $password === $hashedPassword;
        }
        return false;
    }
}
?>