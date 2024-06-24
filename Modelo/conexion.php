<?php

class Conexion {
    private $con;

    public function __construct() {
        $this->con = null;
    }

    public function conectar() {
        try {
            $this->con = mysqli_connect("localhost", "root", "", "asistencia");

            if (!$this->con) {
                throw new Exception("Error en la conexión: " . mysqli_connect_error());
            }

            echo "Se conectó exitosamente<br>";
            return $this->con;
        } catch (Exception $e) {
            echo "Excepción capturada: " . $e->getMessage() . "<br>";
        }
    }

    public function getConexion() {
        return $this->con;
    }

    public function cerrarConexion() {
        if ($this->con) {
            mysqli_close($this->con);
        } else {
            echo "No hay conexión para cerrar<br>";
        }
    }
}

?>
