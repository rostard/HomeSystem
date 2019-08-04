function updateStats(){
    $.ajax({
      url:'gate-stat.php',
      type:'POST',
      dataType:'json',
      data: {some_params: 1},
      success:function(data){
        for(var key in data){
          if(key === "numOfTurns"){
            $(".turns_indicator>div").css("width", parseInt(data[key]/19.5)+"%");
          }
          $('.stat>.'+key+'>span').text(data[key]);
        }
      },

      complete: function(){
          setTimeout(updateStats, 500);
      }
    });
}

$(document).ready(function(){
  /*$(function(){
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
              $(".turns_indicator>div").css("width", parseInt(data[key]/19.5)+"%");
            }
            $('.stat>.'+key+'>span').text(data[key]);
          }
        }
      });

    }, 400);
  });*/
  updateStats();
  function sendCommand(event, parameter){
    $('#message').css("background-color", "#555555");
    $('#message').html("Waiting");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "gate.php", true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.onreadystatechange = function(){
        console.log(this.readyState);
	$('#message').html(this.readyState);
        if(this.readyState==3){
	    $('#message').html("Processing");
	}
	if(this.readyState==4){
            var msg = this.responseText;
            console.log("msg: "+msg);
            $('#message').css("background-color", "#f0f0f0");
            if(msg.slice(msg.length-4) == "busy"){
                if(confirm("The gate is busy. Are you sure")){
                    sendCommand(event, "force");
                }
            }
            else {
                $('#message').html(msg);
            }
        }
    }
    xhr.send('command=' + event.target.getAttribute("action") + "&" + parameter);

  }
  $('.vid_btn').click(function(event){
    document.getElementById('videoBlock').innerHTML = "<img src='http:\/\/boiko.asuscomm.com:8081/'>";
  });

  $('#videoBlock').click(function(event){
    document.getElementById('videoBlock').innerHTML = "";
  });

  $('.btn').click(function(event){
    sendCommand(event, "");
  });
});
