
$(document).ready(function(){
  $(function(){
    var cnt = 0,
    timer = setInterval(function(){
      $.ajax({
        url:'gate-stat.php',
        type:'POST',
        dataType:'json',
        data: {some_params: 1},
        success:function(data){
          for(var key in data){
            if(key === "numOfTurns"){
              $(".turns_indicator>div").css("width", str(int(data[key])/1950)+"%");
            }
            $('.stat>.'+key+'>span').text(data[key]);
          }
        }
      });

    }, 400);
  });
  function sendCommand(event, parameter){

    $('#message').css("background-color", "#555555");
    $('#message').html("Waiting");

    $.ajax({
      type: 'POST',
      url: 'gate.php',
      data: 'command=' + event.target.getAttribute("action") + "&" + parameter,
      success:function(msg){
        $('#message').css("background-color", "#f0f0f0");
        if(msg.slice(msg.length-4) == "busy"){
          if(confirm("The gate is busy. Are you sure")){
            sendCommand(event, "force");
          }
        }
        else $('#message').html(msg);
      },
      ajaxError:function(){
        $('#message').css("background-color", "#ff0000");
        $('#message').html("fail");
      }
    });
  }

  $('.btn').click(function(event){
    sendCommand(event, "");
  });
});
