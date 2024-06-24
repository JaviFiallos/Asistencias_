<?php
include '../modelo/Conexion.php';
$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST['keyword'];

    $stmt = $conn->prepare("SELECT ID_EMP AS id, NOM_EMP AS nombre, APE_EMP AS apellido FROM EMPLEADOS WHERE NOM_EMP LIKE ? OR APE_EMP LIKE ?");
    $keywordParam = "%$keyword%";
    $stmt->bind_param("ss", $keywordParam, $keywordParam);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }

    echo json_encode($response);
}
?>
