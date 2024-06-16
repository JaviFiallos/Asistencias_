<?php

class Controller
{

    public function plantilla(){

        include "views/plantilla.php";
    }

    function enlacesPaginasController()
    {
        if(isset($_GET["action"]))
        {
            $enlacesController = $_GET["action"];
        }else{
            $enlacesController = "inicio.php";
        }

        $respuesta = EnlacesPaginas::enlacesPaginasModel($enlacesController);
        include $respuesta;
        //incluye todo el archivo, toda esa variable
    }
}
