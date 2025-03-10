<?php
require_once '../Modelo/ConexionBD.php';

class Caso {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    public function registrarCaso($id, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado, $fundacionId) {
        if ($this->conexion->abrir()) {
            $sql = "INSERT INTO tbl_caso_donacion (Caso_Id, Caso_Nombre_Caso, Caso_Descripcion, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Fund_Id) 
                    VALUES ('$id', '$nombre', '$descripcion', '$fechaInicio', '$fechaFin', '$estado', $fundacionId)";
                    
            $this->conexion->consulta($sql);
            $filasAfectadas = $this->conexion->obtenerFilasAfectadas();
            $this->conexion->cerrar();
            return $filasAfectadas > 0;
        }
        return false;
    }
}
?>



