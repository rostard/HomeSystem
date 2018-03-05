<?php

include("GateRegisters.php");

const GateCommandMask =  GateComFlag_Izm_DS18B20;

function stopGate()
{
  write_register(Modbus_addr_Gate, NumberRegModbasGate::MBReg_CommandFlags_Gate, GateComFlag_STOP | GateCommandMask);
  return $output;
}

function openGate(){
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
    echo "/var/www/html/modbus_io set -a".Modbus_addr_Door." -r".NumberRegModbasDoor::MBReg_CommandFlags_Door." -v".DoorComFlag_Gate;
    sleep(1);
    echo "/var/www/html/modbus_io set -a".Modbus_addr_Door." -r".NumberRegModbasDoor::MBReg_CommandFlags_Door." -v".(DoorComFlag_Gate|DoorComFlag_Door);
    echo exec('whoami');
    openDoor();
    break;
  default:
    break;
}
?>
