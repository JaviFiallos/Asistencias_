<?php
include '../modelo/Conexion.php';

$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();

$response = array(); // Array para almacenar la respuesta

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID_EMP'])) {
    $id_empleado = $_GET['ID_EMP'];

    $stmt = $conn->prepare("SELECT ID_HOR, ENTRADA, SALIDA, JORNADA FROM HORARIOS WHERE ID_EMP_PER = ?");
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $result = $stmt->get_result();

    $horarios = array();
    while ($row = $result->fetch_assoc()) {
        $horarios[] = $row;
    }

    $stmt->close();
    $response['status'] = 'success';
    $response['horarios'] = $horarios;
} else {
    $response['status'] = 'error';
    $response['message'] = 'ID_EMP no proporcionado o método incorrecto.';
}

// Devolver la respuesta como JSON
echo json_encode($response);

$conexion->cerrarConexion();
?>
