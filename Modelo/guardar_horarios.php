<?php
include '../modelo/Conexion.php';
$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();
$response = array(); // Arreglo para almacenar la respuesta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hora_inicio_matutina = $_POST['hora_inicio_matutina'];
    $hora_fin_matutina = $_POST['hora_fin_matutina'];
    $hora_inicio_vespertina = $_POST['hora_inicio_vespertina'];
    $hora_fin_vespertina = $_POST['hora_fin_vespertina'];
    $id_empleado = $_POST['ID_EMP'];

    // Función para calcular las horas de un rango de tiempo
    function calcularHoras($inicio, $fin) {
        if (empty($inicio) || empty($fin)) return 0;

        $inicioArray = explode(':', $inicio);
        $finArray = explode(':', $fin);

        $inicioHoras = intval($inicioArray[0]);
        $inicioMinutos = intval($inicioArray[1]);
        $finHoras = intval($finArray[0]);
        $finMinutos = intval($finArray[1]);

        $inicioTotalMinutos = ($inicioHoras * 60) + $inicioMinutos;
        $finTotalMinutos = ($finHoras * 60) + $finMinutos;

        $diferenciaMinutos = $finTotalMinutos - $inicioTotalMinutos;
        return $diferenciaMinutos / 60;
    }

    // Validar que la hora de inicio no sea mayor que la hora de fin
    function validarHorario($inicio, $fin) {
        if (empty($inicio) || empty($fin)) return false;

        $inicioArray = explode(':', $inicio);
        $finArray = explode(':', $fin);

        $inicioHoras = intval($inicioArray[0]);
        $inicioMinutos = intval($inicioArray[1]);
        $finHoras = intval($finArray[0]);
        $finMinutos = intval($finArray[1]);

        if ($inicioHoras > $finHoras) {
            return false;
        } elseif ($inicioHoras == $finHoras && $inicioMinutos >= $finMinutos) {
            return false;
        }

        return true;
    }

    // Calcular horas de jornada matutina y vespertina
    $horasMatutinas = calcularHoras($hora_inicio_matutina, $hora_fin_matutina);
    $horasVespertinas = calcularHoras($hora_inicio_vespertina, $hora_fin_vespertina);

    // Validar que no se excedan las 8 horas en total
    $totalHoras = $horasMatutinas + $horasVespertinas;

    // Validar que los horarios de entrada no sean mayores que los horarios de salida
    $validacionMatutina = validarHorario($hora_inicio_matutina, $hora_fin_matutina);
    $validacionVespertina = validarHorario($hora_inicio_vespertina, $hora_fin_vespertina);

    if ($totalHoras > 8 || !$validacionMatutina || !$validacionVespertina) {
        $response['status'] = 'error';
        if ($totalHoras > 8) {
            $response['message'] = 'El total de horas no debe exceder 8 horas.';
        } elseif (!$validacionMatutina) {
            $response['message'] = 'El horario de entrada matutino no puede ser mayor o igual al horario de salida.';
        } elseif (!$validacionVespertina) {
            $response['message'] = 'El horario de entrada vespertino no puede ser mayor o igual al horario de salida.';
        }
    } else {
        // Insertar horario matutino si existe
        if (!empty($hora_inicio_matutina) && !empty($hora_fin_matutina)) {
            $stmt = $conn->prepare("INSERT INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, ?, ?)");
            $jornadaMatutina = 'Matutina';
            $stmt->bind_param("sssi", $hora_inicio_matutina, $hora_fin_matutina, $jornadaMatutina, $id_empleado);
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Horario matutino guardado correctamente.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al guardar el horario matutino: ' . $stmt->error;
            }
        }

        // Insertar horario vespertino si existe
        if (!empty($hora_inicio_vespertina) && !empty($hora_fin_vespertina)) {
            $stmt = $conn->prepare("INSERT INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, ?, ?)");
            $jornadaVespertina = 'Vespertina';
            $stmt->bind_param("sssi", $hora_inicio_vespertina, $hora_fin_vespertina, $jornadaVespertina, $id_empleado);
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Horario vespertino guardado correctamente.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al guardar el horario vespertino: ' . $stmt->error;
            }
        }
        $stmt->close();
    }

    // Devolver la respuesta como JSON
    echo json_encode($response);
}

$conexion->cerrarConexion();
?>
