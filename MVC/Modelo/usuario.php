<?php
// /Pantry_Amigo/MVC/Modelo/usuario.php (Versión Final Estable)

class Usuario {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM Tbl_Usuario WHERE Usu_Username=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['Usu_Password'])) {
                $query_success = "SELECT * FROM Tbl_Usuario WHERE Usu_Id=?";
                $stmt_success = $this->conn->prepare($query_success);
                $stmt_success->bind_param("i", $user['Usu_Id']);
                $stmt_success->execute();
                return $stmt_success->get_result();
            }
        }
        return false;
    }

    public function register($datos) {
        $query = "SELECT * FROM Tbl_Usuario WHERE Usu_Username = ? OR Usu_Correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $datos['username'], $datos['correo']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) { return false; }
        
        $hashed_password = password_hash($datos['password'], PASSWORD_BCRYPT);
        $insertQuery = "INSERT INTO Tbl_Usuario (Usu_Username, Usu_Password, Usu_Tipo, Usu_Correo) VALUES (?, ?, ?, ?)";
        $stmtInsert = $this->conn->prepare($insertQuery);
        $stmtInsert->bind_param("ssss", $datos['username'], $hashed_password, $datos['tipo'], $datos['correo']);
        
        if ($stmtInsert->execute()) {
            if ($datos['tipo'] === 'Usuario') {
                $ultimo_usu_id = $stmtInsert->insert_id;
                $sql_fundacion = "INSERT INTO tbl_fundaciones (Fund_Username, Fund_Correo, Fund_NIT, Fund_Ruta_Documento, Fund_Usu_Id, Fund_Estado_Verificacion) VALUES (?, ?, ?, ?, ?, 'pendiente')";
                $stmt_fundacion = $this->conn->prepare($sql_fundacion);
                if (!$stmt_fundacion) { return false; }
                $stmt_fundacion->bind_param("ssssi", $datos['username'], $datos['correo'], $datos['nit'], $datos['documento'], $ultimo_usu_id);
                return $stmt_fundacion->execute();
            }
            return true;
        }
        return false;
    }
    
    public function obtenerDatosFundacion($usuarioId) {
        $sql = "SELECT * FROM tbl_fundaciones WHERE Fund_Usu_Id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        if ($stmt->execute()) { return $stmt->get_result()->fetch_assoc(); }
        return null;
    }
    
    public function obtenerDatosFundacionPorId($fundacionId) {
        $sql = "SELECT * FROM tbl_fundaciones WHERE Fund_Id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $fundacionId);
        if ($stmt->execute()) { return $stmt->get_result()->fetch_assoc(); }
        return null;
    }

    public function actualizarEstadoVerificacion($fundacionId, $nuevoEstado) {
        if (!in_array($nuevoEstado, ['verificado', 'rechazado'])) { return false; }
        $sql = "UPDATE tbl_fundaciones SET Fund_Estado_Verificacion = ? WHERE Fund_Id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) { return false; }
        $stmt->bind_param("si", $nuevoEstado, $fundacionId);
        return $stmt->execute();
    }
}
?>