<?php
class ConexionBD {
    // Variables para la conexión mysqli
    private $mysqli;
    private $result;

    // Variables para conexión PDO (opcional)
    public $conexion;
    private $host = "localhost";
    private $dbname = "Pantry_Amigo";
    private $usuario = "root";
    private $password = "";

    // Método para abrir la conexión mysqli
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

    // ✅ Método para obtener el objeto mysqli
    public function getConexion() {
        return $this->mysqli;
    }

    // Método para preparar consultas
    public function prepare($sql) {
        return $this->mysqli->prepare($sql);
    }

    // Método para cerrar la conexión
    public function cerrar() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    // Método para ejecutar consultas (con o sin parámetros)
    public function consulta($sql, $params = []) {
        if (!$this->mysqli) {
            return false;
        }

        if (!empty($params)) {
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt) return false;

            $tipos = str_repeat("s", count($params));
            $stmt->bind_param($tipos, ...$params);

            if (!$stmt->execute()) return false;

            $this->result = $stmt->get_result();
            $stmt->close();
            return true;
        } else {
            $this->result = $this->mysqli->query($sql);
            return $this->result !== false;
        }
    }

    // Obtener resultados
    public function obtenerResult() {
        return $this->result;
    }

    public function obtenerFilasAfectadas() {
        return $this->mysqli ? $this->mysqli->affected_rows : 0;
    }

    public function obtenerUltimoID() {
        return $this->mysqli ? $this->mysqli->insert_id : null;
    }

    // Conexión estática opcional (no usada actualmente)
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

    // Conexión PDO (opcional, por si la necesitas en algún punto)
    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->usuario, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión (PDO): " . $e->getMessage());
        }
    }
}

////////////////////////////////////////////////////////////////////////////////
// ⚠️ Conexión directa fuera de la clase (solo para pruebas o consultas sueltas)
// Puedes usar esto cuando no quieras usar la clase ConexionBD
// ❌ NO se recomienda usar dentro del MVC normal
////////////////////////////////////////////////////////////////////////////////

$host = "localhost";
$user = "root";
$pass = "";
$db = "Pantry_Amigo";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

