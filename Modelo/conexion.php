<?php

class Conexion {

    public $con;

    public function __construct() {
        $this->con = mysqli_connect("localhost","root","1805162433","asistencia");
    }

    public function testConnection(){    
        if(!$this->con){
            die("Error".mysqli_connect_error());
        }else {
            print_r("Se conecto");
        }
    }
}

?>