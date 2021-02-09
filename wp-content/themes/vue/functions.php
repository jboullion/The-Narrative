<?php
	// // includes all flags for certain theme support
	// include('includes/theme-support.php');

	// // includes all of the default powderkeg functions and functionality
	// include('pk/functions.php');

	// // Track our custom fields in PHP so they sync correctly accross all sites
	// include('includes/acf.php');

	// // Include all our custom functionality
	// include('includes/setup.php');

	// // Various functions which help with tasks around the site
	// include('includes/helpers.php');

	// // Get stuff
	// include('includes/getters.php');

	// // Display stuff. Functional Components basically
	// include('includes/display.php');

	// // Modify queries
	// include('includes/queries.php');

	// // Return FA SVG icons
	// include('includes/bs-icons.php');




	add_action( 'init', 'jb_set_vars' );
	function jb_set_vars() {
		$options = get_fields('options');
		jb_set('options', $options);

		jb_set('yt-api-key', 'AIzaSyAiXvrjHqYkVxC4y1U1neEYGsTFQE2rvzY');// 'AIzaSyB2Tczkqj-yEx0_bAOZrDo6Exec7VMi970');

	}

