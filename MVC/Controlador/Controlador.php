<?php
require_once '../Modelo/Donante.php';
require_once '../Modelo/registrarDonante.php';
require_once '../Modelo/Caso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        //donante (registar)
        if (isset($_POST['regDonaCedula']) && isset($_POST['regDonaNombre']) && isset($_POST['regDonaApellido']) && isset($_POST['regDonaCorreo'])) {
            $Dona_Cedula = $_POST['regDonaCedula'];
            $Dona_Nombre = $_POST['regDonaNombre'];
            $Dona_Apellido = $_POST['regDonaApellido'];
            $Dona_Correo = $_POST['regDonaCorreo'];

            $personal = new Donante();
            $personal->Donante($Dona_Cedula, $Dona_Nombre, $Dona_Apellido, $Dona_Correo);

            $perCliente = new registrarDonante();
            $perCliente->regDonante($personal);
        }

        // caso dinacion(reguistrar)
        if (isset($_POST['registrarCaso'])) {
            $casoId = $_POST['casoId'];
            $casoNombre = $_POST['casoNombre'];
            $casoDescripcion = $_POST['casoDescripcion'];
            $casoFechaInicio = $_POST['casoFechaInicio'];
            $casoFechaFin = $_POST['casoFechaFin'];
            $casoEstado = $_POST['casoEstado'];
            $casoFundacion = $_POST['casoFundacion'];

            $caso = new Caso();
            if ($caso->registrarCaso($casoId, $casoNombre, $casoDescripcion, $casoFechaInicio, $casoFechaFin, $casoEstado, $casoFundacion)) {
                echo "<script>alert('Caso registrado exitosamente');</script>";
                echo "<script>window.location.href='../views/registrarCaso.php';</script>";
            } else {
                echo "<script>alert('Error al registrar el caso');</script>";
            }
        }
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
}
?>

