<?php
include '../Modelo/conexion.php'; // Asegúrate de que la ruta sea correcta
$obj = new Conexion();
$con = $obj->conectar();

if (!$con) {
    // Si la conexión no se establece correctamente
    echo json_encode(array('error' => 'Error en la conexión a la base de datos'));
    exit;
}

// Consulta SQL para obtener todos los empleados
$sql = "SELECT ID_EMP, CED_EMP, PASS_EMP, NOM_EMP, APE_EMP, CORR_EMP, EST_EMP, ROL_EMP FROM empleados";

// Ejecutar la consulta
$result = $con->query($sql);

if ($result === false) {
    // Si hay un error en la consulta SQL
    echo json_encode(array('error' => 'Error al ejecutar la consulta SQL: ' . $con->error));
    $obj->cerrarConexion();
    exit;
}

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Arreglo para almacenar los empleados
    $empleados = array();

    // Iterar sobre los resultados y almacenar en el arreglo
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }

    // Liberar resultado
    $result->free();
} else {
    // No se encontraron empleados
    $empleados = array(); // Devolver un arreglo vacío en JSON
}

// Cerrar conexión
$obj->cerrarConexion();

// Devolver los empleados en formato JSON
header('Content-Type: application/json');
echo json_encode($empleados);
?>
