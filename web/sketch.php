<?php
  $password = trim(file_get_contents("password"));
  if(isset($_COOKIE['session']) && $_COOKIE['session']==md5('yes')){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
      <meta http-equiv="Pragma" content="no-cache">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
      <title>Gate</title>
      <link rel="stylesheet" href="bootstrap.min.css">
      <link rel="stylesheet" href="main.css">
    </head>

    <body>
	<p id="message"></p>
        <div class="turns_indicator"><div></div></div>

	<div class="stat left">
        <span>Temperature: </span><span class="temperature"> <span></span>	&#8451 </span>
        </div>

        <div class="control">
          <div class="buttons">
          <form method="post" action="">
            <ul>
            <li><input class="btn" type="button" action="stop" value="STOP"></li>
            <li><input class="btn" type="button" action="open" value="Open"></li>
            <li><input class="btn" type="button" action="close" value="Close"></li>
            <li><input class="btn" type="button" action="door" value="Door"></li>
            <li><input class="vid_btn" type="button" action="Video" value="Video"></li>

            </ul>
          </form>
          </div>

          <div id="videoBlock">
          </div>


        </div>
        <div class="stat">
          <div class="numOfTurns"> Number of turns: <span></span></div>
          <div class="voltage">    Voltage: <span></span></div>
          <div class="current">    Current: <span></span></div>
          <div class="temperature">Temperature: <span></span></div>
          <div class="stopedOnD1">Stoped on D1: <span></span></div>
          <div class="stopedOnD2">Stoped on D2: <span></span></div>
          <div class="stopedOnD3">Stoped on D3: <span></span></div>
          <div class="stopedOnCurrent">Stoped on current: <span></span></div>
          <div class="stopedOnTurns">Stoped on numOfTurns: <span></span></div>
	  <div class="stopedOnNoTurns">Stoped on NoTurns: <span></span></div>
        </div>

      <script src="js/jquery-1.12.3.min.js"></script>
      <script src="bootstrap.min.js"></script>
      <script src="js/buttons.js?123"></script>
    </body>
    </html>
    <?php
  }
  else if(md5($_POST['password']) == $password){
    setcookie("session", md5("yes"), time() + 2592000);
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/sketch.php');
  }
  else{
    ?>

    <form method="post" action="sketch.php">
      <input name="password" type="password">
      <input type="submit" value="Log In">
    </form>
    <?php
  }
?>
