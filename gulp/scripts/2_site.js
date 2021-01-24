/**
 * Various snippets which control actions around the site
 */
jQuery(function($){

	// Let's load all our lazy images
	$('img.lazy').Lazy();

	// Toggle Darkmode
	$('#darkmode-toggle').on('click', function(e){
		var darkmodeClass = 'darkmode';
		$('body').toggleClass(darkmodeClass);
		$(this).toggleClass(darkmodeClass);

		if($('body').hasClass(darkmodeClass)){
			jbSetCookie(darkmodeClass, 1, 365);
		}else{
			//console.log('delete cookie');
			jbDeleteCookie(darkmodeClass);
		}

		if(ajax_variables.user_id){
			$.post( "/api/user/toggle-darkmode.php", {user_id: ajax_variables.user_id}, function( result ) {
				console.log(result);
			}, 'json');
		}
	});

});