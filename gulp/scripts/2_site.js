/**
 * Various snippets which control actions around the site
 */
jQuery(function($){

	// Toggle Darkmode
	$('#darkmode-toggle').on('click', function(e){
		var darkmodeClass = 'darkmode';
		$('body').toggleClass(darkmodeClass);
		$(this).toggleClass(darkmodeClass);

		if($('body').hasClass(darkmodeClass)){
			jbSetCookie(darkmodeClass, 1, 365);
		}else{
			console.log('delete cookie');
			jbDeleteCookie(darkmodeClass);
		}
	});

});