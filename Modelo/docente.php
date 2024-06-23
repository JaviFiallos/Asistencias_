<?php

include '../modelo/Conexion.php';
$conexion = new Conexion();
$conexion->conectar();
$conn = $conexion->getConexion();

$sqlSelect = "SELECT CED_EMP AS Cedula, PASS_EMP AS Contraseña, NOM_EMP AS Nombre, APE_EMP AS Apellido, CORR_EMP AS Correo, ROL_EMP AS Rol FROM empleados";
$respuesta = $conn->query($sqlSelect);

$resultado = "";
if ($respuesta->num_rows > 0) {
    $contador = 1;
    while ($fila = $respuesta->fetch_assoc()) {
        $resultado .= "<tr>";
        $resultado .= "<td><span class='custom-checkbox'><input type='checkbox' id='checkbox{$contador}' name='options[]' value='{$fila['Cedula']}'><label for='checkbox{$contador}'></label></span></td>";
        $resultado .= "<td>{$fila['Cedula']}</td>";
        $resultado .= "<td>{$fila['Contraseña']}</td>";
        $resultado .= "<td>{$fila['Nombre']}</td>";
        $resultado .= "<td>{$fila['Apellido']}</td>";
        $resultado .= "<td>{$fila['Correo']}</td>";
        $resultado .= "<td>{$fila['Rol']}</td>";
        $resultado .= "<td>";
        $resultado .= "<a href='#editEmployeeModal' class='edit' data-toggle='modal'><i class='material-icons' data-toggle='tooltip' title='Editar'>&#xE254;</i></a>";
        $resultado .= "<a href='#deleteEmployeeModal' class='delete' data-toggle='modal'><i class='material-icons' data-toggle='tooltip' title='Eliminar'>&#xE872;</i></a>";
        $resultado .= "</td>";
        $resultado .= "</tr>";
        $contador++;
    }
} else {
    $resultado = "<tr><td colspan='6'>No hay empleados registrados</td></tr>";
}

echo $resultado;

?>
