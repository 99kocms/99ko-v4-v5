$(document).ready(function(){
    $(".galerie-admin tr.hidden").hide();
    $(".galerie-admin .showall").click(function(){
        $(".galerie-admin tr.visible").toggle();
        $(".galerie-admin tr.hidden").toggle();
    });
    $(".galerie-admin .category").click(function(){
        $(".galerie-admin #category").val($(this).text());
    });
});