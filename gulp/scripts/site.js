/**
 * Various snippets which control actions around the site
 */
jQuery(function($){

	// Toggle Darkmode
	$('#darkmode-toggle').on('click', function(e){
		$('body').toggleClass('darkmode');
		$(this).toggleClass('darkmode');
	});


});