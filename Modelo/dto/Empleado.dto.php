<?php

include_once '../conexion.php';
include_once './Entidades/Empleado.php';

class Empleadodto{
    private $conect;
    private $empleado;

    public function __construct()
    {
        $this->conect = new Conexion();
    }

    public function iniciarSesion($cedula, $contra) {
        $query = "SELECT * FROM empleados 
                    WHERE CED_EMP='$cedula' AND PASS_EMP='$contra'";
        $result = $this->conect->con->query($query);
        

    }
}

?>