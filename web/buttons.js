
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
            $('.stat>.'+key+'>span').text(data[key]);
          }
        }
      });

    }, 400);
  });
  function sendCommand(event, parameter){
    $.ajax({
      type: 'POST',
      url: 'gate.php',
      data: 'command=' + event.target.getAttribute("action") + "&" + parameter,
      success:function(msg){
        if(msg.slice(msg.length-4) == "busy"){
          if(confirm("The gate is busy. Are you sure")){
            sendCommand(event, "force");
          }
        }
        else $('#message').html(msg);
      },
      ajaxError:function(){
        $('#message').html("fail");
      }
    });
  }

  $('.btn').click(function(event){
    sendCommand(event, "");
  });
});
