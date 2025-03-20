<?php
require_once '../Modelo/ConexionBD.php';

class Caso {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    public function registrarCaso($id, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado, $fundacionId, $aceptaVoluntarios, $montoMeta) {
        if ($this->conexion->abrir()) {
            $sql = "INSERT INTO tbl_caso_donacion (Caso_Id, Caso_Nombre_Caso, Caso_Descripcion, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Fund_Id, Caso_Acep_Vol, Caso_Monto_Meta) 
                    VALUES ('$id', '$nombre', '$descripcion', '$fechaInicio', '$fechaFin', '$estado', $fundacionId, $aceptaVoluntarios, '$montoMeta')";
                    
            $this->conexion->consulta($sql);
            $filasAfectadas = $this->conexion->obtenerFilasAfectadas();
            $this->conexion->cerrar();
            return $filasAfectadas > 0;
        }
        return false;
    }
}
?>



