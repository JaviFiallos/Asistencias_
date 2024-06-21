<?php
    require_once ('../../fpdf186/fpdf.php');
    require_once ('../../Modelo/conexion.php');

    $conn = new Conexion();
    $con = $conn->conectar();

    $cedula = $_POST['cedula'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    $sql = "SELECT * FROM registro_asistencia WHERE FECHA BETWEEN '$fechaInicio' AND '$fechaFin' AND ID_EMP_PER = (
        SELECT ID_EMP FROM empleadoS WHERE CEDULA = '$cedula'
        
    )";
    $result = $con->query($sql);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Reporte Semanal de Asistencia');
    $pdf->Ln();
    $pdf->Cell(30, 10, "Cedula");
    $pdf->Cell(40, 10, "Nombre");
    $pdf->Cell(40, 10, "Apellido");
    $pdf->Cell(40, 10, "Direccion");
    $pdf->Cell(40, 10, "Telefono");

    $pdf->Output();