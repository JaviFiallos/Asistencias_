<?php
ob_start();
require_once ('../fpdf186/fpdf.php');
include_once ('conexion.php');

$conn = new Conexion();
$con = $conn->conectar();

$cedula = $_POST['cedula'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

$fechaFinObj = new DateTime($fechaFin);

// Restar 2 días
$fechaFinObj->modify('-2 days');

// Obtener la fecha modificada en el mismo formato 'YYYY-MM-DD'
$fechaFinModificada = $fechaFinObj->format('Y-m-d');

$sumaDescuentos = 0;
$sumaSubtotal = 0;
$totalHoras = new DateTime('00:00:00'); // Inicializar el total de horas trabajadas

$sql = "SELECT * FROM registro_asistencia WHERE FECHA BETWEEN '$fechaInicio' AND '$fechaFin' AND ID_EMP_PER = (
    SELECT ID_EMP FROM empleados WHERE CED_EMP = '$cedula')";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    $sqlEmpleado = "SELECT * FROM empleados WHERE CED_EMP = '$cedula'";
    $resultEmpleado = $con->query($sqlEmpleado);
    $rowEmpleado = $resultEmpleado->fetch_assoc();

    $pdf = new FPDF('L');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Reporte Semanal'); // Add border
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Empleado: ' . $rowEmpleado['NOM_EMP'] . ' ' . $rowEmpleado['APE_EMP']); // Add border
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Cedula: ' . $rowEmpleado['CED_EMP']); // Add border
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Fecha', 1); // Add border
    $pdf->Cell(40, 10, 'Jornada', 1); // Add border
    $pdf->Cell(40, 10, 'Hora Entrada', 1); // Add border
    $pdf->Cell(40, 10, 'Hora Salida', 1); // Add border
    $pdf->Cell(35, 10, 'Descuento', 1); // Add border
    $pdf->Cell(40, 10, 'Horas Trabajadas', 1); // Add border
    $pdf->Cell(40, 10, 'Subtotal', 1); // Add border
    $pdf->Ln();
    
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['FECHA'], 1); // Add border
        $pdf->Cell(40, 10, $row['JORNADA'], 1); // Add border
        $pdf->Cell(40, 10, $row['HORA_INGRESO'], 1); // Add border
        if($row['HORA_SALIDA'] == '00:00:00'){
            $pdf->Cell(40, 10, 'No hay Registro', 1); // Add border
            $pdf->Cell(35, 10, '64.00', 1); // Add border
            $sumaDescuentos += 64;
        } else {
            $pdf->Cell(40, 10, $row['HORA_SALIDA'], 1); // Add border
            $pdf->Cell(35, 10, $row['DESCUENTO'], 1); // Add border
        }
        $pdf->Cell(40, 10, $row['HORAS_POR_JORNADA'], 1); // Add border
        $pdf->Cell(40, 10, $row['SUBTOTAL_JORNADA'], 1); // Add border
        $pdf->Ln();

        $sumaDescuentos += $row['DESCUENTO'];
        $sumaSubtotal += $row['SUBTOTAL_JORNADA'];
    }

    $pdf->Cell(40, 10, 'Descuento Esta Semana: $' . $sumaDescuentos); // Add border
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Subtotal Esta Semana: $' . $sumaSubtotal); // Add border
    ob_end_clean();
    $pdf->Output();
} else {
    ob_end_clean();
    echo "<script>
    alert('No se encontraron registros para la cédula ingresada.');
    window.location.href = '../Vista/dashboard.php?action=reporte_semanal';
    </script>";
    exit();
}
