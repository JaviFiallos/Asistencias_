<?php
include '../modelo/Conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cedula'])) {
    // Obtener los datos del formulario
    $cedula = $_POST['cedula'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    // Conexión a la base de datos
    $conexion = new Conexion();
    $conexion->conectar();
    $conn = $conexion->getConexion();

    // Consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE empleados SET PASS_EMP = ?, NOM_EMP = ?, APE_EMP = ?, CORR_EMP = ?, ROL_EMP = ? WHERE CED_EMP = ?";
    
    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $contrasena, $nombre, $apellido, $correo, $rol, $cedula);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        echo json_encode(array('success' => 'Usuario actualizado correctamente'));
    } else {
        echo json_encode(array('error' => 'Error al actualizar el usuario'));
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('error' => 'Petición no válida'));
}
?>
