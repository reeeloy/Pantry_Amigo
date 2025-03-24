<?php
require_once '../Modelo/Caso.php';

class CasoControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new Caso();
    }

    // 📌 Método para obtener la lista de casos activos
    public function listarCasos() {
        return $this->modelo->obtenerCasosActivos();
    }

    // 🔍 Método para ver detalles de un caso por ID
    public function verDetallesCaso($id) {
        return $this->modelo->obtenerCasoPorId($id);
    }
}
?>
