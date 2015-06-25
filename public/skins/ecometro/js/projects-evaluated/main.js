// Shortcut with fail-safe usage of $. Keep in mind that a reference
// to the jQuery function is passed into the anonymous function.
// Use $() without fear of conflicts.
jQuery(function ($) {
	$('select').on('change', function() {
  		$('form').submit();  		
	});

	$('.other-proyects').hover(function() {
		$(this).find('.header-project').css('background', '#44B84F');
	}, function(){
		$(this).find('.header-project').css('background', '#414042');
	});	
});