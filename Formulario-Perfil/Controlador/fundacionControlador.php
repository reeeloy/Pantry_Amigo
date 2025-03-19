<?php
require_once __DIR__ . '/../Modelo/fundacion.php';

class FundacionControlador {
    private $model;

    public function __construct() {
        $this->model = new Fundacion();
    }

    public function procesarFormulario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['Fund_Id'];
            $correo = $_POST['Fund_Correo'];
            $username = $_POST['Fund_Username'];
            $direccion = $_POST['Fund_Direccion'];
            $casos_activos = $_POST['Fund_Casos_Activos'];
            $telefono = $_POST['Fund_Telefono'];
            $usu_id = $_POST['Fund_Usu_Id'];
            $accion = $_POST['accion'];

            if ($accion == "registrar") {
                $registrado = $this->model->registrarFundacion($id, $correo, $username, $direccion, $casos_activos, $telefono, $usu_id);
                if ($registrado) {
                    header("Location: ../Vista/from_Fundacion.php?mensaje=" . urlencode("✅ Fundación registrada con ID: $id"));
                    exit();
                }
            } elseif ($accion == "actualizar") {
                $actualizado = $this->model->actualizarFundacion($id, $correo, $username, $direccion, $casos_activos, $telefono, $usu_id);
                if ($actualizado) {
                    header("Location: ../Vista/from_Fundacion.php?mensaje=" . urlencode("✅ Datos de la fundación actualizados."));
                    exit();
                }
            }

            header("Location: ../Vista/from_Fundacion.php?mensaje=" . urlencode("❌ Error al procesar la solicitud."));
            exit();
        }
    }

    public function obtenerFundacion($id) {
        return $this->model->obtenerFundacion($id);
    }
}

$controlador = new FundacionControlador();
$controlador->procesarFormulario();
?>
