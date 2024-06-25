<?php
// Incluir la clase de conexión
require_once 'conexion.php';

// Crear instancia de la clase Conexion
$conexion = new Conexion();

// Conectar a la base de datos
$conn = $conexion->conectar();

if (!$conn) {
    // Si no se pudo conectar, enviar respuesta de error
    echo json_encode(array('message' => 'Error en la conexión a la base de datos'));
    exit();
}

// Consulta SQL para obtener los registros de asistencia
$sql = "SELECT ra.*, e.NOM_EMP, e.APE_EMP 
        FROM registro_asistencia ra
        INNER JOIN empleados e ON ra.ID_EMP_PER = e.ID_EMP";

// Si se proporcionó un keyword (búsqueda por cédula)
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    // Consultar el ID_EMP de la tabla empleados usando la cédula proporcionada
    $sql_emp = "SELECT ID_EMP FROM empleados WHERE CED_EMP = '$keyword'";
    $result_emp = mysqli_query($conn, $sql_emp);
    
    if (!$result_emp) {
        // Si la consulta falla, enviar respuesta de error
        echo json_encode(array('message' => 'Error al buscar empleado por cédula: ' . mysqli_error($conn)));
        exit();
    }
    
    // Obtener el ID_EMP del empleado
    $row_emp = mysqli_fetch_assoc($result_emp);
    $idEmpleado = $row_emp['ID_EMP'];
    
    // Añadir condición para filtrar por ID_EMP
    $sql .= " WHERE ra.ID_EMP_PER = $idEmpleado";
}

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    // Si la consulta falla, enviar respuesta de error
    echo json_encode(array('message' => 'Error al obtener los registros: ' . mysqli_error($conn)));
    exit();
}

// Crear un array para almacenar los registros
$registros = array();

// Iterar sobre los resultados y guardarlos en el array
while ($row = mysqli_fetch_assoc($resultado)) {
    $registros[] = $row;
}

// Liberar el resultado y cerrar la conexión
mysqli_free_result($resultado);
$conexion->cerrarConexion();

// Devolver los registros como JSON
echo json_encode($registros);
?>
