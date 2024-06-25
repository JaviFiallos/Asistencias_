<?php
// Obtener la hora actual
date_default_timezone_set('America/Guayaquil');
$hora_actual = date("H:i:s");
//$hora_actual = "08:45:00";
$hora_actual_dt = new DateTime($hora_actual);
$entradaMatutino_dt = new DateTime($entradaMatutino);
$salidaMatutino_dt = new DateTime($salidaMatutino);
$entradaVespertino_dt = new DateTime($entradaVespertino);
$salidaVespertino_dt = new DateTime($salidaVespertino);

// Calcular márgenes de tiempo
$entradaMatutinoMargin = clone $entradaMatutino_dt;
$entradaMatutinoMargin->modify('-15 minutes');
$salidaMatutinoMargin = clone $salidaMatutino_dt;
$salidaMatutinoMarginR = clone $salidaMatutino_dt;
$salidaMatutinoMargin->modify('+10 minutes');
$salidaMatutinoMarginR->modify('+30 minutes');

$entradaVespertinoMargin = clone $entradaVespertino_dt;
$entradaVespertinoMargin->modify('-15 minutes');
$salidaVespertinoMargin = clone $salidaVespertino_dt;
$salidaVespertinoMarginR = clone $salidaVespertino_dt;
$salidaVespertinoMargin->modify('+10 minutes');
$salidaVespertinoMarginR->modify('+30 minutes');

// Comprobar registros del día actual para cada jornada
$matutinoRegistrado = false;
$vespertinoRegistrado = false;

foreach ($registros as $registro) {
    if ($registro['JORNADA'] === 'MATUTINA') {
        $matutinoRegistrado = true;
        $matutinoSalidaRegistrada = !is_null($registro['HORA_SALIDA']);
    }
    if ($registro['JORNADA'] === 'VESPERTINA') {
        $vespertinoRegistrado = true;
        $vespertinoSalidaRegistrada = !is_null($registro['HORA_SALIDA']);
    }
}
?>
