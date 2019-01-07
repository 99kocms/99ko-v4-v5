$(document).ready(function(){
    $("#notes_btn").click(function(){
        $("#notes_window").slideToggle();
    });
    $("#notes_content").keyup(function(){
        $.post('index.php?p=notes&save=1',
        {
          'content': $("#notes_content").html()
        },
        function(){
        }
      );
    });
    $.get("index.php?p=notes&list=1", function(data){
        $("#notes_content").html(data);
    });
});