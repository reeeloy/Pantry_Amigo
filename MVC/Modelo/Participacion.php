<?php
require_once '../Modelo/ConexionBD.php';
class Participacion
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new ConexionBD();
    }

    public function registrarVoluntario($Vol_Cedula, $Vol_Nombre, $Vol_Apellido, $Vol_Correo, $Vol_Celular, $Vol_CasoId)
    {
        if ($this->conexion->abrir()) {
            $sql = "INSERT INTO tbl_voluntarios (Vol_Cedula, Vol_Nombre, Vol_Apellido, Vol_Correo, Vol_Celular, Vol_Caso_Id) 
                    VALUES ($Vol_Cedula, '$Vol_Nombre', '$Vol_Apellido', '$Vol_Correo', $Vol_Celular, '$Vol_CasoId')";

            $this->conexion->consulta($sql);
            $filasAfectadas = $this->conexion->obtenerFilasAfectadas();
            $this->conexion->cerrar();
            return $filasAfectadas > 0;
        }
        return false;
    }

    public function obtenerVoluntariosSinHorario()
    {
        if ($this->conexion->abrir()) {
            $sql = "SELECT v.Vol_Cedula, v.Vol_Nombre, v.Vol_Apellido 
                    FROM tbl_voluntarios v
                    LEFT JOIN tbl_horarios_voluntarios h ON v.Vol_Cedula = h.Hora_Vol_Cédula
                    WHERE h.Hora_Vol_Cédula IS NULL"; // Solo los que no tienen horario

            $this->conexion->consulta($sql);
            $voluntarios = $this->conexion->obtenerResultados();
            $this->conexion->cerrar();
            return $voluntarios;
        }
        return [];
    }


    public function asignarHorario($voluntario, $horaCitacion, $localizacion, $duracionHoras)
    {
        if ($this->conexion->abrir()) {
            $sql = "INSERT INTO tbl_horarios_voluntarios (Hora_Citación, Hora_Localización, Hora_Vol_Cédula, Hora_Duracion_Horas) 
                    VALUES ('$horaCitacion', '$localizacion', $voluntario, $duracionHoras)";

            $this->conexion->consulta($sql);
            $filasAfectadas = $this->conexion->obtenerFilasAfectadas();
            $this->conexion->cerrar();
            return $filasAfectadas > 0;
        }
        return false;
    }
}
?>