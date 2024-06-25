<?php
include '../Modelo/conexion.php';

$obj = new Conexion();
$obj->conectar(); 
$con = $obj->getConexion();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todos los empleados
    if (!isset($_GET['id_emp'])) {
        $sql = "SELECT ID_EMP, CED_EMP, PASS_EMP, NOM_EMP, APE_EMP, CORR_EMP, EST_EMP, ROL_EMP FROM empleados";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $empleados = array();

            while ($row = $result->fetch_assoc()) {
                $empleados[] = $row;
            }

            $result->free();
            $obj->cerrarConexion();
            header('Content-Type: application/json');
            echo json_encode($empleados);
        } else {
            echo json_encode(array()); // Devolver un arreglo vacío en JSON si no hay empleados
        }
    } else {
        // Obtener un empleado específico por su ID
        $id_emp = $_GET['id_emp'];
        $sql = "SELECT ID_EMP, CED_EMP, NOM_EMP, APE_EMP, CORR_EMP, EST_EMP, ROL_EMP FROM empleados WHERE ID_EMP = $id_emp";
        $result = $con->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $empleado = $result->fetch_assoc();
                $result->free();
                $obj->cerrarConexion();
                header('Content-Type: application/json');
                echo json_encode($empleado);
            } else {
                echo json_encode(array()); // Devolver un arreglo vacío en JSON si no se encontró ningún empleado con ese ID
            }
        } else {
            echo json_encode(array()); // Devolver un arreglo vacío en JSON si hubo un error en la consulta
        }
    }
}
?>
