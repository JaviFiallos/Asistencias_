<?php
ob_start();
require_once ('../fpdf186/fpdf.php');
include_once ('conexion.php');

$conn = new Conexion();
$con = $conn->conectar();

$cedula = $_POST['cedula'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

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
    $pdf->Cell(40, 10, 'Reporte Semanal');
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Empleado: ' . $rowEmpleado['NOM_EMP'] . ' ' . $rowEmpleado['APE_EMP']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Cedula: ' . $rowEmpleado['CED_EMP']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Fecha');
    $pdf->Cell(40, 10, 'Jornada');
    $pdf->Cell(40, 10, 'Hora Entrada');
    $pdf->Cell(40, 10, 'Hora Salida');
    $pdf->Cell(35, 10, 'Descuento');
    $pdf->Cell(40, 10, 'Horas Trabajadas');
    $pdf->Cell(40, 10, 'Subtotal');
    $pdf->Ln();
    
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['FECHA']);
        $pdf->Cell(40, 10, $row['JORNADA']);
        $pdf->Cell(40, 10, $row['HORA_INGRESO']);
        $pdf->Cell(40, 10, $row['HORA_SALIDA']);
        $pdf->Cell(35, 10, $row['DESCUENTO']);
        $pdf->Cell(40, 10, $row['HORAS_POR_JORNADA']);
        $pdf->Cell(40, 10, $row['SUBTOTAL_JORNADA']);
        $pdf->Ln();

        $sumaDescuentos += $row['DESCUENTO'];
        $sumaSubtotal += $row['SUBTOTAL_JORNADA'];

        // Sumar las horas trabajadas
        $horasTrabajadas = new DateTime($row['HORAS_POR_JORNADA']);
        $totalHoras->add(new DateInterval('PT' . $horasTrabajadas->format('H') . 'H' . $horasTrabajadas->format('i') . 'M'));
    }

    // Formatear el total de horas trabajadas
    $totalHorasTrabajadas = $totalHoras->format('H:i');

    // Calcular descuentos y subtotales adicionales según las condiciones especificadas
    $totalHorasTrabajadasDecimal = ($totalHoras->format('H') * 60 + $totalHoras->format('i')) / 60; // Convertir total de horas trabajadas a decimal
    $expectedHoursPerWeek = 40;
    $hourlyRate = 8;
    $minuteDelayRate = 0.25 / 60; // Convertir ctv por minuto de retraso a dólares por minuto

    $lateMinutes = $sumaDescuentos * 4; // 0.25 ctv por minuto de retraso
    $missingHours = max(0, $expectedHoursPerWeek - $totalHorasTrabajadasDecimal);
    $penaltyForMissingHours = $missingHours * $hourlyRate;

    $subtotalSemana = $totalHorasTrabajadasDecimal * $hourlyRate;
    $totalDescuentos = $lateMinutes * $minuteDelayRate + $penaltyForMissingHours;

    $pdf->Cell(40, 10, 'Descuento Esta Semana: $' . number_format($totalDescuentos, 2));
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Horas Trabajadas Esta Semana: ' . $totalHorasTrabajadas);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Subtotal Esta Semana: $' . number_format($subtotalSemana, 2));
    ob_end_clean();
    $pdf->Output();
} else {
    ob_end_clean();
    echo "No se encontraron registros para la cédula y semana seleccionadas.";
    exit();
}
