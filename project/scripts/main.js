(function(){
var menuState = 0;
  $('#menu').click(function(){
    //if state = 0 extend, otherwise hide
    if(menuState===0){
      $('#menu-box').css({'width': '300px'});
      menuState=1;
    }else{
      $('#menu-box').css({'width': '0px'});
      menuState=0;
    }
  });
  $('#main').click(function(){
    //when clicked off of the list do:
    menuState=0;
    document.getElementById("menu-box").style.width = "0px";
  });
  $('.sub').click(function(){
    $('li ul').toggle(); // sub list show or hide
  });
})();
