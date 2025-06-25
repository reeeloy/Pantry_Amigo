<?php
class FundacionModelo {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function obtenerPorUsuario($usuarioId) {
        $sql = "SELECT * FROM tbl_fundaciones WHERE Fund_Usu_Id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function registrar($datos) {
    $sql = "INSERT INTO tbl_fundaciones (
                Fund_Username, Fund_Correo, Fund_Direccion, 
                Fund_Casos_Activos, Fund_Telefono, Fund_Descripcion, 
                Fund_Usu_Id, Fund_Imagen
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param(
        "ssssisss",
        $datos['username'],
        $datos['correo'],
        $datos['direccion'],
        $datos['casos'],
        $datos['telefono'],
        $datos['descripcion'],   
        $datos['usuarioId'],
        $datos['imagen']
    );
    return $stmt->execute();
}
    public function actualizar($datos) {
    $sql = "UPDATE tbl_fundaciones 
            SET Fund_Username = ?, Fund_Correo = ?, Fund_Direccion = ?, 
                Fund_Casos_Activos = ?, Fund_Telefono = ?, Fund_Descripcion = ?" . 
                ($datos['imagen'] ? ", Fund_Imagen = ?" : "") . 
            " WHERE Fund_Usu_Id = ?";
    
    if ($datos['imagen']) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssisss", 
            $datos['username'], $datos['correo'], $datos['direccion'], 
            $datos['casos'], $datos['telefono'], $datos['descripcion'], 
            $datos['imagen'], $datos['usuarioId']
        );
    } else {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssiss", 
            $datos['username'], $datos['correo'], $datos['direccion'], 
            $datos['casos'], $datos['telefono'], $datos['descripcion'], 
            $datos['usuarioId']
        );
    }
    return $stmt->execute();
}
}