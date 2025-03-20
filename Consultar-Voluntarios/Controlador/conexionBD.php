<?php
class conexionBD {
    private $host = "localhost";
    private $dbname = "Pantry_Amigo";
    private $usuario = "root";
    private $password = "";
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->usuario, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
