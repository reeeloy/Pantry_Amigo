<?php
// Activar errores durante desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Limpiar buffer antes de generar PDF
if (ob_get_length()) ob_clean();

// Incluir conexión y modelo
require_once '../../MVC/Modelo/conexionBDD.php';
require_once '../../MVC/Modelo/donacionModelo.php';

// Solo generar PDF si se pasa el parámetro
if (isset($_GET['generar_pdf'])) {
    // Incluir TCPDF
    require_once '../../../Pantry_Amigo/MVC/Vista/Librerias/TCPDF/tcpdf.php'; // Revisa que esta ruta sea correcta

    $conexion = new ConexionBD();
    $conn = $conexion->getConexion();
    $modelo = new DonacionModelo($conn);

    $cedula = isset($_GET['cedula']) ? urldecode($_GET['cedula']) : null;
    $horarios = $modelo->obtenerHorariosVoluntarios($cedula);

    if (!empty($horarios)) {
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PANTRY');
        $pdf->SetTitle('Reporte de Horarios de Voluntarios');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $pdf->Cell(0, 10, 'Reporte de Horarios de Voluntarios', 0, 1, 'C');
        $pdf->Ln(10);

        // Generar tabla en HTML
        $html = '<table border="1" cellpadding="5">';
        $html .= '<tr style="background-color:#e0e0e0;"><th>ID</th><th>Fecha y Hora de Citación</th><th>Lugar</th><th>Cédula del Voluntario</th></tr>';

        foreach ($horarios as $hora) {
            $html .= "<tr>
                        <td>{$hora['Hora_Id']}</td>
                        <td>{$hora['Hora_Citacion']}</td>
                        <td>{$hora['Hora_Localizacion']}</td>
                        <td>{$hora['Hora_Vol_Cedula']}</td>
                      </tr>";
        }

        $html .= '</table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        // Limpiar salida final
        if (ob_get_length()) ob_end_clean();

        // Descargar PDF
        $pdf->Output('horarios_voluntarios.pdf', 'D');
        exit;
    } else {
        header("Location: ConsultarParticipacion.php");
        exit;
    }
}

// Si no es PDF, mostrar página normal
$conexion = new ConexionBD();
$conn = $conexion->getConexion();
$modelo = new DonacionModelo($conn);

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : null;
$horarios = $modelo->obtenerHorariosVoluntarios($cedula);

include '../Vista/HTML/ConsultarParticipacion.php';
?>