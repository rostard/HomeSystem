<?php
include("GateRegisters.php");

$light_state = read_register(5, 1, 1)[3];
$response = array(
    'light1'=>($light_state & 1) > 0,
    'light2'=>($light_state & 2) > 0,
    'light3'=>($light_state & 4) > 0,
);
exit( json_encode($response) );
?>

