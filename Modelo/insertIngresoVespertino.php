<?php
include '../Modelo/conexion.php'; // Asegúrate de que la ruta sea correcta
$obj = new Conexion();
$obj->conectar(); 
$con = $obj->getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $jornada = $_POST['jornada'];
    $horaIngreso = $_POST['hora_ingreso'];
    $idEmpPer = $_POST['id_emp_per'];

    // Aquí puedes calcular el descuento, horas por jornada y subtotal si es necesario
    $descuento = 0.00;
    $horasPorJornada = '00:00:00';
    $horaSalida = '00:00:00';
    $subtotalJornada = 0.00;

    $sql = "INSERT INTO registro_asistencia (FECHA, JORNADA, HORA_INGRESO, HORA_SALIDA, DESCUENTO, HORAS_POR_JORNADA, SUBTOTAL_JORNADA, ID_EMP_PER)
            VALUES ('$fecha', '$jornada', '$horaIngreso', '$horaSalida', '$descuento', '$horasPorJornada', '$subtotalJornada', '$idEmpPer')";
    if ($con) {

        if ($con->query($sql) === TRUE) {
            echo "Registro de asistencia insertado correctamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Registro de asistencia fallida";
    }

    $obj->cerrarConexion();
}
?>