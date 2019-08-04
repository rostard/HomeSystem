$(document).ready(function(){

  $('.vid_btn').click(function(event){
    document.getElementById('videoBlock').innerHTML = "<img src='http:\/\/boiko.asuscomm.com:8081/'>";
  });

  $('#videoBlock').click(function(event){
    document.getElementById('videoBlock').innerHTML = "";
  });

  var burger = document.querySelector('.burger-container'),
      header = document.querySelector('.header');

  burger.onclick = function() {
      header.classList.toggle('menu-opened');
  }

});
