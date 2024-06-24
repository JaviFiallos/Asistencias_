<?php
ob_start(); // Iniciar el buffer de salida para evitar cualquier salida prematura

require_once ('../fpdf186/fpdf.php');
include_once ('conexion.php');

$conn = new Conexion();
$con = $conn->conectar();

// Obtener los datos del formulario enviado por POST
$cedula = $_POST['cedula'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$sumaDescuentos = 0;
$sumaSubtotal = 0;

// Consulta SQL para obtener los registros de asistencia del empleado en el rango de fechas especificado
$sql = "SELECT * FROM registro_asistencia WHERE FECHA BETWEEN '$fechaInicio' AND '$fechaFin' AND ID_EMP_PER = (
    SELECT ID_EMP FROM empleados WHERE CED_EMP = '$cedula')";

$result = $con->query($sql);

// Verificar si se encontraron registros
if ($result->num_rows > 0) {
    // Consulta para obtener los datos del empleado por su cédula
    $sqlEmpleado = "SELECT * FROM empleados WHERE CED_EMP = '$cedula'";
    $resultEmpleado = $con->query($sqlEmpleado);
    $rowEmpleado = $resultEmpleado->fetch_assoc();

    // Crear un nuevo objeto FPDF para generar el PDF en formato horizontal (L)
    $pdf = new FPDF('L');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    
    // Título del reporte
    $pdf->Cell(40, 10, 'Reporte Mensual', 0);
    $pdf->Ln();
    
    // Datos del empleado
    $pdf->Cell(50, 10, 'Empleado: ' . $rowEmpleado['NOM_EMP'] . ' ' . $rowEmpleado['APE_EMP'], 0);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Cedula: ' . $rowEmpleado['CED_EMP'], 1);
    $pdf->Ln();
    
    // Encabezados de la tabla de asistencias
    $pdf->Cell(40, 10, 'Fecha', 1);
    $pdf->Cell(40, 10, 'Jornada', 1);
    $pdf->Cell(40, 10, 'Hora Entrada', 1);
    $pdf->Cell(40, 10, 'Hora Salida', 1);
    $pdf->Cell(35, 10, 'Descuento', 1);
    $pdf->Cell(40, 10, 'Horas Trabajadas', 1);
    $pdf->Cell(40, 10, 'Subtotal', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12); // Cambiar a fuente normal para el contenido

    // Iterar sobre los resultados de la consulta y agregar cada registro al PDF
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['FECHA'], 1);
        $pdf->Cell(40, 10, $row['JORNADA'], 1);
        $pdf->Cell(40, 10, $row['HORA_INGRESO'], 1);
        $pdf->Cell(40, 10, $row['HORA_SALIDA'], 1);
        $pdf->Cell(35, 10, $row['DESCUENTO'], 1);
        $pdf->Cell(40, 10, $row['HORAS_POR_JORNADA'], 1);
        $pdf->Cell(40, 10, $row['SUBTOTAL_JORNADA'], 1);
        $pdf->Ln();

        // Sumar los descuentos y subtotales para el total del mes
        $sumaDescuentos += $row['DESCUENTO'];
        $sumaSubtotal += $row['SUBTOTAL_JORNADA'];
    }

    // Mostrar el total de descuentos y subtotal del mes
    $pdf->Cell(50, 10, 'Descuento Este Mes: $' . $sumaDescuentos, 1);
    $pdf->Ln();
    $pdf->Cell(50, 10, 'Subtotal Este Mes: $' . $sumaSubtotal, 1);

    ob_end_clean(); // Limpiar el buffer de salida antes de enviar el PDF

    // Enviar el PDF al navegador como una descarga
    $pdf->Output();
} else {
    ob_end_clean();
    echo "No se encontraron registros para la cédula y mes seleccionados.";
    exit();
}
?>
