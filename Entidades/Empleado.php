<?php

class Empleado {
    
    public $id;
    public $nombre;
    public $apellido;
    public $cedula;
    public $contra;
    public $rol;

    public function __construct($nombre, $apellido, $cedula, $contra, $rol)
{
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->cedula = $cedula;
    $this->contra = $contra;
    $this->rol = $rol;
}
}
?>