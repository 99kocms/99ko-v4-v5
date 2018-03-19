$(document).ready(function(){
    $(".galerie-admin .category").click(function(){
        $(".galerie-admin #category").val($(this).text());
    });
});