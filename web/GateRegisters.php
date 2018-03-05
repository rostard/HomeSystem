<?php
const ConstOpenSpeed  = 8000;
const ConstOpenTurns = 1950;

const Modbus_addr_Door = 2;
const Modbus_addr_Gate  = 3;
const Num_regs_Gate     = 30;



// биты командных флажков CommandFlags
const GateComFlag_STOP              = 0x0001;	//Бит команды СТОП, сбрасывается автоматически после выполнения команды (приоритет по убыванию СТОП,ВПЕРЕД,НАЗАД)
const GateComFlag_ForvardPUSK       = 0x0002;		//Бит команды ВПЕРЕД, сбрасывается автоматически после выполнения команды
const GateComFlag_BackPUSK          = 0x0004;		//Бит команды НАЗАД, сбрасывается автоматически после выполнения команды
const GateComFlag_StopIfD1          = 0x0008;		//Бит разрешает остановку по концевому датчику D1
const GateComFlag_StopIfD2          = 0x0010;		//Бит разрешает остановку по концевому датчику D2
const GateComFlag_StopIfD3          = 0x0020;		//Бит разрешает остановку по концевому датчику D3
const GateComFlag_StopIfNumberTurns =	0x0040;		//Бит разрешает остановку по колличеству оборотов
const GateComFlag_Izm_DS18B20			  = 0x0080;		//Бит разрешает измерение температуры датчиком DS18B20
										//при установленном бите измерения проводятся раз в секунду
const GateComFlag_Izm_Sonar         =	0x0100;		//Бит разрешает измерение сонаром. После измерения бит сбрасывается.
const GateComFlag_OffPID            =	0x0200;		//Бит отключает работу ПИД, заполнение нужно изменять вручную


// Биты флажков состояния StateFlags
const GateStateFlag_Motor             = 0x0001;    	// Мотор работает
const GateStateFlag_StopOverCurrent   =	0x0002;		//Была остановка по превышению тока двигателя
const GateStateFlag_StopIfD1          = 0x0004;		//Была остановка по концевому датчику D1
const GateStateFlag_StopIfD2          = 0x0008;		//Была остановка по концевому датчику D2
const GateStateFlag_StopIfD3          = 0x0010;		//Была остановка по концевому датчику D3
const GateStateFlag_StopIfNumberTurns =	0x0020;		//Была остановка по полличеству оборотов двигателя
const GateStateFlag_D1                = 0x0040;		//текущее состояние концевого датчика D1
const GateStateFlag_D2				        = 0x0080;		//текущее состояние концевого датчика D2
const GateStateFlag_D3				        = 0x0100;		//текущее состояние концевого датчика D3
const GateStateFlag_Reset             = 0x0200;		//Был перезапуск программы
const GateStateFlag_Direction         = 0x0400;		//Показывает направление Когда установлен вперед, сброшен назад
const GateStateFlag_NoTurns           = 0x0800;		//Нет вращения вала(защита)


// биты командных флажков CommandFlags
const DoorComFlag_Door      = 0x0001;		//
const DoorComFlag_Gate      = 0x0002;		//
const DoorComFlag_Light     = 0x0004;		//
const DoorComFlag_IR_Mod    = 0x0008;		//

// Биты флажков состояния StateFlags
const DoorStateFlag_Door    = 0x0001;    	//
const DoorStateFlag_Gate    = 0x0002;		//
const DoorStateFlag_ifCard  = 0x0004;		//

const StateFlag_Reset       = 0x0200;		//


class MyCommands
{
    const CommandNofing=0;
   	const CommandOpenGate=1;
   	const CommandCloseGate=2;
   	const CommandStopGate=3;
   	const CommandOpenDoor=4;
   	const CommandCloseDoor=5;
   	const CommandInfoGate=6;
}


