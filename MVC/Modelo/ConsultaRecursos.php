<?php
require_once '../Modelo/ConexionBD.php';

class ConsultaRecursos {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    public function consultarRecursos($caso_id) {
        $this->conexion->abrir();
        $sql = "SELECT Rec_Nombre, Rec_Cantidad, Rec_Descripcion, Rec_Fecha_Caducidad FROM Tbl_Donacion_Recursos WHERE Rec_Caso_Id = '$caso_id'";
        $resultado = $this->conexion->obtenerResult($sql);
        $this->conexion->cerrar();
        return $resultado;
    }
}
?>
