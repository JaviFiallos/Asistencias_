<?php
include '../modelo/Conexion.php';

$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; 

    switch ($action) {
        case 'Eliminar':
            eliminarHorarios(); 
            break;
        case 'Editar':
            editarHorarios();
            break;
        case 'Asignar':
            asignarHorarios();
            break;
        default:
            $response['message'] = 'Acción no válida.';
            redirectWithMessage($response['message']);
            exit;
    }
}else {
    $response['message'] = 'Método de solicitud no válido.';
    redirectWithMessage($response['message']);
    exit;
}

function redirectWithMessage($message) {
    header("Location: ../Vista/dashboard.php?action=horarios_docentes&mensaje=" . urlencode($message));
    exit();
}

function eliminarHorarios() {
    global $conn;
    $id_empleado = $_POST['ID_EMP'];

    // Eliminar horarios matutinos si existen
    if (!empty($hora_inicio_matutina) && !empty($hora_fin_matutina)) {
        $stmt = $conn->prepare("DELETE FROM HORARIOS WHERE ID_EMP_PER = ?");
        $stmt->bind_param("ssi", $id_empleado);
        if ($stmt->execute()) {
            $response['message'] = 'Horarios matutinos eliminados correctamente.';
        } else {
            $response['message'] = 'Error al eliminar horarios matutinos: ' . $stmt->error;
        }
        $stmt->close();
    }

    // Eliminar horarios vespertinos si existen
    if (!empty($hora_inicio_vespertina) && !empty($hora_fin_vespertina)) {
        $stmt = $conn->prepare("DELETE FROM HORARIOS WHERE ENTRADA = ? AND SALIDA = ? AND JORNADA = 'Vespertina' AND ID_EMP_PER = ?");
        $stmt->bind_param("ssi", $hora_inicio_vespertina, $hora_fin_vespertina, $id_empleado);
        if ($stmt->execute()) {
            $response['message'] = 'Horarios vespertinos eliminados correctamente.';
        } else {
            $response['message'] = 'Error al eliminar horarios vespertinos: ' . $stmt->error;
        }
        $stmt->close();
    }

    redirectWithMessage($response['message']);
}

function editarHorarios() {
    global $conn;
    $id_empleado = $_POST['ID_EMP'];
    $hora_inicio_matutina = $_POST['hora_inicio_matutina'];
    $hora_fin_matutina = $_POST['hora_fin_matutina'];
    $hora_inicio_vespertina = $_POST['hora_inicio_vespertina'];
    $hora_fin_vespertina = $_POST['hora_fin_vespertina'];
    $response = array(); // Arreglo para almacenar la respuesta

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
        $jornadaMatutina = strtoupper('MATUTINA');
        $stmt = $conn->prepare("REPLACE INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $hora_inicio_matutina, $hora_fin_matutina, $jornadaMatutina, $id_empleado);
        $stmt->execute();

        // Guardar horarios vespertinos
        $jornadaVespertina = strtoupper('VESPERTINA');
        $stmt = $conn->prepare("REPLACE INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $hora_inicio_vespertina, $hora_fin_vespertina, $jornadaVespertina, $id_empleado);
        $stmt->execute();

        $response['status'] = 'success';
        $response['message'] = 'Horarios guardados correctamente.';
    }

    echo json_encode($response);
}

$conexion->desconectar();
?>
