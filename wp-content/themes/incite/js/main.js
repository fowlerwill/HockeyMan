jQuery(document).ready(function($) {
	$('#contactToggle').click(function(){
		$('#contactForm').slideToggle();
	});

	$('#menu-main li, #menu-mainmenu li').hover(function(){
		$(this).children('ul').filter(':not(:animated)').slideDown();
	},function(){
		$(this).children('ul').slideUp();
	});


	if($('.menu-toggle').is(':visible')) {
		
		$('#menu-main li a, #menu-mainmenu li a').has('ul').bind('hover click', function(e) {
			e.preventDefault().stopPropagation();
			$(this).siblings('ul').toggle();
		});
	}
});

jQuery('.menu-toggle').click(function() {
	if(jQuery('#masthead').css('position') == 'fixed')
		jQuery('#masthead').css({
			'position': 'absolute',
			'top': jQuery(document).scrollTop()});
	else
		jQuery('#masthead').css({
			'position': 'fixed',
			'top': 0});
})