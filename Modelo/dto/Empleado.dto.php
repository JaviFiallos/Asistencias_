<?php

include_once '../conexion.php';
include_once '../../Entidades/Empleado.php';

class Empleadodto {
    private $conect;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->conectar();
        $this->conect = $conexion->getConexion();
    }

    public function iniciarSesion($cedula, $contra) {
        $query = "SELECT * FROM empleados 
                  WHERE CED_EMP = ? AND PASS_EMP = ?";
        $stmt = $this->conect->prepare($query);
        $stmt->bind_param("ss", $cedula, $contra);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $empleado = new Empleado($row['ID_EMP'], $row['CED_EMP'], $row['PASS_EMP'], $row['NOM_EMP'], $row['APE_EMP'], $row['CORR_EMP'], $row['ROL_EMP']);
            return $empleado;
        } else {
            return null;
        }
    }
}

// Ejemplo de uso
$emp = new Empleadodto();
$resultado = $emp->iniciarSesion('1801', '1801');
var_dump($resultado);

?>
