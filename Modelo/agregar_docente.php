<?php
    include '../modelo/Conexion.php';
    $conexion = new Conexion();
    $conexion->conectar();
    $conn = $conexion->getConexion();

    $cedula = $_POST["cedula"];
    $contrasena = $_POST["contrasena"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];

    $sql = "INSERT INTO empleados (CED_EMP, PASS_EMP, NOM_EMP, APE_EMP, CORR_EMP, ROL_EMP) VALUES ('$cedula', '$contrasena', '$nombre', '$apellido', '$correo', '$rol')";

    if ($conn->query($sql) == TRUE) {
        echo json_encode("Nuevo usuario creado correctamente");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


?>