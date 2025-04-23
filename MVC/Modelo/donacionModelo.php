<?php
class DonacionModelo {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function obtenerDonaciones($cedula) {
        if ($cedula) {
            $stmt = $this->conn->prepare("SELECT Don_Monto, Don_Comision, Don_Cedula_Donante, Don_Nombre_Donante, Don_Apellido_Donante, Don_Correo FROM tbl_donacion_recursos WHERE Don_Cedula_Donante = ?");
            $stmt->bind_param("s", $cedula);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>
