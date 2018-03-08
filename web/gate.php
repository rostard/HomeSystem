<?php

include("GateRegisters.php");

const GateCommandMask =  GateComFlag_Izm_DS18B20;

session_start();

if(!isset($_SESSION["id"])){
  $_SESSION["id"] = uniqid();
}

if(file_exists("uses_gate") && file_get_contents("uses_gate") != $_SESSION["id"] && !isset($_POST["force"])){
  exit($_POST['command']." busy");
}

function stopGate()
{
  write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_CommandFlags_Gate, GateComFlag_STOP | GateCommandMask);
  return $output;
}

function openGate(){
  $handle = fopen("uses_gate", "w");
  fwrite($handle, $_SESSION["id"]);
  fclose($handle);
  stopGate();
  write_register(Modbus_addr_Door, NumberRegModbasDoor::MBReg_CommandFlags_Door, DoorComFlag_Door);
  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_MotorSpeed_Gate, ConstOpenSpeed)[0] == "FAIL"){
    echo "Error";
  }
  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_NumberOfTurns_Gate, ConstOpenTurns)[0] == "FAIL"){
    echo "Error";
  }
  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_StateFlags_Gate, 0)[0] == "FAIL"){
    echo "Error";
  }

  $value = GateComFlag_BackPUSK | GateComFlag_StopIfD1 | GateCommandMask | GateComFlag_StopIfNumberTurns;

  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_CommandFlags_Gate, $value)[0] == "FAIL"){
    echo "Error";
  }
}

function closeGate(){
  stopGate();
  write_register(Modbus_addr_Door, NumberRegModbasDoor::MBReg_CommandFlags_Door, DoorComFlag_Door | DoorComFlag_Gate);
  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_MotorSpeed_Gate, ConstOpenSpeed)[0] == "FAIL"){
    echo "Error";
  }
  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_NumberOfTurns_Gate, ConstOpenTurns)[0] == "FAIL"){
    echo "Error";
  }
  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_StateFlags_Gate, 0)[0] == "FAIL"){
    echo "Error";
  }

  $value = GateComFlag_ForvardPUSK | GateComFlag_StopIfD2 | GateCommandMask | GateComFlag_StopIfNumberTurns;

  if(write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_CommandFlags_Gate, $value)[0] == "FAIL"){
    echo "Error";
  }
  unlink("uses_gate");
}

function openDoor(){
  write_register(Modbus_addr_Door, NumberRegModbasDoor::MBReg_CommandFlags_Door, DoorComFlag_Gate);
  sleep(1);
  write_register(Modbus_addr_Door, NumberRegModbasDoor::MBReg_CommandFlags_Door, (DoorComFlag_Gate|DoorComFlag_Door));
}


$myCommands = new MyCommands;
$numberRegModbasGate = new NumberRegModbasGate;
$numberRegModbasDoor = new NumberRegModbasDoor;

switch ($_POST['command']) {
  case 'stop':
  stopGate();
  echo 'STOP';
  break;
  case 'open':

  echo 'OPEN';
  openGate();
  break;
  case 'close':
  echo 'CLOSE';
  closeGate();
  break;
  case 'door':
  echo 'DOOR';
  openDoor();
  break;
  default:
  break;
}
?>
