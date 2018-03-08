<?php
$handle = fopen("auto_light_time", 'w') or die('Cannot open file:  '."auto_light_time");
 fwrite($handle, $_POST["from"]."-".$_POST["to"]);
 fclose($handle);
 ?>
