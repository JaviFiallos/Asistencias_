<?php
include '../modelo/Conexion.php';
$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST['keyword'];

    // Preparar la consulta para buscar por cédula
    $stmt = $conn->prepare("SELECT ID_EMP AS id, NOM_EMP AS nombre, APE_EMP AS apellido, CED_EMP AS cedula FROM EMPLEADOS WHERE CED_EMP LIKE ?");
    $keywordParam = "%$keyword%";
    $stmt->bind_param("s", $keywordParam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No se encontraron resultados';
    }

    // Devolver la respuesta como JSON
    echo json_encode($response);
}

$stmt->close();
$conexion->cerrarConexion();
?>
