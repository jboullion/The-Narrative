<?php
	
	// prints out an array with <pre> tags
	function sp_print($input, $force = false) { 
		if(ENVIRONMENT != 'live' || $force === true){
			echo '<pre class="pk-print">'.print_r($input, true).'</pre>'; 
		}
	}

	// Defer jQuery Parsing using the HTML5 defer property
	//http://www.laplacef.com/2014/05/24/how-to-defer-parsing-javascript-in-wordpress/
	if (!(is_admin() )) {
		function defer_parsing_of_js ( $url ) {
			if ( FALSE === strpos( $url, '.js' ) ) return $url;
			if ( strpos( $url, 'jquery.js' ) ) return $url;
			// return "$url' defer ";
			return "$url' defer onload='";
		}
		add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
	}


	//remove jquery migrate
	// add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );
	// function dequeue_jquery_migrate( &$scripts){
	// 	if(!is_admin()){
	// 		$scripts->remove( 'jquery');
	// 		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	// 	}
	// }

	//short function call for sp_print
	function pkp($input, $force = false) { 
		sp_print($input, $force);
	}

	// remove 'http(s)://' from any passed url
	function sp_filter_http($input) { return preg_replace('/^http[s]?:\/\/([^\/]*)/i', '', $input); }
		
	// recursively cycles through the post hierarchy to find all children infinte levels down
	function sp_get_all_children($parent_post = null, $orderby = 'menu_order', $order = 'ASC', $num_posts = '-1') {
		global $post;
		
		if(!$parent_post) { $parent_post = $post; }
		elseif(is_numeric($parent_post)) { $parent_post = get_post($parent_post); }
		
		if(count($children = get_posts(array('numberposts'=>$num_posts, 'order'=>$order, 'orderby'=> $orderby, 'post_parent'=>$parent_post->ID, 'post_type'=>$parent_post->post_type)))) {
			foreach($children as &$c) {
				$c->children = sp_get_all_children($c);
			}
			return $children;
		}
	}
	
	// cycles through the current post hierarchy to find the parent post
	function sp_get_post_hierarchy($parent_post = '') {
		
		// if an id isn't provided, use the current post
		if(!$parent_post) { global $post; $parent_post = $post; }
		
		// if there still isn't a parent post, gtfo
		if(!$parent_post) { return; }
		
		// "climb" the page hierarchy to find the top level page
		while($parent_post->post_parent) { $parent_post = get_post($parent_post->post_parent); }
		
		// "climb" back down to get the children
		$parent_post->children = sp_get_all_children($parent_post);
		
		// return an array of all the pages
		return $parent_post;
	}
	
	// checks to see if the current user is super admin
	function sp_is_admin() {
		global $current_user;
		return in_array('administrator', $current_user->roles);
	}

	// checks where a user is logged in via cookie (is_user_logged_in() seemed to be unreliable)
	function sp_is_user_logged_in() {
		return wp_validate_auth_cookie('', apply_filters('auth_redirect_scheme', ''));
	}

	//checks if the user is superadmin OR webadmin
	function sp_is_site_admin($user = null){
		global $current_user;

		if( ! empty($current_user->roles) &&
		( in_array( 'administrator', $current_user->roles )
		|| in_array( 'web_administrator', $current_user->roles )
		|| ( ! defined( 'DOING_AJAX' ) && ! 'DOING_AJAX') ) ){
			return true;
		}else{
			return false;
		}
	}
	
	// uses wordpress' paginate_links function with some default variables
	function sp_paginate_links($args = array()) {
		global $wp_query;
		
		$args = wp_parse_args($args, array('total'=>$wp_query->max_num_pages));
		
		$pages = paginate_links(array(
			'base' => preg_replace('/page\/\d*\/$/', '', $_SERVER['REQUEST_URI']).'page/%#%/',
			'current' => max(1, get_query_var('paged')),
			'format' => 'page/%#%/',
			'mid_size' => 1,
			'next_text' => '&raquo;',
			'prev_text' => '&laquo;',
			'total' => $args['total'],
			'type' => 'array'
		));

		if(is_array($pages)) {
			$paged = get_query_var('paged') == 0 ? 1 : get_query_var('paged');
			$r = '<ul class="pagination">';
			foreach($pages as $page) {
				$r.= '<li'.(preg_match('/current/', $page) ? ' class="active"' : '').'>'.$page.'</li>';
			}
			$r.= '</ul>';
		}

		return $r;
	}
	
	// filters any passed string through the_content wordpress filter (will process any shortcodes, etc...)
	function sp_the_content($input) {
		return apply_filters('the_content', $input);
	}
	
	// get relative url of specified file, relative to the theme folder
	function sp_theme_relative($file) { return sp_filter_http(sp_theme_full($file)); }

	// get absolute url of specified file, relative to the theme folder
	function sp_theme_full($file) { return get_stylesheet_directory_uri().'/'.$file; }

	// function to get time relative to timezone set in admin
	function sp_time() { return current_time('timestamp'); }
	
	// function to get datetime relative to timezone set in admin
	function sp_datetime() { return current_time('mysql'); }
	
	// get image url, of specified size, by id, image array or image object
	function sp_get_image($id, $size='full') {
		$url = '';
		if(is_numeric($id)) {
			$image = wp_get_attachment_image_src($id, $size);
			if(is_array($image) && (count($image) > 0)) {
				$url = sp_filter_http($image[0]);
			}
		} else if(is_array($id) || is_object($id)) {
			$info = (array)$id;
			if(($size == 'full') && !empty($info['url'])) {
				$url = sp_filter_http($info['url']);
			} else if(isset($info['sizes']) && is_array($info['sizes']) && !empty($info['sizes'][$size])) {
				$url = sp_filter_http($info['sizes'][$size]);
			}
		}
		return $url;
	}

	// get url of post id
	function sp_get_link($id) {
		return sp_filter_http(get_permalink($id));
	}
	
	// format the phone numbers to be uniform through the site
	function sp_format_phone($phone, $extension = '', $formats = array()) {
		$formats = wp_parse_args($formats, array('format-7'=>'$1-$2',
															  'format-10'=>"($1) $2-$3",
															  'format-11'=>"$1 ($2) $3-$4"));
		$phone = preg_replace('/[^0-9]/','',$phone);
		$len = strlen($phone);
		if($len == 7) {
			$phone = preg_replace("/([0-9]{3})([0-9]{4})/", $formats['format-7'], $phone);
		} else if($len == 10) {
			$phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", $formats['format-10'], $phone);
		} else if($len == 11) {
			$phone = preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", $formats['format-11'], $phone);
		}
		return $phone.($extension ? ' ext. '.$extension : '');
	}
	
	// register a custom post type: ex: sp_register_cpt(array('name' => 'FAQ', 'icon' => 'dashicons-format-status', 'position' => 5, 'is_singular' => true));
	function sp_register_cpt($cpt_array = array()){
		$default_cpt = array( 'name' => '', 
							'icon' => 'dashicons-admin-post', 
							'position' => 4, 
							'description' => '', 
							'is_singular' => false, 
							'exclude_from_search' => false,
							'supports' => array('title','editor','thumbnail','page-attributes'),
							'taxonomies' => array(),
							'has_archive' => false,
							'rewrite' => array(),
							'public' => true,
							'hierarchical' => false
						);	
		if(! empty($cpt_array)){
			$cpt_array = wp_parse_args( $cpt_array, $default_cpt );
			$slug = strtolower($cpt_array['name']);
			$plural = (substr($slug, -1) == 's') ? 'es' : 's';
			
			if(substr($slug, -1) == 'y' && ! $cpt_array['is_singular']){
				$slug = rtrim($slug, 'y');
				$plural = 'ies';
			}
			
			$plural_slug = ($cpt_array['is_singular']) ? $slug : $slug.$plural;
			$plural_slug = str_replace(" ", "-", $plural_slug);
			$label = ucwords(str_replace("-", " ", $cpt_array['name']));

			$is_y = false;
			if(substr($label, -1) == 'y' && ! $cpt_array['is_singular']){
				$label = rtrim($label, 'y');
				$is_y = true;
			}

			$plural_label = ($cpt_array['is_singular']) ? $label : $label.$plural;
			
			//we removed the y from the label to put on an ies...now let's add the Y back.
			if($is_y){
				$label .= 'y';
			}
			
			register_post_type( $plural_slug, array(
								'label' => $plural_label,
								'description' => $cpt_array['description'],
								'public' => $cpt_array['public'],
								'show_ui' => true,
								'show_in_menu' => true,
								'exclude_from_search' => $cpt_array['exclude_from_search'],
								'capability_type' => 'post',
								'map_meta_cap' => true,
								'hierarchical' => $cpt_array['hierarchical'],
								'has_archive' => $cpt_array['has_archive'],
								'rewrite' => $cpt_array['rewrite'],
								'query_var' => true,
								'taxonomies' => $cpt_array['taxonomies'],
								'menu_position' => $cpt_array['position'],
								'menu_icon' => $cpt_array['icon'],
								'supports' => $cpt_array['supports'],
								'labels' => array (
									'name' => $plural_label,
									'singular_name' => $label,
									'menu_name' => $plural_label,
									'add_new' => 'Add '.$label,
									'add_new_item' => 'Add New '.$label,
									'edit' => 'Edit',
									'edit_item' => 'Edit '.$label,
									'new_item' => 'New '.$label,
									'view' => 'View '.$plural_label,
									'view_item' => 'View '.$label,
									'search_items' => 'Search '.$plural_label,
									'not_found' => 'No '.$plural_label.' Found',
									'not_found_in_trash' => 'No '.$plural_label.' Found in Trash',
									'parent' => 'Parent '.$label
								)
							)); 
		}
	}

	/**
	 * Helper function for registering a taxonomy
	 *
	 * @param string $tax_name  	A url safe taxonomy name / slug
	 * @param string $post_type 	What post type this taxonomy will be applied to
	 * @param string $menu_title 	The title of the taxonomy. Human Readable.
	 * @param array  $rewrite 	 	Overwrite the rewrite
	 */
	function sp_register_taxonomy($tax_name = '', $post_type = '', $menu_title = '', $public = true, $rewrite = array()){

		if(empty($rewrite)){
			$rewrite = array( 'slug' => $tax_name );
		}

		register_taxonomy(
			$tax_name,
			$post_type,
			array(
				'label' => __( $menu_title ),
				'rewrite' => $rewrite, 
				'capabilities' => array(
					'manage_terms' => 'manage_categories',
					'assign_terms' => 'manage_categories',
					'edit_terms' => 'manage_categories',
					'delete_terms' => 'manage_categories'
				),
				'hierarchical' => true,
				'publicly_queryable' => $public
			)
		);
	}
	
	// get a pk-specific value
	function sp_get($key) {
		return sp_value($key);
	}
	
	// set a pk-specific value -- returns previous value
	function sp_set($key, $value=null) {
		return sp_value($key, $value);
	}
	
	// get/set a pk-specific value
	function sp_value() {
		static $list = array();
		
		// initialize value
		$value = null;
		
		// 1 argument = get, 2 arguments = set, anything else = invalid
		switch(func_num_args()) {
		
			// get value
			case 1:
				$key = func_get_arg(0);
				if(is_string($key)) {
					$value = (isset($list[$key]) ? $list[$key] : null);
				}
				break;
				
			// set value (and return old value)
			case 2:
				$key = func_get_arg(0);
				if(is_string($key)) {
					$value = (isset($list[$key]) ? $list[$key] : null);
					$list[$key] = func_get_arg(1);
				}
				break;
			
			// invalid usage
			default:
				break;
		}
		
		// return current/previous value
		return $value;
	}
	
	// remove callbacks from specified action/filter, with optional function name and priority
	function sp_unhook($name, $func=null, $pri=null) {
		global $wp_filter;
	
		// check for callbacks assigned to a specific filter name
		if(empty($name) || !is_array($wp_filter) || empty($wp_filter[$name])) {
			return;
		}
	
		// check for function name and priority
		if(($func === null) && ($pri === null)) {
			return remove_all_actions($name);
		}
	
		// reference the specified filter list
		$filters = &$wp_filter[$name];
	
		// initialize callback removal list
		$list = array();
	
		// search callbacks within a priority
		if($pri !== null) {
			if(!empty($filters[$pri])) {
		
				// with specific function name
				if($func !== null) {
					if(isset($filters[$pri][$func])) {
						$list[] = array($name, $func, $pri);
					}
			
				// without specific function name
				} else {
					foreach($filters[$pri] as $call=>$item) {
						$list[] = array($name, $call, $pri);
					}
				}
			}
		
		// search all callback priorities
		} else {
			foreach($filters as $pri=>$group) {
				if(isset($group[$func])) {
					$list[] = array($name, $func, $pri);
				}
			}
		}
	
		// remove identified callbacks
		if(!empty($list)) {
			foreach($list as $item) {
				remove_action($item[0], $item[1], $item[2]);
			}
		}
	}

	//Output Bootstrap grid clearfixes for varying heights on grid items
	//that are not sectioned off with rows
	/* Usage: sp_brkpnt(($c+1),array('xs'=>2,'sm'=>2,'md'=>3,'lg'=>3));
	*  $c is the current count key in a foreach
	*  $breakpoints are a key => value pair array for all of the grid sizes (xs,sm,md,lg)
	*  $echo is whether or not to echo or return the result
	*/
	function sp_brkpnt($c,$breakpoints, $echo = true){
		if(!is_array($breakpoints)){ return; }
		$class = '';
		foreach($breakpoints as $prefix => $size){
			$class .= $c%$size == 0 ? ' visible-'.$prefix: ''; 
		}
		$return = $class ? '<div class="clearfix'.' '.$class.'"></div>' : '';
		if($echo){ echo $return; }else{ return $return; }
	}

	/*
	* Change "posts" name to "Blog Posts"
	*/
	add_action( 'admin_menu', 'sp_change_post_label', 10, 0 );
	function sp_change_post_label() {
		$new = apply_filters( 'sp_change_post_label', false);
		$plural = apply_filters( 'sp_post_label_plural', true);
		if(!$new){ return; }

	   global $menu;
	   global $submenu;
	   $menu[5][0] = $new.($plural?'s':'');
	   $submenu['edit.php'][5][0] = $new.($plural?'s':'');
	   $submenu['edit.php'][10][0] = 'Add '.$new;
	}

	/**
	 * Use WordPress' antispambot() to obfuscate the site's email, to protect from harvestor bots
	 *
	 * @param string $email The email address to obfuscate
	 * @param string $text 	The text to display to the user (for the mailto:email link)
	 * 
	 * @return string 		The obfuscated email address formatted as a link.
	 */
	function sp_antispam_email($email = "", $text = "" ){
		if (! filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			if($text == ""){
				$text = antispambot($email);
			}
			$clean_link = '<a href="mailto:'.antispambot($email).'">'.$text.'</a>';
			
			return	$clean_link;
			
		}
	}

	/**
	 * Get the img path quickly
	 * 
	 * @param string $img_name optional image name to append to the path
	 * @param string $echo whether or not to echo the results
	 * @return string the images directory or echo out
	 */
	function sp_img_path($img_name=false,$echo=false) {
		$path = get_stylesheet_directory_uri().'/images/';
	   $path .= $img_name ? $img_name : '';
	   if($echo){
	      echo $path;
	   }else{
	      return $path;
	   } 
	}

	/**
	 * Return the Video ID of a video based on the video URL
	 * @param  string $url the url of the YouTube video
	 * @return string      the video id
	 */
	function sp_get_youtube_id($url){
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
		    return $match[1];
		}

		return '';
	}

	//Allows a user to setup WordPress for HTML emails
	function set_html_content_type() {
		return 'text/html';
	}

	/**
	 * Detect if the provided url belongs to the same domain as our site OR if it is a PDF
	 */
	function sp_target_domain($url){
		if(strpos($url, get_home_url()) !== false && strpos($url, ".pdf") === false){
			return "";
		}else{
			return 'target="_blank" rel="noopener"';
		}
	}

	/**
	 * Pass in the PK button array
	 * @param  array $arr array containing all the PK button fields
	 * @return string      the correct URL for this type of button
	 */
	function sp_get_button_link($arr, $prefix = ''){

		$btn_link = '#';

		switch($arr[$prefix.'link_type']){
			case 'existing':

				$btn_link = !empty($arr[$prefix.'existing_link']) ? $arr[$prefix.'existing_link']->ID : false;
				$btn_link = $btn_link ? get_permalink($btn_link) : false;
				break;

			case 'manual':
				$btn_link = $arr[$prefix.'manual_url'];
				break;

			case 'file':
				$f = $arr[$prefix.'file'];
				$btn_link = $f ? $f['url'] : false;
				break;
		}

		return $btn_link;

	}

	/**
	 * Display a PK button
	 * 
	 * @param array $button an array of the needed button values (sp_Button)
	 * @param string $classes Any classes you want to apply to the link
	 * @param bool $echo Should we echo this button or return it?
	 */
	function sp_display_sp_button($button, $classes = '', $echo = true){

		if($button['link_type'] != 'none' && ! empty($button['button_text'])){
			$btn_link = sp_get_button_link($button);
			$btn_html = '<a href="'.$btn_link.'" '.sp_target_domain($btn_link).' class="'.$classes.'">'.$button['button_text'].'</a>';

			if($echo){
				echo $btn_html;
			}else{
				return $btn_html;
			}
		}
	}

	/**
	 * Return a URL to Google Maps with the appropriate query string to a given location
	 *
	 * @param array $address 	the address of the location array('street_address' => '', 'city' => '', 'state' => '', 'zip' => '' )
	 * 
	 * @return string 			the google maps query string 	
	 */
	function sp_get_map_link($address,$query_only = false){

		$q = urlencode(preg_replace('/\(.*\)/', '', $address['street_address'].', '.$address['city'].', '.$address['state'].' '.$address['zip']));

		return $query_only ? $q : 'https://maps.google.com/?q='.$q;
	}

	/**
	 * Allow a user to add a button to a Wysiwyg
	 */
	add_shortcode( 'pkButton', 'sp_add_a_button' );
	function sp_add_a_button( $atts ) {

		return '<a href="'.$atts['link'].'" class="btn btn-primary" '.sp_target_domain($atts['link']).'  >'.$atts['title'].'</a>';
	}

	//Check if an array has a key and return its value if so
	function pkav($arr,$val){
	   return isset($arr[$val]) ? $arr[$val] : false;
	}

	// Get the featured image for a post
	function sp_get_featured_image($id = false, $size = 'full',$returnid = false){
		if(!$id){ $id = get_the_id(); }
		$image_id = get_post_thumbnail_id($id);
		if(!$image_id){ return false; }
		$info = sp_get_attachment_info($image_id);
		$srcset = wp_get_attachment_image_srcset($image_id,$size);
		$sized = wp_get_attachment_image_src($image_id,$size,true);
		$info['original_src'] = $info['src'];
		$info['src'] = $sized[0];
		$info['srcset'] = $srcset;
		if($returnid){
			return $info;
		}else{
			return $sized[0];
		}
	}

	function sp_get_attachment_info( $attachment_id ) {
		$attachment = get_post( $attachment_id );
		return array(
			'image_id' => $attachment_id,
			'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href' => get_permalink( $attachment->ID ),
			'src' => wp_get_attachment_url($attachment_id),
			'title' => $attachment->post_title
		);
	}

	//Custom ajax spinner for gravity forms when submitting
	add_filter( "gform_ajax_spinner_url", "sp_custom_spinner_image", 10, 2);
	function sp_custom_spinner_image($image_src, $form){
			return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
	}


	//Get a custom excerpt length from an optional field or except
	function sp_get_excerpt($excerpt_length = 55, $id = false, $field = null, $more='...') {
	     
	 $text = '';
	   
	   if($id && $field){
	      $text = get_the_field($field,$id);
	   }elseif($id) {
	      $the_post = & get_post( $my_id = $id );
	      $text = ($the_post->post_excerpt) ? $the_post->post_excerpt : $the_post->post_content;
	   }else{
	      global $post;
	      $text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
	   }

	   $text = sp_do_excerpt($text,$excerpt_length,$more);
	   return $text;
	}

	//format an excerpt
	function sp_do_excerpt($text, $excerpt_length = 55, $more='...'){
	   $text = strip_shortcodes( $text );
	   $text = apply_filters('the_content', $text);
	   $text = str_replace(']]>', ']]&gt;', $text);
	   $text = strip_tags($text);
	   $excerpt_more = $more;
	   $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	   if ( count($words) > $excerpt_length ) {
	      array_pop($words);
	      $text = implode(' ', $words);
	      $text = $text . $excerpt_more;
	   } else {
	      $text = implode(' ', $words);
	   }
	   return $text;
	}

	function sp_get_url_without_params($url = false){
	   if(!$url){ $url = $_SERVER['REQUEST_URI']; }
	   preg_match('/^[^\?]+/', $url, $return);
	   $url = 'http' . ('on' === $_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $return[0];
	   return $url;
	}

	//get pagination from an optional wp_query with first and last links
	function sp_get_pagination($custom_query = false, $format="?paged=%#%") {
	   global $wp_query;
	   $query = $custom_query ? $custom_query : $wp_query;

	   $big = 999999999; // need an unlikely integer
	   $pages = paginate_links( array(
	      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	      'format' => $format,
	      'current' => max( 1, get_query_var('paged') ),
	      'total' => $query->max_num_pages,
	      'prev_next' => false,
	      'type'  => 'array',
	      'prev_next'   => true,
	      'show_all' => false,
	      'end_size' => 0,
	      'mid_size' => 4,
	      'prev_text'    => __('&#139;'),
	      'next_text'    => __('&#155;'),
	   ) );

	   //Get first and last links
	   $query_string = $_SERVER['QUERY_STRING'];
	   $first = preg_replace('/\/page\/([]0-9]+)/','',sp_get_url_without_params($_SERVER['REQUEST_URI']));
	   $first_link = $first.($query_string ? '?'.$query_string:'');
	   
	   $last = preg_replace('/\/page\/([]0-9]+)/','/page/'.$query->max_num_pages,sp_get_url_without_params($_SERVER['REQUEST_URI']));
	   $last_link = $last.($query_string ? '?'.$query_string:'');

	   if( is_array( $pages ) ) {
	      echo '<div class="pagination-wrap">';
	      $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	      echo '<ul class="pagination">';
	      //echo '<li><a class="first page-numbers" href="'.$first_link.'">&laquo;</a></li>';
	      foreach ( $pages as $page ) {
	              echo "<li>$page</li>";
	      }
	      //echo '<li><a class="last page-numbers" href="'.$last_link.'">&raquo;</a></li>';
	      echo '</ul>';
	      echo '</div>';
	   }
	}

	//Get a specific image url from an acf image object, fallback to full url
	function sp_get_acf_image($img,$size='full'){
	   if(isset($img['sizes'][$size])){
	      return $img['sizes'][$size];
	   }elseif(isset($img['url'])){
	      return $img['url'];
	   }else{
	      return false;
	   }
	}

	//Manual list of public post types, useful for common search results page
	function sp_get_public_post_types(){
	   $arr = array(
	      'post' => 'Blog',
	      'page' => 'Page',
	   );
	   return $arr;
	}

	/* Custom Youtube lightbox CTA functions */
	function sp_get_youtube_title($video_id){
	   $info = file_get_contents("https://www.youtube.com/get_video_info?video_id=".$video_id);
	   preg_match("/&title=(.+?)&/", $info, $title);
	   return isset($title[1]) ? urldecode($title[1]) : false;
	}

	function sp_get_file_size($url){
	   $ch = curl_init(); 
	   curl_setopt($ch, CURLOPT_HEADER, true); 
	   curl_setopt($ch, CURLOPT_NOBODY, true); // make it a HEAD request
	   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
	   curl_setopt($ch, CURLOPT_URL, $url); 
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	   $head = curl_exec($ch);

	   $mimeType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	   $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
	   $path = parse_url($url, PHP_URL_PATH);
	   $filename = substr($path, strrpos($path, '/') + 1);

	   curl_close($ch); 
	   return $size;
	}

	function sp_get_youtube_params($url,$key=false){
		$params = array();

		//Video ID
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $video_parts);
		if(isset($video_parts[1])){
			$params['id'] = $video_parts[1];
		}else{
			$params['id'] = $url;
		}

		//Playlist
		preg_match("/list=(.*)&?\/?/", $url, $video_parts);
		if(isset($video_parts[1])){
			$params['list'] = $video_parts[1];
		}

		return $key && isset($params[$key]) ? $params[$key] : $params;
	}

	function sp_get_youtube_img($video_id,$size='hqdefault'){
	   $sizes = array('maxresdefault','sddefault','hqdefault','mqdefault','default');
	   $img = 'https://img.youtube.com/vi/'.$video_id.'/'.$size.'.jpg';
	   $img_size = sp_get_file_size($img);
	   //If this is the youtube default image ( it is usually 1097 bytes ), loop through the sizes and try to find one that actual works.
	   if($img_size < 1500){
	      foreach($sizes as $s){
	            $size = $s;
	            $img = 'http://img.youtube.com/vi/'.$video_id.'/'.$s.'.jpg';
	            $img_size = sp_get_file_size($img);
	            if($img_size >= 1500){ break; }
	      }
	   }
	   return $img;
	}

	//Output a youtube video looking image with a play button that opens in a lightbox
	/*
	* default = 120x90
	* mqdefault = 320x180
	* hqdefault / 0 = 480x360  -45m
	* sddefault = 640x480   -60m
	* maxresdefault = 1280x720
	* https://www.youtube.com/watch?v=EAcdvmnZ_GM
	*/
	function sp_youtube_lightbox($url,$args=array()){
	   $default = array(
	      'show_title' => true,
	      'classes' => false,
	      'size' => 'hqdefault',
	      'font_awesome' => false,
	      'overlay' => false,
	      'echo' => true,
	      'secondary_title' => '',
	      'background' => false,
	      'gradient' => true,
	      'rel' => false,
	      'img' => false
	   );

	   $args = wp_parse_args( $args, $default );
	   extract($args);

	   $params = sp_get_youtube_params($url);
	   $video_id = $params['id'];
	   $title = sp_get_youtube_title($video_id);
	   $title = $title && $show_title ? $title : '';
	   $img = $img ? $img : sp_get_youtube_img($video_id,$size);
	   $classes = trim('background '.$classes);
	   $classes = $classes ? $size.' '.$classes : $size;
	   $base_url = 'https://www.youtube.com/watch?v=';
	   $end_url = $rel ? '' : '&rel=0';
	   $return = '
	   <div class="video-wrap '.$classes.'">
	      <a data-lity href="'.$base_url.$video_id.$end_url.'" class="video relative bgimage"'.($background ? ' style="background-image:url('.$img.')"':'').'>';
	   $return .= $overlay ? '<div class="overlay absolute half"></div>' : '';
	   $return .= !$background ? '<img class="bg" src="'.$img.'" />' : '';
	   $return .= $gradient ? '<div class="ytp-gradient-top"></div>':'';

	   //If we want to set the middle content compeltely custom
	   if($content){
	      $return .= $content;
	   }else{
	      $return .=      '<div class="title">'.$title.'</div>
	            <button class="yt-play" arial-label="">';
	      $return.= $font_awesome ? '<span class="fa '.$font_awesome.'"></span>' : '
	               <svg width="100%" viewBox="0 0 68 48" version="1.1" height="100%"><path fill-opacity="0.81" fill="#1f1f1e" d="m .66,37.62 c 0,0 .66,4.70 2.70,6.77 2.58,2.71 5.98,2.63 7.49,2.91 5.43,.52 23.10,.68 23.12,.68 .00,-1.3e-5 14.29,-0.02 23.81,-0.71 1.32,-0.15 4.22,-0.17 6.81,-2.89 2.03,-2.07 2.70,-6.77 2.70,-6.77 0,0 .67,-5.52 .67,-11.04 l 0,-5.17 c 0,-5.52 -0.67,-11.04 -0.67,-11.04 0,0 -0.66,-4.70 -2.70,-6.77 C 62.03,.86 59.13,.84 57.80,.69 48.28,0 34.00,0 34.00,0 33.97,0 19.69,0 10.18,.69 8.85,.84 5.95,.86 3.36,3.58 1.32,5.65 .66,10.35 .66,10.35 c 0,0 -0.55,4.50 -0.66,9.45 l 0,8.36 c .10,4.94 .66,9.45 .66,9.45 z" class="ytp-large-play-button-bg"/><path fill="#fff" d="m 26.96,13.67 18.37,9.62 -18.37,9.55 -0.00,-19.17 z"/><path fill="#ccc" d="M 45.02,23.46 45.32,23.28 26.96,13.67 43.32,24.34 45.02,23.46 z"/></svg>';
	      $return.= '</button>';
	      $return.= $secondary_title ? '<h5>'.$secondary_title.'</h5>' : '';
	   }
	   $return.= '</a>
	   </div>';

	   if($echo){
	      echo $return;
	   }else{
	      return $return;
	   }
	}

	//Attempt to retrieve and format button info from the pk button acf field group
	function sp_get_button_info($arr,$full=false){
      $btn_link = false;
      $target = $arr['target'];
      $txt = $arr['button_text'];

      switch($arr['link_type']){
         case 'existing':
            $btn_link = !empty($arr['existing_link']) ? $arr['existing_link']->ID : false;
            $btn_link = $btn_link ? get_permalink($btn_link) : false;
            break;
         case 'manual':
            $btn_link = $arr['manual_url'];
            break;
         case 'file':
            $f = $arr['file'];
            $btn_link = $f ? $f['url'] : false;
            break;
      }

      return $full ? array('link'=>$btn_link,'target'=>$target,'txt'=>$txt) : $btn_link;
   }

   //Output a button either with manual info or from the pk button acf field group
   function sp_output_button($btn,$classes=false,$properties=array()){
      //Convert to pk button if needed
      if(empty($btn['link'])){ $btn = sp_get_button_info($btn,true); }

      $link = !empty($btn['link']) ? $btn['link'] : false;
      if(!$link){ return; }
      $props = '';
      if(!empty($properties)){
         foreach($properties as $key => $val){
            $props .= ' '.$key.'="'.$val.'"';
         }
      }
      $classes = $classes ? $classes : 'btn-primary';
      $target = !empty($btn['target']) ? $btn['target'] : "_self";
      $txt = !empty($btn['txt']) ? $btn['txt'] : $link;
      $html = '<a href="'.$link.'" target="'.$target.'" class="btn '.$classes.'" aria-label="'.$txt.'"'.$props.'>'.$txt.'</a>';
      echo $html;
   }

   /*
	*  Check for ACF and set global fields
	*  Call this at the top of any template or part you need
	*  and it will only make the DB calls once and set them as a global
	*  for each subsequent call
	*/
	function sp_get_fields(){
	   $fields = sp_get('fields');
	   return $fields ? $fields : sp_set_fields(get_the_ID());
	}
	function sp_set_fields($id=false,$set=true){
	   $id = $id ? $id : get_the_ID();
	   if(!$id){ return array(); }
	   if(!function_exists('get_fields')){ return false; }
	   $fields = get_fields($id);
	   if($set){ sp_set('fields',$fields); }
	   return $fields;
	}

	//Dev function to exponentially duplicate array values
	function sp_arr_increase($arr,$num=4){
	   for($i=0;$i<$num;$i++){
	      $arr = array_merge($arr,$arr);
	   }
	   return $arr;
	}

	//Output an image / background image with optional params
	function sp_image($src=false,$args=array()){
	   if(!$src){ return; }

	   if(is_array($src)){
	      $temp = $src;
	      $size = !empty($args['size']) ? $args['size'] : 'medium_large';
	      $src = sp_get_acf_image($src,$size);
	      if(!$src){ return; }
	      if(empty($args['alt'])){ $args['alt'] = $temp['alt']; }
	   }

	   $default = array( 'lazy' => true, 'classes' => '', 'alt' => '', 'fallback' => 'Image', 'echo' => true, 'div'=>false, 'size'=>'medium_large', 'container'=>false, 'srcset'=>false);
	   $args = wp_parse_args( $args, $default );
	   extract($args);

	   $classes = $lazy ? $classes.' lazy' : $classes; //Add lazy load class

	   $html = $container ? '<'.$container.'>' : '';
	   $html .= $div ? '<div role="img" ' : '<img ';
	   $html .= ($lazy?'data-':'').'src="'.$src.'" '.($div?'arial-label':'alt').'="'.($alt?$alt:$fallback).'" class="'.$classes.'"'.($srcset?' '.($lazy?'data-':'').'srcset="'.$srcset.'"':'');
	   $html .= $div ? '></div>' : ' />';
	   $html .= $container ? '</'.$container.'>' : '';

	   if($echo){ echo $html; }else{ return $html; }
	}

	//Get the labels for a post type
	function sp_get_cpt_labels($single,$plural){
	   $arr = array(
	      'name' => $plural,
	      'singular_name' => $single,
	      'menu_name' => $plural,
	      'add_new' => 'Add '.$single,
	      'add_new_item' => 'Add New '.$single,
	      'edit' => 'Edit',
	      'edit_item' => 'Edit '.$single,
	      'new_item' => 'New '.$single,
	      'view' => 'View '.$plural,
	      'view_item' => 'View '.$single,
	      'search_items' => 'Search '.$plural,
	      'not_found' => 'No '.$plural.' Found',
	      'not_found_in_trash' => 'No '.$plural.' Found in Trash',
	      'parent' => 'Parent '.$single
	   );
	   return $arr;
	}

	//Get the labels for a taxonomy
	function sp_get_tax_labels($singular,$plural){
	   $arr = array(
	      'name'                       => $singular,
	      'singular_name'              => $singular,
	      'search_items'               => 'Search '.$plural,
	      'popular_items'              => 'Popular '.$plural,
	      'all_items'                  => 'All '.$plural,
	      'parent_item'                => 'Parent '.$singular,
	      'parent_item_colon'          => 'Parent '.$singular.':',
	      'edit_item'                  => 'Edit '.$singular,
	      'update_item'                => 'Update '.$singular,
	      'add_new_item'               => 'Add New '.$singular,
	      'new_item_name'              => 'New '.$singular.' Name',
	      'separate_items_with_commas' => 'Separate '.$plural.' with commas',
	      'add_or_remove_items'        => 'Add or remove '.$plural,
	      'choose_from_most_used'      => 'Choose from the most used '.$plural,
	      'not_found'                  => 'No '.$plural.' found.',
	      'menu_name'                  => $plural,
	   );
	   return $arr;
	}