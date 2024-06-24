<?php
ob_start(); // Iniciar el buffer de salida para evitar cualquier salida prematura

require_once ('../fpdf186/fpdf.php');
include_once ('conexion.php');

$conn = new Conexion();
$con = $conn->conectar();

// Obtener los datos del formulario enviado por POST
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$sumaDescuentos = 0;
$sumaSubtotal = 0;
$sumaHorasTrabajadas = 0;

// Consulta SQL para obtener los registros de asistencia en el rango de fechas especificado
$sql = "SELECT empleados.CED_EMP, empleados.APE_EMP, registro_asistencia.FECHA, registro_asistencia.JORNADA, 
        registro_asistencia.HORA_INGRESO, registro_asistencia.HORA_SALIDA, registro_asistencia.DESCUENTO, 
        registro_asistencia.HORAS_POR_JORNADA, registro_asistencia.SUBTOTAL_JORNADA
        FROM registro_asistencia 
        JOIN empleados ON registro_asistencia.ID_EMP_PER = empleados.ID_EMP
        WHERE registro_asistencia.FECHA BETWEEN '$fechaInicio' AND '$fechaFin'
        ORDER BY empleados.CED_EMP, registro_asistencia.FECHA";

$result = $con->query($sql);

// Verificar si se encontraron registros
if ($result->num_rows > 0) {
    echo "Encontro";
    // Crear un nuevo objeto FPDF para generar el PDF en formato horizontal (L)
    $pdf = new FPDF('L');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    
    // Título del reporte
    $pdf->Cell(0, 10, 'Reporte Mensual', 0, 1, 'C');
    $pdf->Ln(10);
    
    // Encabezados de la tabla de asistencias
    $pdf->Cell(25, 10, 'Cedula', 1);
    $pdf->Cell(40, 10, 'Apellido', 1);
    $pdf->Cell(25, 10, 'Fecha', 1);
    $pdf->Cell(30, 10, 'Jornada', 1);
    $pdf->Cell(30, 10, 'Hora Entrada', 1);
    $pdf->Cell(30, 10, 'Hora Salida', 1);
    $pdf->Cell(25, 10, 'Descuento', 1);
    $pdf->Cell(37, 10, 'Horas Trabajadas', 1);
    $pdf->Cell(35, 10, 'Subtotal', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12); // Cambiar a fuente normal para el contenido

    $currentCedula = '';
    $totalesEmpleado = [];

    // Iterar sobre los resultados de la consulta y agregar cada registro al PDF
    while ($row = $result->fetch_assoc()) {
        if ($currentCedula !== $row['CED_EMP']) {
            if ($currentCedula !== '') {
                // Agregar totales por empleado
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(180, 10, 'Totales por Empleado:', 1);
                $pdf->Cell(25, 10, $totalesEmpleado['descuentos'], 1);
                $pdf->Cell(37, 10, $totalesEmpleado['horas'], 1);
                $pdf->Cell(35, 10, $totalesEmpleado['subtotal'], 1);
                 $pdf->Ln();
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 12);
                $totalesEmpleado = ['descuentos' => 0, 'horas' => 0, 'subtotal' => 0];
            }
            $currentCedula = $row['CED_EMP'];
        }

        $pdf->Cell(25, 10, $row['CED_EMP'], 1);
        $pdf->Cell(40, 10, $row['APE_EMP'], 1);
        $pdf->Cell(25, 10, $row['FECHA'], 1);
        $pdf->Cell(30, 10, $row['JORNADA'], 1);
        $pdf->Cell(30, 10, $row['HORA_INGRESO'], 1);
        $pdf->Cell(30, 10, $row['HORA_SALIDA'], 1);
        $pdf->Cell(25, 10, $row['DESCUENTO'], 1);
        $pdf->Cell(37, 10, $row['HORAS_POR_JORNADA'], 1);
        $pdf->Cell(35, 10, $row['SUBTOTAL_JORNADA'], 1);
        $pdf->Ln();

        // Sumar los descuentos, horas trabajadas y subtotales para el total del mes
        $sumaDescuentos += $row['DESCUENTO'];
        $sumaSubtotal += $row['SUBTOTAL_JORNADA'];
        $sumaHorasTrabajadas += $row['HORAS_POR_JORNADA'];

        // Sumar totales por empleado
        $totalesEmpleado['descuentos'] += $row['DESCUENTO'];
        $totalesEmpleado['horas'] += $row['HORAS_POR_JORNADA'];
        $totalesEmpleado['subtotal'] += $row['SUBTOTAL_JORNADA'];
    }

    // Agregar totales por último empleado
    if ($currentCedula !== '') {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(180, 10, 'Totales por Empleado:', 1);
        $pdf->Cell(25, 10, $totalesEmpleado['descuentos'], 1);
        $pdf->Cell(37, 10, $totalesEmpleado['horas'], 1);
        $pdf->Cell(35, 10, $totalesEmpleado['subtotal'], 1);
        $pdf->Ln();
    }
    $pdf->Cell(180, 10, ' ', 0);
    $pdf->Ln();
    // Mostrar el total de descuentos y subtotal del mes
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(180, 10, 'Totales Generales del Mes:', 1);
    $pdf->Cell(25, 10, $sumaDescuentos, 1);
    $pdf->Cell(37, 10, $sumaHorasTrabajadas, 1);
    $pdf->Cell(35, 10, $sumaSubtotal, 1);

    ob_end_clean(); // Limpiar el buffer de salida antes de enviar el PDF

    // Enviar el PDF al navegador como una descarga
    $pdf->Output();
} else {
    ob_end_clean();
    echo "No se encontraron registros para el mes seleccionado.";
    exit();
}
?>
