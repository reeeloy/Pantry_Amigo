<?php
require_once '../Modelo/ConexionBD.php';

class Donante {
    private $Dona_Cedula;
    private $Dona_Nombre;
    private $Dona_Apellido;
    private $Dona_Correo;
    private $conn;

    // Constructor que recibe la conexión
    public function __construct($conexion) {
        $this->conn = $conexion;
        $this->Dona_Cedula = "";
        $this->Dona_Nombre = "";
        $this->Dona_Apellido = "";
        $this->Dona_Correo = "";
    }

    // Setters para asignar datos (o un método para cargar todos)
    public function setDatos($cedula, $nombre, $apellido, $correo) {
        $this->Dona_Cedula = $cedula;
        $this->Dona_Nombre = $nombre;
        $this->Dona_Apellido = $apellido;
        $this->Dona_Correo = $correo;
    }

    // Getters
    public function getDona_Cedula() { return $this->Dona_Cedula; }
    public function getDona_Nombre() { return $this->Dona_Nombre; }
    public function getDona_Apellido() { return $this->Dona_Apellido; }
    public function getDona_Correo() { return $this->Dona_Correo; }

    // Método para registrar donante en BD
    public function registrar() {
        $sql = "INSERT INTO tbl_donante (Dona_Cedula, Dona_Nombre, Dona_Apellido, Dona_Correo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando la consulta");
        }
        $stmt->bind_param(
            "ssss",
            $this->Dona_Cedula,
            $this->Dona_Nombre,
            $this->Dona_Apellido,
            $this->Dona_Correo
        );
        if (!$stmt->execute()) {
            throw new Exception("Error ejecutando la consulta");
        }
        return $stmt->affected_rows;
    }

    // Método para obtener donantes (puedes agregar filtros)
    public function obtenerPorCedula($cedula) {
        $sql = "SELECT Dona_Cedula, Dona_Nombre, Dona_Apellido, Dona_Correo FROM tbl_donante WHERE Dona_Cedula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
