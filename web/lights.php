<?php
  $password = trim(file_get_contents("password"));
  list($from_time, $to_time) = explode("-", trim(file_get_contents("auto_light_time.txt")));
  if(isset($_COOKIE['session']) && $_COOKIE['session']==md5('yes')){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Lights</title>
      <link rel="stylesheet" href="bootstrap.min.css">
      <link rel="stylesheet" href="main.css">
    </head>

    <body>
        <p id="message">Свет</p>
        <div class="control">
          <div class="video">
            <img src="http://192.168.20.151:8081/">
          </div>
          <div class="buttons">
            <form method="post" action="">
              <ul>
              <li><input class="btn" type="button" action="camera1" value="Frontyard"></li>
              <li><input class="btn" type="button" action="camera2" value="Side"></li>
              <li><input class="btn" type="button" action="camera3" value="Backyard"></li>
              <li><input class="btn" type="button" action="camera4" value="Front"></li>
              </ul>
            </form>
          </div>
        </div>

        <div class="light1">L1 <span> </span> <input class="light_btn" type="button" index=0> </div>
        <div class="light2">L2 <span> </span> <input class="light_btn" type="button" index=1> </div>
        <div class="light3">L3 <span> </span> <input class="light_btn" type="button" index=2> </div>

          <div class="auto_light_time">
            <form action="set_auto_light_time.php" method="post">
              <input type="number" class="time_from" value="<?php echo $from_time; ?>">
              <input type="number" class="time_to" value="<?php echo $to_time; ?>">
              <input class="time_btn" type="button" name="submit_btn" value="Submit">
            </form>
          </div>

      <script src="jquery-1.12.3.min.js"></script>
      <script src="bootstrap.min.js"></script>
      <script src="lights.js"></script>
    </body>
    <?php
  }
  else if(md5($_POST['password']) == $password){
    setcookie("session", md5("yes"), time() + 50000);
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/lights.php');
  }
  else{
    ?>
    <form method="post" action="lights.php">
      <input name="password" type="text">
      <input type="submit" value="Log In">
    </form>
    <?php
  }
?>
