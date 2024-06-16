<?php

class EnlacesPaginas {
    public static function enlacesPaginasModel($enlacesModel){
        if($enlacesModel == "nosotros" || 
        $enlacesModel == "servicios" || 
        $enlacesModel == "contactanos" ){
            $modeule = "views/interfaces/".$enlacesModel.".php";
        }else {
            $modeule = "views/interfaces/inicio.php";
        }
        return $modeule;
    }
}
?>