<?php 
/**
 * These scripts will be used on more or less every page load and do setup work for the page.
 */

//Register our menu locations
register_nav_menus([
	'main_navigation'  => 'Main Navigation',
	//'top_nav'  => 'Top Navigation',
	//'terms_nav'  => 'Terms Navigation',
]);


// add_filter('acf/fields/google_map/api', 'sp_acf_google_map_api');
function sp_acf_google_map_api( $api ){
	$api['key'] = 'xxx';
	return $api;
}

// update email from address
//add_filter('wp_mail_from', function () { return ''; });
//add_filter('wp_mail_from_name', function() { return get_bloginfo('name'); });


add_action( 'init', 'sp_set_vars' );
function sp_set_vars() {
	$options = get_fields('options');
	sp_set('options', $options);
	
	// format a few address variables
	sp_set('single_line_street_address', str_replace('<br />', ' ', $options['street_address']));
	sp_set('single_line_full_address', sp_get('single_line_street_address').', '.$options['city'].', '.$options['state'].' '.$options['zip']);

	// format a few phone variables (and set a site wide phone format for consistency)
	sp_set('phone_formats', array('format-7'=>'$1-$2', 'format-10'=>"($1) $2-$3", 'format-11'=>"$1 ($2) $3-$4"));
	sp_set('phone_formatted', sp_format_phone($options['phone'], '', sp_get('phone_formats')));
	sp_set('fax_formatted', sp_format_phone($options['fax'], '', sp_get('phone_formats')));

	// enable customer login logo
	sp_set('pk-login-logo', 'images/logo.png');

	sp_set('yt-api-key', 'AIzaSyB2Tczkqj-yEx0_bAOZrDo6Exec7VMi970');

	// $self_study_slug_name = [
	// 	'cd-manual-package' => 'CD/Manual Package',
	// 	'downloadable-mp3-pdf' => 'Downloadable MP3+PDF',
	// 	'usb-mp3manual' => 'USB Mp3+Manual',
	// ];

}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (! sp_is_site_admin() ) {
		show_admin_bar(false);
	}
}

add_action('init', 'sp_register_cpts');
function sp_register_cpts() {

	sp_register_cpt(array('name' => 'channel', 'icon' => 'dashicons-format-video', 'position' => 30 ));
	//sp_register_cpt(array('name' => 'video', 'icon' => 'dashicons-format-video', 'position' => 30 ));

	sp_register_taxonomy('genre', 'channels', 'Genre');

	// Woocommerce Taxonomies 
	// sp_register_taxonomy('channel', 'videos', 'Channel');
	// sp_register_taxonomy('genre', 'videos', 'Genre');
	// sp_register_taxonomy('topic', 'videos', 'Topic');

	//unregister_taxonomy_for_object_type('post_tag', 'post');
	//unregister_taxonomy_for_object_type('product_tag', 'product');
}

add_action( 'after_setup_theme', 'sp_set_image_sizes' );
function sp_set_image_sizes() {
	// image sizes
	#add_image_size('extra-large', 1900, 1400, false);
	#add_image_size('image-960-480c', 960, 480, true);
}

add_filter('script_loader_tag', 'pk_async_attribute', 10, 2);
function pk_async_attribute($tag, $handle) {
	if ( 'jquery-core' !== $handle )
		return $tag;
	return str_replace( 'defer', '', $tag );
}

