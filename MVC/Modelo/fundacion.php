<?php
require_once __DIR__ . '../../../MVC/Modelo/ConexionBD.php';

class Fundacion {
    private $conn;

    public function __construct() {
        $this->conn = conexionBD::getConnection();
    }

    // 🔹 REGISTRAR FUNDACIÓN (ID manual)
    public function registrarFundacion($id, $correo, $username, $direccion, $casos_activos, $telefono, $usu_id) {
        $sql = "INSERT INTO tbl_fundaciones (Fund_Id, Fund_Correo, Fund_Username, Fund_Direccion, Fund_Casos_Activos, Fund_Telefono, Fund_Usu_Id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssisi", $id, $correo, $username, $direccion, $casos_activos, $telefono, $usu_id);
        
        return $stmt->execute();
    }

    // 🔹 ACTUALIZAR FUNDACIÓN (se busca por ID)
    public function actualizarFundacion($id, $correo, $username, $direccion, $casos_activos, $telefono, $usu_id) {
        $sql = "UPDATE tbl_fundaciones 
                SET Fund_Correo=?, Fund_Username=?, Fund_Direccion=?, Fund_Casos_Activos=?, Fund_Telefono=?, Fund_Usu_Id=?
                WHERE Fund_Id=?";
        $stmt = $this->conn->prepare($sql);
        
        // 🔹  bind_param
        $stmt->bind_param("sssisis", $correo, $username, $direccion, $casos_activos, $telefono, $usu_id, $id);
        
        return $stmt->execute();
    }
    
    // 🔹 OBTENER FUNDACIÓN POR ID
    public function obtenerFundacion($id) {
        $sql = "SELECT * FROM tbl_fundaciones WHERE Fund_Id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
