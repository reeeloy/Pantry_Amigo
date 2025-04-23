<?php
require_once '../../Modelo/ConexionBD.php';

// Obtener parámetros desde la URL
$caso_id = $_GET['caso_id'] ?? null;
$monto = $_GET['monto'] ?? null;
$nombre = $_GET['nombre'] ?? '';
$correo = $_GET['correo'] ?? '';

// Validar parámetros
if (!$caso_id || !$monto || !$nombre || !$correo) {
    die("❌ Datos incompletos para registrar la donación.");
}

// Validar que el monto sea un número válido
if (!is_numeric($monto) || $monto <= 0) {
    die("❌ El monto de la donación no es válido.");
}

// Crear una nueva conexión a la base de datos
$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar con la base de datos.");
}

// Obtener la categoría del caso
$sqlCategoria = "SELECT Caso_Categoria FROM Tbl_Casos_Dinero WHERE Caso_Id = ?";
$conn->consulta($sqlCategoria, [$caso_id]);
$resCategoria = $conn->obtenerResult();
if ($resCategoria->num_rows === 0) {
    die("❌ No se encontró el caso con ID $caso_id.");
}
$fila = $resCategoria->fetch_assoc();
$categoria = $fila['Caso_Categoria'] ?? 'Sin categoría';

// Dividir el nombre en partes (nombre y apellido)
$partes = explode(" ", $nombre, 2);
$nombre_donante = $partes[0];
$apellido_donante = $partes[1] ?? '';

// Calcular la comisión
$comision = round($monto * 0.039, 2); // Asegurarse de que la comisión esté redondeada

// Obtener la fecha y hora actual
$fecha = date("Y-m-d H:i:s");

// Insertar los datos de la donación
$sqlInsert = "INSERT INTO Tbl_Donacion_Dinero (
    Don_Monto, Don_Comision, Don_Nombre_Donante, Don_Apellido_Donante,
    Don_Correo, Don_Metodo_Pago, Don_Fecha, Don_Caso_Id, Don_Cat_Nombre
) VALUES (?, ?, ?, ?, ?, 'MercadoPago', ?, ?, ?)";

$exito = $conn->consulta($sqlInsert, [
    $monto, $comision, $nombre_donante, $apellido_donante, $correo, $fecha, $caso_id, $categoria
]);

// Cerrar la conexión
$conn->cerrar();

// Verificar si la inserción fue exitosa
if ($exito) {
    echo "<h3>✅ ¡Gracias por tu donación!</h3>";
} else {
    echo "<h3>❌ Error al registrar la donación.</h3>";
}
?>