// front end scripts/css
add_action('wp_enqueue_scripts', 'sp_theme_enqueue_scripts', 9999);
function sp_theme_enqueue_scripts() {

	//wp_enqueue_script( 'jquery' );

	// jQuery
	if ( is_admin() || is_customize_preview() ) {
		// echo 'We are in the WP Admin or in the WP Customizer';
		return;
	} else {
		// Deregister WP core jQuery, see https://github.com/Remzi1993/wp-jquery-manager/issues/2 and https://github.com/WordPress/WordPress/blob/91da29d9afaa664eb84e1261ebb916b18a362aa9/wp-includes/script-loader.php#L226
		wp_deregister_script( 'jquery' ); // the jquery handle is just an alias to load jquery-core with jquery-migrate
		// Deregister WP jQuery
		wp_deregister_script( 'jquery-core' );
		// Deregister WP jQuery Migrate
		wp_deregister_script( 'jquery-migrate' );

		// Register jQuery in the head
		// if you don't need ajax or animations use this
		// https://code.jquery.com/jquery-3.5.0.slim.min.js
		wp_register_script( 'jquery-core', 'https://code.jquery.com/jquery-3.5.0.min.js', array(), null, false );

		/**
		 * Register jquery using jquery-core as a dependency, so other scripts could use the jquery handle
		 * see https://wordpress.stackexchange.com/questions/283828/wp-register-script-multiple-identifiers
		 * We first register the script and afther that we enqueue it, see why:
		 * https://wordpress.stackexchange.com/questions/82490/when-should-i-use-wp-register-script-with-wp-enqueue-script-vs-just-wp-enque
		 * https://stackoverflow.com/questions/39653993/what-is-diffrence-between-wp-enqueue-script-and-wp-register-script
		 */
		wp_register_script( 'jquery', false, array( 'jquery-core' ), null, false );
		wp_enqueue_script( 'jquery' );
	}

	wp_enqueue_style('bootswatch', get_stylesheet_directory_uri() . '/styles/bootstrap.min.css', array(), filemtime(get_stylesheet_directory().'/styles/bootstrap.min.css'));

	wp_enqueue_style('lity.css', 'https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.css', array(), '');
	wp_enqueue_script( 'lity.js', 'https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js', array(), '', true);

	// wp_enqueue_style('owl.css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), 2.3);
	// wp_enqueue_style('owl.theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array('owl.css'), 2.3);
	// wp_enqueue_script( 'owl.js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array(), 2.3, true);

	// wp_enqueue_style('slick.css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), '');
	// wp_enqueue_style('slick.theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array('slick.css'), '');
	// wp_enqueue_script( 'slick.js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), '', true);

	if(ENVIRONMENT != 'dev') {
		 // wp_enqueue_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue', array(), 2, true);

		wp_enqueue_style('live', get_stylesheet_directory_uri() . '/styles/live.css', array(), filemtime(get_stylesheet_directory().'/styles/live.css'));
		wp_enqueue_script('jquery.site', get_stylesheet_directory_uri() . '/js/live.js', 'jQuery', filemtime(get_stylesheet_directory().'/js/live.js'), true);
	} else {
		// wp_enqueue_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', array(), 2, true);

		wp_enqueue_style('dev', get_stylesheet_directory_uri().'/styles/dev.css', array(), time());
		wp_enqueue_script('jquery.site', get_stylesheet_directory_uri().'/js/dev.js', 'jQuery', time(), true);
	}

}

//putting Googlt Fonts in the footer improves pagespeed rankings
add_action('get_footer', 'sp_theme_enqueue_fonts', 10);
//if you are noticing a brief delay before fonts loads (usually when loading multiple fonts) you can load in the header to prevent flash, but take a hit on pagespeed rankings
//add_action('get_header', 'sp_theme_enqueue_fonts', 10);
function sp_theme_enqueue_fonts() {
	// Import Google Web Fonts
	$fonts = array(
			'Audiowide' => '700',
		);

	sp_webfont($fonts);
}

//Change "posts" name to "Announcements"
//add_filter('sp_change_post_label','sp_return_post_label');
function sp_return_post_label(){
	return 'Video';
}

// filter to disable/enable block editor on a specific basis, full post object is passed with post type
add_filter('use_block_editor_for_post', 'sp_use_block_editor_for_post', 9999, 2);
function sp_use_block_editor_for_post($use_block_editor, $post) {
	return false;
}
