<?php
class ConexionBD {
    private $mysqli;
    private $result;

    public function abrir() {
        $this->mysqli = new mysqli("localhost", "root", "", "Pantry_Amigo");

        // Manejo de errores de conexión
        if ($this->mysqli->connect_error) {
            return false;
        }

        // Asegurar que se use UTF-8
        $this->mysqli->set_charset("utf8mb4");
        return true;
    }

    public function cerrar() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    public function consulta($sql, $params = []) {
        if (!$this->mysqli) {
            return false;
        }

        // Usamos sentencias preparadas si hay parámetros
        if (!empty($params)) {
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt) {
                return false;
            }

            // Vincular parámetros dinámicamente
            $tipos = str_repeat("s", count($params)); // Todos los parámetros como string por defecto
            $stmt->bind_param($tipos, ...$params);
            
            if (!$stmt->execute()) {
                return false;
            }

            $this->result = $stmt->get_result();
            $stmt->close();
            return true;
        } else {
            // Consulta normal sin parámetros (de solo lectura)
            $this->result = $this->mysqli->query($sql);
            return $this->result !== false;
        }
    }

    public function obtenerResult() {
        return $this->result;
    }

    public function obtenerFilasAfectadas() {
        return $this->mysqli ? $this->mysqli->affected_rows : 0;
    }

    public function obtenerUltimoID() {
        return $this->mysqli ? $this->mysqli->insert_id : null;
    }
    private static $conn;
    

    public static function getConnection() {
        if (!self::$conn) {
            self::$conn = new mysqli("localhost", "root", "", "Pantry_Amigo");
            if (self::$conn->connect_error) {
                die("❌ Error de conexión: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
?>
