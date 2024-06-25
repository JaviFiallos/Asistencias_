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
    $id_emp = $_POST['id_emp'];
    $ced_emp = strtoupper($_POST['ced_emp']);
    $pass_emp = strtoupper($_POST['pass_emp']);
    $nom_emp = strtoupper($_POST['nom_emp']);
    $ape_emp = strtoupper($_POST['ape_emp']);
    $corr_emp = strtolower($_POST['corr_emp']);
    $rol_emp = strtoupper($_POST['rol_emp']);
    $est_emp = $_POST['est_emp'];

    // Preparar consulta SQL para actualizar empleado
    $sql = "UPDATE empleados
            SET CED_EMP = '$ced_emp', PASS_EMP = '$pass_emp', NOM_EMP = '$nom_emp', APE_EMP = '$ape_emp',
                CORR_EMP = '$corr_emp', ROL_EMP = '$rol_emp', EST_EMP = $est_emp
            WHERE ID_EMP = $id_emp";

    // Ejecutar la consulta
    if ($con->query($sql) === TRUE) {
        // Éxito al actualizar empleado
        echo json_encode(array('message' => 'Empleado actualizado correctamente'));
    } else {
        // Error al ejecutar la consulta SQL
        echo json_encode(array('error' => 'Error al actualizar empleado: ' . $con->error));
    }

    // Cerrar conexión
    $obj->cerrarConexion();
} else {
    // Método de solicitud no válido
    echo json_encode(array('error' => 'Método de solicitud no válido'));
}
?>
