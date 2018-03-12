<?php
  $password = trim(file_get_contents("password"));
  if(isset($_COOKIE['session']) && $_COOKIE['session']==md5('yes')){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Gate</title>
      <link rel="stylesheet" href="bootstrap.min.css">
      <link rel="stylesheet" href="main.css">
    </head>

    <body>
      <!-- <div class="container">
        <p id="message">Ворота</p>
        <div class="row">
          <div class="col-md-4 col-xs-12">
            <div class="buttons">
            <form method="post" action="">
              <ul>
              <li><input class="btn" type="button" action="stop" value="STOP"></li>
              <li><input class="btn" type="button" action="open" value="Open"></li>
              <li><input class="btn" type="button" action="close" value="Close"></li>
              <li><input class="btn" type="button" action="door" value="Door"></li>
              </ul>
            </form>
            </div>
          </div>
          <div class="col-md-8 col-xs-12" >
            <div class="video">
            <img src="http://192.168.20.151:8081/">
          </div>
          </div>
        </div>
      </div> -->

        <p id="message">Ворота</p>
        <div class="control">
          <div class="buttons">
          <form method="post" action="">
            <ul>
            <li><input class="btn" type="button" action="stop" value="STOP"></li>
            <li><input class="btn" type="button" action="open" value="Open"></li>
            <li><input class="btn" type="button" action="close" value="Close"></li>
            <li><input class="btn" type="button" action="door" value="Door"></li>
            </ul>
          </form>
          </div>

          <div class="video">
            <img src="http://176.111.183.231:8081/">
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

        </div>

      <script src="jquery-1.12.3.min.js"></script>
      <script src="bootstrap.min.js"></script>
      <script src="buttons.js"></script>
    </body>
    </html>
    <?php
  }
  else if(md5($_POST['password']) == $password){
    setcookie("session", md5("yes"), time() + 50000);
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/sketch.php');
  }
  else{
    ?>
    <form method="post" action="sketch.php">
      <input name="password" type="text">
      <input type="submit" value="Log In">
    </form>';
    <?php
  }
?>
