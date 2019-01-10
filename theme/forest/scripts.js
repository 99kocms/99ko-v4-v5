jQuery(window).load(function(){
    var dif = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var winHeight = dif + document.documentElement.scrollHeight;
    $('#sidebar').css('height', winHeight+'px');
    $('#content').css('height', winHeight+'px');
});