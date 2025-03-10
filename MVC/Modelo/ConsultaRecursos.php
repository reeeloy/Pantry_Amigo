<?php
require_once '../Modelo/ConexionBD.php';

class ConsultaRecursos {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    public function consultarRecursos($caso_id) {
        $this->conexion->abrir();
        $sql = "SELECT recurso, cantidad, tipo_donacion FROM Tbl_Donacion_Recursos WHERE Caso_Id = '$caso_id'";
        $resultado = $this->conexion->obtenerResult($sql);
        $this->conexion->cerrar();
        return $resultado;
    }
}
?>
