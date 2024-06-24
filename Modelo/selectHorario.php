<?php
// Conectar a la base de datos
$obj = new Conexion();
$obj->conectar();
$con = $obj->getConexion();

$horarioMatutino = array();
$horarioVespertino = array();

if ($con) {
    // Consulta matutina
    $queryMatutino = "SELECT ENTRADA, SALIDA, JORNADA FROM horarios WHERE ID_EMP_PER = ? AND JORNADA = 'MATUTINA'";
    $stmtMatutino = $con->prepare($queryMatutino);
    $stmtMatutino->bind_param("i", $empleadoId);
    $stmtMatutino->execute();
    $resultMatutino = $stmtMatutino->get_result();

    while ($row = $resultMatutino->fetch_assoc()) {
        $horarioMatutino[] = $row;
    }

    $stmtMatutino->close();
    $resultMatutino->close();

    // Consulta vespertina
    $queryVespertino = "SELECT ENTRADA, SALIDA, JORNADA FROM horarios WHERE ID_EMP_PER = ? AND JORNADA = 'VESPERTINA'";
    $stmtVespertino = $con->prepare($queryVespertino);
    $stmtVespertino->bind_param("i", $empleadoId);
    $stmtVespertino->execute();
    $resultVespertino = $stmtVespertino->get_result();

    while ($row = $resultVespertino->fetch_assoc()) {
        $horarioVespertino[] = $row;
    }

    $stmtVespertino->close();
    $resultVespertino->close();

    $obj->cerrarConexion(); // Cerrar conexión a la base de datos
} else {
    echo "Error en la conexión a la base de datos";
}

// jornana matutina
foreach ($horarioMatutino as $horario) {
    $jornadaMatutino = $horario["JORNADA"];
    $entradaMatutino = $horario["ENTRADA"];
    $salidaMatutino = $horario["SALIDA"];
    
}
// jornana vespertina
foreach ($horarioVespertino as $horario) {
    $jornadaVespertino = $horario["JORNADA"];
    $entradaVespertino = $horario["ENTRADA"];
    $salidaVespertino = $horario["SALIDA"];
}

?>
