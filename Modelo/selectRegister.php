<?php

// Conectar a la base de datos
$obj = new Conexion();
$obj->conectar();
$con = $obj->getConexion();

$registros = array();

if ($con) {
    // Obtener la fecha actual
    date_default_timezone_set('America/Guayaquil');
    $fecha_actual = date("Y-m-d");
    

    // Consulta para obtener los registros de asistencia del día actual
    $queryRegistros = "SELECT FECHA, JORNADA, HORA_INGRESO, HORA_SALIDA, DESCUENTO, HORAS_POR_JORNADA, SUBTOTAL_JORNADA FROM registro_asistencia WHERE ID_EMP_PER = ? AND FECHA = ?";
    $stmtRegistros = $con->prepare($queryRegistros);
    $stmtRegistros->bind_param("is", $empleadoId, $fecha_actual);
    $stmtRegistros->execute();
    $resultRegistros = $stmtRegistros->get_result();

    while ($row = $resultRegistros->fetch_assoc()) {
        $registros[] = $row;
    }

    $stmtRegistros->close();
    $resultRegistros->close();
    $obj->cerrarConexion(); // Cerrar conexión a la base de datos
} else {
    echo "Error en la conexión a la base de datos";
}
?>

