<?php

class Controller
{

    function enlacesPaginasController()
    {
        if(isset($_GET["action"]))
        {
            $enlacesController = $_GET["action"];
        }else{
            $enlacesController = "home.php";
        }

        $respuesta = EnlacesPaginas::enlacesPaginasModel($enlacesController);
        include $respuesta;
        //incluye todo el archivo, toda esa variable
    }
}
