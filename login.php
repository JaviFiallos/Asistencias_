<?php
session_start();
include_once './Modelo/dto/Empleado.dto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];

    $empleadoDto = new Empleadodto();
    $empleado = $empleadoDto->iniciarSesion($cedula, $password);

    if ($empleado!=null) {
        $_SESSION['empleado'] = [
            'id' => $empleado->$id,
            'cedula' => $empleado->getCedula(),
            'nombre' => $empleado->getNombre(),
            'apellido' => $empleado->getApellido(),
            'correo' => $empleado->getCorreo(),
            'rol' => $empleado->getRol()
        ];
        header("Location: Vista/dashboard.php");
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href = 'index.php';</script>";
    }
}
?>
