$(document).ready(function(){
    $('#mobile_menu').click(function(){
        if($('#navigation').css('display') == 'none'){
            $('#navigation').slideDown();
        }
        else{
            $('#navigation').slideUp();
        }
    });
});