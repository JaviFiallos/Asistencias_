<?php
include '../modelo/Conexion.php';
$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empleado = $_POST['ID_EMP'];

    $stmt = $conn->prepare("DELETE FROM HORARIOS WHERE ID_EMP_PER = ?");
    $stmt->bind_param("i", $id_empleado);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Horarios eliminados correctamente.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al eliminar los horarios: ' . $stmt->error;
    }

    echo json_encode($response);
}

$conexion->cerrarConexion();
?>
