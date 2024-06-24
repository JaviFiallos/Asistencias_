<?php

class Empleado {
    
    private $id;
    private $nombre;
    private $apellido;
    private $correo;
    private $cedula;
    private $contra;
    private $rol;

    public function __construct() {}

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getCedula()
    {
        return $this->cedula;
    }

    public function getContra()
    {
        return $this->contra;
    }

    public function getRol()
    {
        return $this->rol;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setCorreo($email)
    {
        $this->correo = $email;
    }

    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    }

    public function setContra($contra)
    {
        $this->contra = $contra;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

}
?>