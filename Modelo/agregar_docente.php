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

    // Recibir datos del formulario
    $ced_emp = strtoupper($_POST['ced_emp']);
    $pass_emp = strtoupper($_POST['pass_emp']);
    $nom_emp = strtoupper($_POST['nom_emp']);
    $ape_emp = strtoupper($_POST['ape_emp']);
    $corr_emp = strtolower($_POST['corr_emp']);
    $rol_emp = strtoupper($_POST['rol_emp']);

    // Preparar consulta SQL para insertar empleado
    $sql = "INSERT INTO empleados (CED_EMP, PASS_EMP, NOM_EMP, APE_EMP, CORR_EMP, EST_EMP, ROL_EMP)
            VALUES ('$ced_emp', '$pass_emp', '$nom_emp', '$ape_emp', '$corr_emp', 1, '$rol_emp')";

    // Ejecutar la consulta
    if ($con->query($sql) === TRUE) {
        // Éxito al insertar empleado
        echo json_encode(array('message' => 'Empleado insertado correctamente'));
    } else {
        // Error al ejecutar la consulta SQL
        echo json_encode(array('error' => 'Error al insertar empleado: ' . $con->error));
    }

    // Cerrar conexión
    $obj->cerrarConexion();
} else {
    // Método de solicitud no válido
    echo json_encode(array('error' => 'Método de solicitud no válido'));
}
?>
