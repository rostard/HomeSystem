<?php
  $time_str =  $_POST["from"]."-".$_POST["to"];
  $res = file_put_contents("auto_light_time.txt", $time_str);
  echo "set to ".$time_str;
?>
