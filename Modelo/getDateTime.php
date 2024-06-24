<?php
date_default_timezone_set('America/Guayaquil');
$response = array(
    'date' => date("Y-m-d"),
    'time' => date("H:i:s")
);
echo json_encode($response);
?>
