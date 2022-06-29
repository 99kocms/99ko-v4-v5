$(document).ready(function () {
    $('#mobile_menu').click(function () {
        if ($('#navigation').css('display') == 'none') {
            $('#navigation').slideDown();
        } else {
            $('#navigation').slideUp();
        }
    });
    var pathname = window.location.href.split('#')[0];
    $('a[href^="#"]').each(function () {
        var $this = $(this),
                link = $this.attr('href');
        $this.attr('href', pathname + link);
    });
});