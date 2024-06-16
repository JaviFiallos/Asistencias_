<?php

class EnlacesPaginas {
    public static function enlacesPaginasModel($enlacesModel){
        if($enlacesModel == "usuarios" || 
        $enlacesModel == "asistencia" ){
            $modeule = "./Interfaces/".$enlacesModel.".php";
        }else {
            $modeule = "./Interfaces/home.php";
        }
        return $modeule;
    }
}
?>