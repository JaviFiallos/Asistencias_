<?php
include '../Modelo/conexion.php'; // Asegúrate de que la ruta sea correcta
$obj = new Conexion();
$obj->conectar();
$con = $obj->getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $jornada = $_POST['jornada'];
    $horaEntrada = $_POST['horaEntrada']; // Hora de ingreso planeada (por ejemplo, 08:00:00 para matutina)
    $horaSalida = $_POST['horaSalida']; // Hora de salida planeada (por ejemplo, 13:00:00 para matutina)
    $horaRegistroDeIngreso = $_POST['horaRegistroDeIngreso']; // Hora real registrada de ingreso
    $horaRegistroDeSalida = $_POST['horaRegistroDeSalida']; // Hora real registrada de salida
    $idEmpPer = $_POST['id_emp_per'];

    $tasaPorHora = 8; // Suponiendo 8 dólares por hora
    $descuentoPorMinuto = 0.25; // Descuento por minuto atrasado
    $descuento = 0.00;
    $subtotalJornada = 0.00;

    if (!empty($horaRegistroDeIngreso) && !empty($horaRegistroDeSalida)) {
        // Calcular la duración de la jornada planeada
        $horaEntrada_dt = new DateTime($horaEntrada);
        $horaSalida_dt = new DateTime($horaSalida);
        $duracionJornada = $horaEntrada_dt->diff($horaSalida_dt);
        $horasJornadaPlaneada = $duracionJornada->h; // Horas de jornada planeada
        $minutosJornadaPlaneada = $duracionJornada->i; // Minutos de jornada planeada

        // Calcular minutos de atraso en ingreso
        $horaRegistroDeIngreso_dt = new DateTime($horaRegistroDeIngreso);
        $intervaloIngreso = $horaEntrada_dt->diff($horaRegistroDeIngreso_dt);
        $minutosAtrasadosIngreso = $intervaloIngreso->h * 60 + $intervaloIngreso->i; // Minutos de atraso

        // Calcular horas trabajadas
        $horaRegistroDeSalida_dt = new DateTime($horaRegistroDeSalida);
        $intervaloSalida = $horaRegistroDeIngreso_dt->diff($horaRegistroDeSalida_dt);
        $horasTrabajadas = $intervaloSalida->h; // Horas trabajadas
        $minutosTrabajados = $intervaloSalida->i; // Minutos trabajados

        // Verificar si no hubo atraso
        if ($horaRegistroDeIngreso_dt <= $horaEntrada_dt) {
            $descuento = 0.00;
            $horasTrabajadasReales = $horasJornadaPlaneada;
            $minutosTrabajadosReales = $minutosJornadaPlaneada;
        } else {
            // Calcular descuento por minutos de atraso en ingreso
            $descuento = $minutosAtrasadosIngreso * $descuentoPorMinuto;

            // Ajustar la jornada planeada por los minutos de atraso
            $totalMinutosJornadaPlaneada = ($horasJornadaPlaneada * 60) + $minutosJornadaPlaneada;
            $minutosJornadaReales = $totalMinutosJornadaPlaneada - $minutosAtrasadosIngreso;
            $horasJornadaReales = floor($minutosJornadaReales / 60);
            $minutosJornadaReales = $minutosJornadaReales % 60;

            $horasTrabajadasReales = $horasJornadaReales;
            $minutosTrabajadosReales = $minutosJornadaReales;
        }
        if ($descuento > 0) {
            $subtotalJornada = ($horasJornadaPlaneada * $tasaPorHora) - $descuento;
        } else {
            $subtotalJornada = $horasJornadaPlaneada * $tasaPorHora;
        }

        // Restar el descuento del subtotal de la jornada si hay descuento
        //$subtotalJornada -= $descuento;
    }

    // Actualizar el registro de asistencia con los cálculos
    $sql = "UPDATE registro_asistencia 
            SET HORA_SALIDA = '$horaRegistroDeSalida', 
                DESCUENTO = '$descuento', 
                HORAS_POR_JORNADA = '$horasTrabajadasReales:$minutosTrabajadosReales', 
                SUBTOTAL_JORNADA = '$subtotalJornada' 
            WHERE ID_EMP_PER = '$idEmpPer' AND FECHA = '$fecha' AND JORNADA = '$jornada'";

    if ($con) {
        if ($con->query($sql) === TRUE) {
            echo "Registro de salida actualizado correctamente";
        } else {
            echo "Error al actualizar el registro: " . $con->error;
        }
    } else {
        echo "Error: Conexión fallida";
    }

    $obj->cerrarConexion();
}
