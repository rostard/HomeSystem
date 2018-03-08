<?php
include("GateRegisters.php");

$light_state = read_register(5, 1, 1)[3];
$cam = pow(2, $_POST["index"]);
write_register(5, 1, $light_state ^ $cam);
?>
