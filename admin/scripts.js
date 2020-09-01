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
			$('#param_link').addClass('active');
			$('#help_panel').hide();
			$('#param_panel').fadeIn();
		}
		else{
			$('#param_link').removeClass('active');
			$('#param_panel').hide();
		}
	});
	// help
	$('#help_link').click(function(){
		if($('#help_panel').css('display') == 'none'){
			$('#help_link').addClass('active');
			$('#param_panel').hide();
			$('#help_panel').fadeIn();
		}
		else{
			$('#help_link').removeClass('active');
			$('#help_panel').hide();
		}
	});
});