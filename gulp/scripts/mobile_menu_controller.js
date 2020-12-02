jQuery(function($){
	var $search_toggle = $('#medium-search-toggle'),
		$medium_search = $('#medium-search'),
		$mobile_nav_open = $('#mobile-navigation-open'),
		$mobile_nav_close = $('#mobile-navigation-close'),
		$mobile_nav = $('#mobile-navigation');
		resizeTimer = null;

	// Toggle our search bar on medium size screens
	$search_toggle.click(function(e){
		$medium_search.toggle();
	});

	$mobile_nav_open.click(function(e){
		$mobile_nav.show();
	});

	$mobile_nav_close.click(function(e){
		$mobile_nav.hide();
	});

	$(window).on('resize', function(e) {

		// Poor Man's debounce
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
			$medium_search.hide();
			$mobile_nav.hide();
		}, 200);

	});
	
});