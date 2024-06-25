<?php
include '../modelo/Conexion.php';
$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hora_inicio_matutina = $_POST['hora_inicio_matutina'];
    $hora_fin_matutina = $_POST['hora_fin_matutina'];
    $hora_inicio_vespertina = $_POST['hora_inicio_vespertina'];
    $hora_fin_vespertina = $_POST['hora_fin_vespertina'];
    $id_empleado = $_POST['ID_EMP'];

    // Validaciones
    function validarHorario($inicio, $fin) {
        return strtotime($inicio) < strtotime($fin);
    }

    if (!validarHorario($hora_inicio_matutina, $hora_fin_matutina)) {
        $response['status'] = 'error';
        $response['message'] = 'El horario de entrada matutino no puede ser mayor o igual al horario de salida.';
    } elseif (!validarHorario($hora_inicio_vespertina, $hora_fin_vespertina)) {
        $response['status'] = 'error';
        $response['message'] = 'El horario de entrada vespertino no puede ser mayor o igual al horario de salida.';
    } else {
        // Guardar horarios matutinos
        $jornadaMatutina = strtoupper('Matutina');
        $stmt = $conn->prepare("REPLACE INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $hora_inicio_matutina, $hora_fin_matutina, $jornadaMatutina, $id_empleado);
        $stmt->execute();

        // Guardar horarios vespertinos
        $jornadaVespertina = strtoupper('Vespertina');
        $stmt = $conn->prepare("REPLACE INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $hora_inicio_vespertina, $hora_fin_vespertina, $jornadaVespertina, $id_empleado);
        $stmt->execute();

        $response['status'] = 'success';
        $response['message'] = 'Horarios guardados correctamente.';
    }

    echo json_encode($response);
}

$conexion->cerrarConexion();
?>
