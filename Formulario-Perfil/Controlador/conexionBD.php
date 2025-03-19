<?php
class conexionBD {
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
