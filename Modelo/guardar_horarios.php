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

    // Validar y editar horarios matutinos si existen
    if (!empty($hora_inicio_matutina) && !empty($hora_fin_matutina)) {
        if (!validarHorario($hora_inicio_matutina, $hora_fin_matutina)) {
            $response['status'] = 'error';
            $response['message'] = 'El horario de entrada matutino no puede ser mayor o igual al horario de salida.';
        } else {
            // Calcular las horas de jornada matutina
            $horasMatutinas = calcularHoras($hora_inicio_matutina, $hora_fin_matutina);

            if ($horasMatutinas > 8) {
                $response['status'] = 'error';
                $response['message'] = 'El total de horas matutinas no debe exceder 8 horas.';
            } else {
                $stmt = $conn->prepare("UPDATE HORARIOS SET ENTRADA = ?, SALIDA = ? WHERE JORNADA = 'Matutina' AND ID_EMP_PER = ?");
                $stmt->bind_param("ssi", $hora_inicio_matutina, $hora_fin_matutina, $id_empleado);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Horarios matutinos actualizados correctamente.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error al actualizar horarios matutinos: ' . $stmt->error;
                }
                $stmt->close();
            }
        }
    }

    // Validar y editar horarios vespertinos si existen
    if (!empty($hora_inicio_vespertina) && !empty($hora_fin_vespertina)) {
        if (!validarHorario($hora_inicio_vespertina, $hora_fin_vespertina)) {
            $response['status'] = 'error';
            $response['message'] = 'El horario de entrada vespertino no puede ser mayor o igual al horario de salida.';
        } else {
            // Calcular las horas de jornada vespertina
            $horasVespertinas = calcularHoras($hora_inicio_vespertina, $hora_fin_vespertina);

            if ($horasVespertinas > 8) {
                $response['status'] = 'error';
                $response['message'] = 'El total de horas vespertinas no debe exceder 8 horas.';
            } else {
                $stmt = $conn->prepare("UPDATE HORARIOS SET ENTRADA = ?, SALIDA = ? WHERE JORNADA = 'Vespertina' AND ID_EMP_PER = ?");
                $stmt->bind_param("ssi", $hora_inicio_vespertina, $hora_fin_vespertina, $id_empleado);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Horarios vespertinos actualizados correctamente.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error al actualizar horarios vespertinos: ' . $stmt->error;
                }
                $stmt->close();
            }
        }
    }

    redirectWithMessage($response['message']);
}

function asignarHorarios() {
    global $conn, $response;
    $id_empleado = $_POST['ID_EMP'];
    $hora_inicio_matutina = $_POST['hora_inicio_matutina'];
    $hora_fin_matutina = $_POST['hora_fin_matutina'];
    $hora_inicio_vespertina = $_POST['hora_inicio_vespertina'];
    $hora_fin_vespertina = $_POST['hora_fin_vespertina'];

    // Asignar horarios matutinos si existen
    if (!empty($hora_inicio_matutina) && !empty($hora_fin_matutina)) {
        $stmt = $conn->prepare("INSERT INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, 'MATUTINA', ?)");
        $stmt->bind_param("ssi", $hora_inicio_matutina, $hora_fin_matutina, $id_empleado);
        if ($stmt->execute()) {
            $response['message'] = 'Horarios matutinos asignados correctamente.';
        } else {
            $response['message'] = 'Error al asignar horarios matutinos: ' . $stmt->error;
        }
        $stmt->close();
    }

    // Asignar horarios vespertinos si existen
    if (!empty($hora_inicio_vespertina) && !empty($hora_fin_vespertina)) {
        $stmt = $conn->prepare("INSERT INTO HORARIOS (ENTRADA, SALIDA, JORNADA, ID_EMP_PER) VALUES (?, ?, 'VESPERTINA', ?)");
        $stmt->bind_param("ssi", $hora_inicio_vespertina, $hora_fin_vespertina, $id_empleado);
        if ($stmt->execute()) {
            $response['message'] = 'Horarios vespertinos asignados correctamente.';
        } else {
            $response['message'] = 'Error al asignar horarios vespertinos: ' . $stmt->error;
        }
        $stmt->close();
    }
    redirectWithMessage($response['message']);
}

$conexion->desconectar();
?>
