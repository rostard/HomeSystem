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

      }, 1000);
  });
  $('.btn').click(function(event){
    $.ajax({
          type: 'POST',
          url: 'gate.php',
          data: 'command=' + event.target.getAttribute("action"),
          success:function(msg){

            $('#message').html(msg);
          },
          ajaxError:function(){
            $('#message').html("fail");
          }
    });
  });
});
