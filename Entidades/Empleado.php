<?php

class Empleado {
    
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $cedula;
    public $contra;
    public $rol;

    public function __construct($id,$nombre, $apellido, $cedula,$email ,$contra, $rol)
{
    $this->id = $id;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->cedula = $cedula;
    $this->contra = $contra;
    $this->email = $email;
    $this->rol = $rol;
}
}
?>