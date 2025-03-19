<?php
require_once '../Modelo/Donante.php';
require_once '../Modelo/registrarDonante.php';
require_once '../Modelo/Caso.php';
require_once '../Modelo/ConsultaRecursos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        //donacion dinero (registar arreglar)
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

        // caso donacion(registrar con check de voluntarios)
        if (isset($_POST['registrarCaso']))
        {
            $casoId = $_POST['casoId'];
            $casoNombre = $_POST['casoNombre'];
            $casoDescripcion = $_POST['casoDescripcion'];
            $casoFechaInicio = $_POST['casoFechaInicio'];
            $casoFechaFin = $_POST['casoFechaFin'];
            $casoEstado = $_POST['casoEstado'];
            $casoFundacion = $_POST['casoFundacion'];
            $casoAceptaVoluntarios = isset($_POST['casoAceptaVoluntarios']) ? 1 : 0;


            $caso = new Caso();
            if ($caso->registrarCaso($casoId, $casoNombre, $casoDescripcion, $casoFechaInicio, $casoFechaFin, $casoEstado, $casoFundacion, $casoAceptaVoluntarios)) {
                echo "<script>alert('Caso registrado exitosamente');</script>";
            } else {
                echo "<script>alert('Error al registrar el caso');</script>";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                //registrar voluntarios
                if (isset($_POST['regVolCedula']) && isset($_POST['regVolNombre']) && isset($_POST['regVolApellido']) && isset($_POST['regVolCorreo']) && isset($_POST['regVolCelular']) && isset($_POST['regVolCasoId'])) {

                    $Vol_Cedula = $_POST['regVolCedula'];
                    $Vol_Nombre = $_POST['regVolNombre'];
                    $Vol_Apellido = $_POST['regVolApellido'];
                    $Vol_Correo = $_POST['regVolCorreo'];
                    $Vol_Celular = $_POST['regVolCelular'];
                    $Vol_CasoId = $_POST['regVolCasoId']
        
                   /* $personal = new Donante();
                    $personal->Donante($Dona_Cedula, $Dona_Nombre, $Dona_Apellido, $Dona_Correo);
        
                    $perCliente = new registrarDonante();
                    $perCliente->regDonante($personal);
                }*/
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['caso_id'])) {
    $caso_id = $_GET['caso_id'];

    $modelo = new ConsultaRecursos();
    $result = $modelo->consultarRecursos($caso_id);

    // Incluir la vista para mostrar los recursos
    require '../Vista/HTML/resultadoConsultaRe.php';
}