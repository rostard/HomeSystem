<?php
  include("GateRegisters.php");

  $light_state = read_register(5, 1, 1)[3];
  $cam = pow(2, $_POST["index"]);
  if($light_state & $cam){
    file_put_contents("light_" . $_POST["index"] . ".txt", date("F d Y h:i A"));
  }
  else{
    file_put_contents("light_" . $_POST["index"] . ".txt", date("F d Y h:i A", strtotime("+2 hours")));
  }
  write_register(5, 1, $light_state ^ $cam);
?>
