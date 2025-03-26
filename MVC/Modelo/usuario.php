<?php
class Usuario {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM Tbl_Usuario WHERE Usu_Username=? AND Usu_Password=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function register($username, $password, $tipo, $correo) {
        $query = "INSERT INTO Tbl_Usuario (Usu_Username, Usu_Password, Usu_Tipo, Usu_Correo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $username, $password, $tipo, $correo);
        return $stmt->execute();
    }

    public function resetPassword($correo, $new_password) {
        $query = "UPDATE Tbl_Usuario SET Usu_Password=? WHERE Usu_Correo=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $new_password, $correo);
        return $stmt->execute();
    }
}
?>