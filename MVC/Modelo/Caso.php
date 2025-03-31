<?php
require_once '../Modelo/ConexionBD.php';

class Caso {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    //regcasos dinero
    public function registrarCasoDinero($nombre, $descripcion, $montoMeta, $montoRecaudado, $fechaInicio, $fechaFin, $estado, $imagen = null, $voluntariado, $fundacionId, $categoriaNombre) {
        if ($this->conexion->abrir()) {
            // Si no se proporciona una imagen, se guarda como NULL en la base de datos
            $imagenSQL = $imagen ? "'$imagen'" : "NULL";
    
            $sql = "INSERT INTO tbl_casos_dinero (
                        Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, 
                        Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, 
                        Caso_Voluntariado, Caso_Fund_Id, Caso_Cat_Nombre
                    ) 
                    VALUES (
                        '$nombre', '$descripcion', '$montoMeta', '$montoRecaudado',
                        '$fechaInicio', '$fechaFin', '$estado', $imagenSQL, 
                        '$voluntariado', '$fundacionId', '$categoriaNombre'
                    )";
    
            $this->conexion->consulta($sql);
            $filasAfectadas = $this->conexion->obtenerFilasAfectadas();
            $this->conexion->cerrar();
            return $filasAfectadas > 0;
        }
        return false;
    }
    

    //reg casos rec
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

    // 🔍 Obtener todos los casos activos
    public function obtenerCasosActivos() {
        if ($this->conexion->abrir()) {
            $sql = "SELECT Caso_Id, Caso_Nombre_Caso, Caso_Descripcion FROM tbl_caso_donacion WHERE Caso_Estado = 'activo'";
            $resultado = $this->conexion->consulta($sql);
            $this->conexion->cerrar();
            return $resultado;
        }
        return null;
    }


    public function obtenerCasoPorId($id) {
        if ($this->conexion->abrir()) {
            $sql = "SELECT * FROM tbl_caso_donacion WHERE Caso_Id = '$id'";
            $resultado = $this->conexion->consulta($sql);
            
            // Verifica si la consulta devolvió un resultado válido
            if ($resultado && $resultado instanceof mysqli_result) {
                $caso = $resultado->fetch_assoc();
            } else {
                $caso = null;
            }
            
            $this->conexion->cerrar();
            return $caso;
        }
        return null;
    }
    
}
?>


