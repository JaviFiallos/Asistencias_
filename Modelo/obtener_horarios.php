<?php
include '../modelo/Conexion.php';
$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID_EMP'])) {
    $id_empleado = $_GET['ID_EMP'];

    $response = array('status' => 'error', 'message' => 'No se encontraron horarios', 'horarios' => array());

    $stmt = $conn->prepare("SELECT ENTRADA, SALIDA, JORNADA FROM HORARIOS WHERE ID_EMP_PER = ?");
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $result = $stmt->get_result();

    $horarios = array('matutina' => array('inicio' => '', 'fin' => ''), 'vespertina' => array('inicio' => '', 'fin' => ''));
    while ($row = $result->fetch_assoc()) {
        if ($row['JORNADA'] == 'MATUTINA') {
            $horarios['matutina'] = array('inicio' => $row['ENTRADA'], 'fin' => $row['SALIDA']);
        } elseif ($row['JORNADA'] == 'VESPERTINA') {
            $horarios['vespertina'] = array('inicio' => $row['ENTRADA'], 'fin' => $row['SALIDA']);
        }
    }

    if (!empty($horarios['matutina']['inicio']) || !empty($horarios['vespertina']['inicio'])) {
        $response['status'] = 'success';
        $response['horarios'] = $horarios;
    }

    echo json_encode($response);
}

$conexion->cerrarConexion();
?>
