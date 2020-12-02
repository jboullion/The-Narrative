<?php
	
	// if we aren't on the frontend, get out
	if(is_admin()) { return; }
	
	// auto change the powderkeg admin password to our default for FAST development
	add_action('init', 'sp_reset_powderkeg_password');
	function sp_reset_powderkeg_password() {

		// only run on the login screen to minimize how often it's run
		if(defined('ENVIRONMENT') && (ENVIRONMENT == 'dev') && ($_SERVER['REQUEST_URI'] == '/wp-login.php')) {
			
			// look up the user id (should be 1 in 99% of cases, but just to be sure)
			$user = get_user_by('login', 'powderkeg');
			if($user) {
				wp_set_password('eppki330', $user->ID);
			}
		}
	}

	// displays the pk logo on wp-login.php  page
	add_action('login_head', 'sp_login_head'); 
	function sp_login_head() {
	
		// customer logo css
		$logo = sp_get('pk-login-logo');
		if(!empty($logo)) {
		
			// physical stylesheet directory
			$dir = get_stylesheet_directory().'/styles/';
			
			// create stylesheet directory, if it doesn't exist
			if(!is_dir($dir)) { mkdir($dir); }
		
			// customer logo css file
			$css = $dir.'/login.css';
		
			// generate the customer logo css
			if(is_dir($dir) && !file_exists($css) && function_exists('getimagesize')) {
				$file = get_stylesheet_directory().'/'.$logo;
				if(file_exists($file)) {
					$size = getimagesize($file);
					if(is_array($size) && (count($size) > 1)) {
					
						// get width/height
						$width = $size[0];
						$height = $size[1];
						
						// generate new css file
						ob_start();
						@include(dirname(__FILE__).'/../misc/login.css.php');
						$output = ob_get_contents();
						ob_end_clean();
						
						// save css file
						if(!empty($output)) { file_put_contents($css, $output); }
					}
				}
			}
			
			// load the customer logo css
			if(file_exists($css)) {
				wp_enqueue_style('pk.login', get_template_directory_uri().'/styles/login.css'); 
				return;
			}
		}
		
		// default logo css
		wp_enqueue_style('pk.login', get_template_directory_uri().'/pk/styles/login.css'); 
	}
	
	// updates the link applied to the logo on the wp-login.php page from "http://wordpress.org" to the home page of the current website or blog.
	add_filter('login_headerurl', 'sp_login_headerurl'); 
	function sp_login_headerurl() { 
		return get_bloginfo('url'); 
	}

	// updates the title attribute for the logo on the wp-login.php page from "Powered by WordPress" to the name of the current website or blog.
	add_filter('login_headertitle', 'sp_login_headertitle'); 
	function sp_login_headertitle() { 
		return get_option('blogname'); 
	}

	// enqueue scripts and css files for the front end here
	/*
	add_action('wp_enqueue_scripts', 'sp_enqueue_scripts');
	function sp_enqueue_scripts() {
	
		// main stylesheet
		wp_enqueue_style('pk.main', get_stylesheet_directory_uri().'/style.less');
	}
	*/

	// add ie compatability
	add_action('wp_footer', 'sp_wp_footer', 500);
	function sp_wp_footer() {
		echo current_theme_supports('pk-html5shiv') ? '<!--[if lt IE 9]><script src="'.get_stylesheet_directory_uri().'/pk/lib/html5shiv/html5shiv.js"></script><![endif]-->' : '';
		echo current_theme_supports('pk-selectivizr') ? '<!--[if lt IE 9]><script src="'.get_stylesheet_directory_uri().'/pk/lib/selectivizr/selectivizr.min.js"></script><![endif]-->' : '';
		echo current_theme_supports('pk-responsive') ? '<!--[if lt IE 9]><script src="'.get_stylesheet_directory_uri().'/pk/lib/respond/respond.js"></script><![endif]-->' : '';
	}
	
	/**
	 * Build up all fonts into a single Google font call.
	 * @param  array  $fonts array(font_name => font_weights)
	 */
	function sp_webfont($fonts = array()){
		//example link
		//<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700|Merriweather:400,700,700i" rel="stylesheet">
		global $is_IE;

		if($is_IE){
			//IE < 9 cannot load multiple Google Fonts in one call.
			if(! empty($fonts)){
				foreach($fonts as $font_name => $font_weights){
					$slug = 'font-'.str_replace(' ', '-', strtolower(trim($font_name)));
					wp_register_style($slug, '//fonts.googleapis.com/css?family='.$font_name.':'.$font_weights);
					wp_enqueue_style($slug);
				}
			}else{
				wp_register_style('open-sans', '//fonts.googleapis.com/css?display=swap&family=Open+Sans:400,700');
				wp_enqueue_style('open-sans');
			}
			
		}else{
			//Load all fonts in one call
			$font_string = '';
			if(! empty($fonts)){
				$c = 0;
				foreach($fonts as $font_name => $font_weights){
					$font_string .= ($c > 0?'|':'').$font_name.':'.$font_weights;
					$c++;
				}
			}else{
				$font_string = 'Open+Sans:400,700';
			}
			
			wp_register_style('pk-fonts', '//fonts.googleapis.com/css?display=swap&family='.$font_string);
			wp_enqueue_style('pk-fonts');
		}
		
	}

	// update error messages displayed to give less info away
	add_filter('login_errors', 'sp_login_errors');
	if(!function_exists('sp_login_errors')) { // function is used/declared in the pk-update plugin as well
		function sp_login_errors() {
			return 'The username and password combination you entered is invalid. <a href="'.wp_lostpassword_url().'">Lost your password</a>?';
		}
	}

	/**
	 * Shortcode to display a video from the WYSIWYG more easily
	 */
	add_shortcode( 'pkInsertVideo', 'sp_insert_video' );
	function sp_insert_video( $atts ) {

		if( strpos($atts['link'],"youtu") ){
			if (preg_match('/list=(.*)$/i', $atts['link'], $match)) {
				$list_id = $match[1];
				$video_link = '//www.youtube.com/embed/videoseries?list='.$list_id;
			}else{
				$video_id = sp_get_youtube_id($atts['link']);
				$video_link = '//www.youtube.com/embed/'.$video_id;
			}

			$caption = $atts['title']?'<span>'.$atts['title'].'</span>':'';

			return '<p class="pk-video '.$atts['align'].'"><iframe src="'.$video_link.'" allowFullscreen="1"></iframe>'.$caption.'</p>';
		}
		
	}

	/*
	*  Make all embedded youtube videos modest / no related videos
	*/
	add_filter( 'oembed_result', 'sp_modest_youtube_player', 10, 3 );
	function sp_modest_youtube_player( $html, $url, $args ) {
		return str_replace( '?feature=oembed', '?feature=oembed&modestbranding=1&showinfo=0&rel=0', $html );
	}

	// hide admin bar non admin
	if(! current_user_can('edit_posts')) {
		add_filter('show_admin_bar', '__return_FALSE');
	}