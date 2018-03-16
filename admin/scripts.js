$(document).ready(function () {
	$(".msg").delay(5000).fadeOut('slow');
	// tri menu
	var elem = $('#navigation').find('li').sort(sortMe);
	function sortMe(a, b){
			return a.className > b.className;
	}
	$('#navigation').append(elem);
	// login
	$('#login input.alert').click(function(){
		document.location.href= $(this).attr('rel');
	});
	// nav
	$('#open_nav').click(function(){
		if($('#sidebar').css('display') == 'none'){
			$('#sidebar').fadeIn();
		}
		else{
			$('#sidebar').hide();
		}
	});
	// param
	$('#param_link').click(function(){
		if($('#param_panel').css('display') == 'none'){
			$('#param_panel').fadeIn();
		}
		else{
			$('#param_panel').hide();
		}
	});
});