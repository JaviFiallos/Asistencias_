<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../Modelo/conexion.php'; // Asegúrate de que la ruta sea correcta
    $obj = new Conexion();
    $con = $obj->conectar();

    if (!$con) {
        // Si la conexión no se establece correctamente
        echo json_encode(array('error' => 'Error en la conexión a la base de datos'));
        exit;
    }

    // Recibir ID del empleado a eliminar
    $id_emp = $_POST['id_emp'];

    // Preparar consulta SQL para eliminar empleado
    $sql = "DELETE FROM empleados WHERE ID_EMP = $id_emp";

    // Ejecutar la consulta
    if ($con->query($sql) === TRUE) {
        // Éxito al eliminar empleado
        echo json_encode(array('message' => 'Empleado eliminado correctamente'));
    } else {
        // Error al ejecutar la consulta SQL
        echo json_encode(array('error' => 'Error al eliminar empleado: ' . $con->error));
    }

    // Cerrar conexión
    $obj->cerrarConexion();
} else {
    // Método de solicitud no válido
    echo json_encode(array('error' => 'Método de solicitud no válido'));
}
?>
