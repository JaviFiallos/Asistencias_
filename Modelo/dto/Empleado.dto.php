<?php

include_once './Modelo/conexion.php';
include_once './Entidades/Empleado.php';

class Empleadodto {
    private $conect;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->conectar();
        $this->conect = $conexion->getConexion();
    }

    public function iniciarSesion($cedula, $contra) {
        if ($this->conect === null) {
            echo("Error: No se pudo conectar a la base de datos.");
            exit;
        }
        $query = "SELECT * FROM empleados 
                  WHERE CED_EMP = ? AND PASS_EMP = ?";
        $stmt = $this->conect->prepare($query);
        $stmt->bind_param("ss", $cedula, $contra);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {            
            //$empleado = new Empleado($row['ID_EMP'], $row['CED_EMP'], $row['PASS_EMP'], $row['NOM_EMP'], $row['APE_EMP'], $row['CORR_EMP'], $row['ROL_EMP']);
            $row = $result->fetch_assoc();
            $empleado = new Empleado();
            $empleado->setId($row['ID_EMP']);
            $empleado->setCedula($row['CED_EMP']);
            $empleado->setContra($row['PASS_EMP']);
            $empleado->setNombre($row['NOM_EMP']);
            $empleado->setApellido($row['APE_EMP']);
            $empleado->setCorreo($row['CORR_EMP']);
            $empleado->setRol($row['ROL_EMP']);
            return $empleado;
        } else {
            return null;
        }
    }
}

// Ejemplo de uso
//$emp = new Empleadodto();
//$resultado = $emp->iniciarSesion('1801', '1801');
//var_dump($resultado);

?>
