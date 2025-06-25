<?php
class DonacionModelo
{
    private $conn;

    public function __construct($conexion)
    {
        $this->conn = $conexion;
    }

    public function obtenerHorariosVoluntarios($cedula = null)
    {
        if ($cedula) {
            $stmt = $this->conn->prepare("
            SELECT 
                Hora_Id,
                Hora_Citacion,
                Hora_Localizacion,
                Hora_Vol_Cedula
            FROM 
                tbl_horarios_voluntarios
            WHERE 
                Hora_Vol_Cedula = ?
        ");
            $stmt->bind_param("s", $cedula);
        } else {
            $stmt = $this->conn->prepare("
            SELECT 
                Hora_Id,
                Hora_Citacion,
                Hora_Localizacion,
                Hora_Vol_Cedula
            FROM 
                tbl_horarios_voluntarios
        ");
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
