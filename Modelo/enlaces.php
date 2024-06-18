<?php

class EnlacesPaginas {
    public static function enlacesPaginasModel($enlacesModel){
        if($enlacesModel == "usuarios" || 
        $enlacesModel == "asistencia"|| 
        $enlacesModel == "horarios_docentes"|| 
        $enlacesModel == "reporte_mensual"|| 
        $enlacesModel == "reporte_semanal" ){
            $modeule = "./Interfaces/".$enlacesModel.".php";
        }else {
            $modeule = "./Interfaces/home.php";
        }
        return $modeule;
    }
}
?>