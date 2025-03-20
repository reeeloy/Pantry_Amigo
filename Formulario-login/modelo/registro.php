<?php
class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario($username, $password, $tipo, $correo) {
        // Verificar si el usuario ya existe
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

        // Insertar usuario sin especificar ID (auto_increment)
        $sql = "INSERT INTO tbl_usuario (Usu_Username, Usu_Password, Usu_Tipo, Usu_Correo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $password, $tipo, $correo);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al registrar el usuario.";
        }
    }
}
?>
