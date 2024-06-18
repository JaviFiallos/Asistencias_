<?php

if (!isset($_SESSION['empleado'])) {
    header("Location: ../../index.php");
    exit;
}

// Acceder a los datos del usuario logueado
$empleado = $_SESSION['empleado'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <style>
        .app-content-headerText h3 {
            text-align: center;
            margin: 20px 0;
        }
        .employee-info {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
        }
        .employee-info img {
            display: block;
            margin: auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="app-content-headerText">
        <h3>BIENVENIDO  </h3>
    </div>
    <div class="employee-info">
        <img src="../Utiles/Imagenes/<?php echo ($empleado['rol']);?>.png" alt="Imagen del Usuario">
        <p><?php echo htmlspecialchars($empleado['nombre']); ?></p>
        <p><?php echo htmlspecialchars($empleado['apellido']); ?></p>
        <p><?php echo htmlspecialchars($empleado['cedula']); ?></p>
        <p style="text-transform:lowercase"><?php echo ($empleado['correo']); ?></p>
        <p><?php echo htmlspecialchars($empleado['rol']); ?></p>
    </div>
</body>
</html>