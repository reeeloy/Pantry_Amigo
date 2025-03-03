<?php
require_once '../Modelo/Donante.php';
require_once '../Modelo/registrarDonante.php';

if (isset($_POST['regDonaCedula'])&& isset($_POST['regDonaNombre']) && isset($_POST['regDonaApellido']) && isset($_POST['regDonaCorreo'])) {
    try{

        $Dona_Cedula = $_POST['regDonaCedula'];
        $Dona_Nombre = $_POST['regDonaNombre'];
        $Dona_Apellido= $_POST['regDonaApellido'];
        $Dona_Correo = $_POST['regDonaCorreo'];
        $personal = new Donante();
        $personal->Donante($Dona_Cedula, $Dona_Nombre, $Dona_Apellido, $Dona_Correo);
        $perCliente = new registrarDonante();
        $perCliente->regDonante($personal);
    } catch (Exception $ex) {
        echo 'Error' . $ex;
    }
} else {
    $alerta = "Llenar los cambios vacios";
    echo "alert('" . $alerta . "');";
}