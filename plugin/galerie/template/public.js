$(document).ready(function(){
    $(".galerie .categories a").click(function(){
        $(".galerie #list li").hide();
        $(".galerie #list li."+$(this).attr('rel')).fadeIn();
    });
});