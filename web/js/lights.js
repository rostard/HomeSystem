$(document).ready(function(){
  $(function(){
      var cnt = 0,
      timer = setInterval(function(){
          $.ajax({
              url:'lights-stat.php',
              type:'POST',
              dataType:'json',
              data: {some_params: 1},
              success:function(data){
                  for(var key in data){
                      if(key.slice(0, 5) == "light"){
                          var color = "white";
                          if(data[key])color = "yellow";
                          $('.'+key+'>img').css('background-color', color);
                      }
                      $('.'+key+'>span').text(data[key]);
                  }
              }
          });

      }, 400);
  });
  $('.time_btn').click(function(event){
    $.ajax({
          type: 'POST',
          url: 'setAutoLightTime.php',
          data: 'from='+$('.time_from').val()+'&to='+$('.time_to').val(),
          success:function(msg){
              ('#message').html(msg);
          },
          ajaxError:function(){
            $('#message').html("fail");
          }
    });
  });

  $('.btn').click(function(event){
    var cam_url = "";
    switch (event.target.getAttribute("action")) {
      case "camera1":
        cam_url = "http://boiko.asuscomm.com:8081";
        break;
      case "camera2":
        cam_url = "http://boiko.asuscomm.com:8082";
        break;
      case "camera3":
        cam_url = "http://boiko.asuscomm.com:8083";
        break;
      case "camera4":
        cam_url = "http://boiko.asuscomm.com:8084";
        break;
      default:
    }
    $('.video>img').attr("src", cam_url);
  });
  $('.light_btn').click(function(event) {
    $.ajax({
          type: 'POST',
          url: 'setLight.php',
          data: 'index=' + event.target.getAttribute("index"),
          success:function(msg){

          },
          ajaxError:function(){
            $('#message').html("fail");
          }
    });
  });
});