class NumberRegModbasGate
{
  const MBReg_AdrrModbus_Gate=0;
  const MBReg_proporc_Gate=1;
  const MBReg_integral_Gate=2;
  const MBReg_diferencial_Gate=3;
  const MBReg_K_proporc_Gate=4;
  const MBReg_K_integral_Gate=5;
  const MBReg_K_diferencial_Gate=6;
  const MBReg_PIDMaxErr_Gate=7;
  const MBReg_MaxCurrent_Gate=8;
  const MBReg_TimeMaxCurrent_Gate=9;
  const MBReg_CommandFlags_Gate=10;
  const MBReg_StateFlags_Gate=11;
  const MBReg_NumberOfTurns_Gate=12;
  const MBReg_MotorSpeedPWM_Gate=13;
  const MBReg_MotorSpeed_Gate=14;
  const MBReg_PIDrp_Gate=15;
  const MBReg_Sensor_Up_Gate=16;
  const MBReg_Densor_Imotor_Gate=17;
  const MBReg_TempDS18B20_Gate=18;
  const MBReg_SonarData_Gate=19;
  const MBReg_Cur_zero_offset_Gate=20;
  const MBReg_Cur_gain_Gate=21;
  const MBReg_PID_MaxPWM_Gate=22;
  const MBReg_PID_MinPWM_Gate=23;
  const MBReg_PID_MaxTurns_Gate=24;
  const MBReg_PID_MinTurns_Gate=25;
  const MBReg_PID_KickTurns_Gate=26;
  const MBReg_PID_KickPWM_Gate=27;
  const MBReg_PID_PWM_zerro_Gate=28;
  const MBReg_PID_PWM_gain_Gate=29;
}

class NumberRegModbasDoor
{
  const MBReg_AdrrModbus_Door=0;
  const MBReg_CommandFlags_Door=1;
  const MBReg_StateFlags_Door=2;
  const MBReg_Sensor_Up_Door=3;
  const MBReg_Densor_Imotor_Door=4;
  const MBReg_Cur_zero_offset_Door=5;
  const MBReg_Cur_gain_Door=6;
  const MBReg_CardsData_0_Door=7;
  const MBReg_CardsData_1_Door=8;
  const MBReg_CardsData_2_Door=9;
  const MBReg_CardsData_Save_0_Door=10;
  const MBReg_CardsData_Save_1_Door=11;
  const MBReg_CardsData_Save_2_Door=12;
  const MBReg_CardsData_Save_3_Door=13;
  const MBReg_CardsData_Save_4_Door=14;
  const MBReg_CardsData_Save_5_Door=15;
  const MBReg_CardsData_Save_6_Door=16;
  const MBReg_CardsData_Save_7_Door=17;
  const MBReg_CardsData_Save_8_Door=18;
  const MBReg_CardsData_Save_9_Door=19;
  const MBReg_CardsData_Save_10_Door=20;
  const MBReg_CardsData_Save_11_Door=21;
  const MBReg_CardsData_Save_12_Door=22;
  const MBReg_CardsData_Save_13_Door=23;
  const MBReg_CardsData_Save_14_Door=24;
  const MBReg_CardsData_Save_15_Door=25;
  const MBReg_CardsData_Save_16_Door=26;
  const MBReg_CardsData_Save_17_Door=27;
  const MBReg_CardsData_Save_18_Door=28;
  const MBReg_CardsData_Save_19_Door=29;
  const MBReg_CardsData_Save_20_Door=30;
  const MBReg_CardsData_Save_21_Door=31;
  const MBReg_CardsData_Save_22_Door=32;
  const MBReg_CardsData_Save_23_Door=33;
  const MBReg_CardsData_Save_24_Door=34;
  const MBReg_CardsData_Save_25_Door=35;
  const MBReg_CardsData_Save_26_Door=36;
  const MBReg_CardsData_Save_27_Door=37;
  const MBReg_CardsData_Save_28_Door=38;
  const MBReg_CardsData_Save_29_Door=39;
}

function read_register($address, $register, $number)
{
    exec("/var/www/html/modbus_io get -a".$address." -r".$register." -n".$number." 2>&1", $output, $return_value);
    return $output;
}

function write_register($address, $register, $value)
{
    exec("/var/www/html/modbus_io set -a".$address." -r".$register." -v".$value, $output, $return_value);
    return $output;
}

?>
