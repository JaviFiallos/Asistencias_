<?php
include '../modelo/Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new Conexion();
    $conexion->conectar();
    $conn = $conexion->getConexion();

    // Obtener la cédula del estudiante a eliminar
    $cedula = $_POST["cedula"];

    // Sentencia SQL para eliminar el estudiante
    $sql = "DELETE FROM empleados WHERE CED_EMP = '$cedula'";

    // Ejecutar la consulta
    if ($conn->query($sql) == TRUE) {
        $response = [
            'status' => 'success',
            'message' => 'Estudiante eliminado correctamente'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error al intentar eliminar el estudiante: ' . $conn->error
        ];
    }

}
?>
