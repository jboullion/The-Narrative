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

}

add_action('init', 'jb_register_cpts');
function jb_register_cpts() {

	jb_register_cpt(array('name' => 'channel', 'icon' => 'dashicons-format-video', 'position' => 30 ));
	//jb_register_cpt(array('name' => 'voice', 'icon' => 'dashicons-megaphone', 'position' => 31 ));
	
	//jb_register_cpt(array('name' => 'video', 'icon' => 'dashicons-format-video', 'position' => 30 ));

	//jb_register_taxonomy('genre', array('channels', 'voices'), 'Genre');
	jb_register_taxonomy('style', array('channels'), 'Style');
	jb_register_taxonomy('topic', array('channels'), 'Topic');

	// jb_register_taxonomy('channel', 'videos', 'Channel');
	// jb_register_taxonomy('genre', 'videos', 'Genre');
	// jb_register_taxonomy('topic', 'videos', 'Topic');

	//unregister_taxonomy_for_object_type('post_tag', 'post');
	//unregister_taxonomy_for_object_type('product_tag', 'product');
}

// register a custom post type: ex: jb_register_cpt(array('name' => 'FAQ', 'icon' => 'dashicons-format-status', 'position' => 5, 'is_singular' => true));
function jb_register_cpt($cpt_array = array()){ 
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
function jb_register_taxonomy($tax_name = '', $post_type = '', $menu_title = '', $public = true, $rewrite = array()){

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


// change where acf json files are saved
add_filter('acf/settings/save_json', 'jb_acf_save_json');
function jb_acf_save_json($path) { return get_template_directory().'/includes/acf-json'; }

// add our custom folder to places acf json are loaded from
add_filter('acf/settings/load_json', 'jb_acf_load_json');
function jb_acf_load_json($paths) { 
	return array_merge($paths, array(get_template_directory().'/includes/acf-json')); 
}

// acf options pages
if(function_exists('acf_add_options_page')) {
	acf_add_options_sub_page(array('title'=>'Website Options', 'parent'=>'themes.php', 'capability'=>'edit_theme_options'));
}



/**
 * Get the last X videos from a channel and store them for later
 *
 * @param int $post_id The post->ID of the channel in question
 * @return void
 */
function jb_set_channel_videos($post_id){
	//$channel_videos = get_post_meta($post_id,'cached_video_list', true);
	$channel_id = get_field('channel_id', $post_id);

	if(! empty($channel_id)){
		$yt_id = jb_get('yt-api-key');

		$done = false;
		$max_videos = 100;
		$safety = 6;
		$videos = array();
		$channel_obj = null;

		$count = 0;
		while(! $done){
			$count++;

			$url = 'https://www.googleapis.com/youtube/v3/search?key='.$yt_id.'&channelId='.$channel_id.'&part=snippet,id&order=date&maxResults=20';

			if($channel_obj && ! empty($channel_obj->nextPageToken)){
				$url .= '&pageToken='.$channel_obj->nextPageToken;
			}

			$result = file_get_contents($url);

			if($result){

				$channel_obj = json_decode( $result );

				$videos = jb_channel_items_to_videos($channel_obj->items);

				if(count($videos) >= $max_videos
				|| $count > $safety
				|| $result){
					$done = true;
					break;
				}
			}else{
				$done = true;
				break;
			}
		}

		// If we have a result, cache the info for 1 day
		if(! empty($videos)){
			update_post_meta( $post_id, 'cached_video_list', json_encode($videos) );
		}
	}
}



/**
 * Get this Channels thumbnail and set it
 * 
 * @param int $post_id The ID of the post to get the featured image for
 * @return string the URL of the post thumbnail
 */
function jb_set_channel_thumbnail($post_id){
	global $wpdb;

	$channel_id = get_field('channel_id', $post_id);

	if(empty($channel_id )) return;

	$yt_id = jb_get('yt-api-key');

	//if(! has_post_thumbnail( $post_id ) ){
		//https://youtube.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics&id=UCxzC4EngIsMrPmbm6Nxvb-A&key=
		$url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$channel_id.'&key='.$yt_id;

		$result = @file_get_contents($url);

		// If we have a result, cache the info for 1 month.
		if(! empty($result)){

			$channel_obj = json_decode( $result );

			//update_post_meta( $post_id, 'cached_channel', $channel_img );

			$channel_img = $channel_obj->items[0]->snippet->thumbnails->default->url;

			update_post_meta( $post_id, 'cached_channel_image', $channel_img );

			// Update the content. Using update post triggers infinite loop lol
			$wpdb->update(
				$wpdb->posts,
				array(
					'post_content' => $channel_obj->items[0]->snippet->description
				),
				array(
					'ID' =>$post_id
				)
			);

			return jb_set_featured_image_from_url($channel_img, get_the_title($post_id), $post_id);
		}
	//}

	return '';
}