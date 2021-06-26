<?php
include("GateRegisters.php");

$state_flags = read_register(3, 0, 30);
$temp = $state_flags[18+3];
if($temp&0x8000)
{
	$temp *= 1.6;
        $temp -= 65536;
        $temp /= 1.6;
}

$response = array(
    'numOfTurns'=>$state_flags[12+3]/1,
    'voltage'=>$state_flags[16+3]/100,
    'current'=>$state_flags[17+3]/100,
    'temperature'=>round($temp/10, 2),
    'stopedOnD1'=>($state_flags[11+3] & 4) > 0,
    'stopedOnD2'=>($state_flags[11+3] & 8) > 0,
    'stopedOnD3'=>($state_flags[11+3] & 16) > 0,
    'wasReseted'=>($state_flags[11+3] & 32) > 0,
    'stopedOnCurrent'=>($state_flags[11+3] & 2) > 0,
    'stopedOnTurns'=>($state_flags[11+3] & 32) > 0,
    'stopedOnNoTurns'=>($state_flags[11+3] & 2048) > 0,
);
exit( json_encode($response) );
?>
