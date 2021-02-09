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


// prints out an array with <pre> tags
function jb_print($input, $force = false) { 
	if(ENVIRONMENT != 'live' || $force === true){
		echo '<pre class="pk-print">'.print_r($input, true).'</pre>'; 
	}
}

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

add_action('add_meta_boxes', 'wpse_add_custom_meta_box_2');
//making the meta box (Note: meta box != custom meta field)
function wpse_add_custom_meta_box_2() {
	add_meta_box(
		'channel-videos',       // $id
		'Videos',                  // $title
		'jb_show_channel_videos',  // $callback
		'channels',                 // $page
		'normal',                  // $context
		'low'                     // $priority
	);
 }

//showing custom form fields
function jb_show_channel_videos() {
    global $post;

	$channel_videos = json_decode(get_post_meta($post->ID,'cached_video_list', true));

	foreach($channel_videos as $vkey => $video){
		if(empty($video->video_id)) continue;

		jb_print($video);
	}

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
 * On Channel Save find videos and normalize
 *
 * @return object
 */
add_action( 'save_post_channels', 'jb_set_yt_channel_info', 100, 3 );
function jb_set_yt_channel_info($post_id, $post, $update){

	// Get this channel's image and most recent videos from YouTube
	jb_set_channel_videos($post_id);
	jb_set_channel_thumbnail($post_id);

	// Add these channels to the normalized database
	jb_add_normalized_channel($post, true);
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
		$yt_id = get_field('yt_api_key', 'option');

		$done = false;
		$max_videos = 20;
		$safety = 6;
		$videos = array();
		$channel_obj = null;

		$count = 0;
		while(! $done){
			$count++;

			$url = 'https://www.googleapis.com/youtube/v3/search?key='.$yt_id.'&channelId='.$channel_id.'&part=snippet&order=date&maxResults=20';

			if($channel_obj && ! empty($channel_obj->nextPageToken)){
				$url .= '&pageToken='.$channel_obj->nextPageToken;
			}

			$result = file_get_contents($url);

			if($result){

				$channel_obj = json_decode( $result );

				$videos = jb_channel_items_to_videos($channel_obj->items);

				if(count($videos) >= $max_videos
				|| $count > $safety){
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

	$yt_id = get_field('yt_api_key', 'option');

	if(! has_post_thumbnail( $post_id ) ){
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
	}

	return '';
}


/**
 * Get the image for this channel about this channel
 * TODO: We really only need the image so possibly just take image and convert it to featured image? It is only the logos which are 88px so shouldn't take up too much space.
 * @param int $channel_post_id
 * @return void
 */
function jb_get_yt_channel_img($channel_post_id){
	$channel_img = get_the_post_thumbnail_url( $channel_post_id, 'thumbnail' );
	// get_post_meta($channel_post_id,'cached_channel_image', true);

	if(! empty($channel_img)) {
		return $channel_img;
	}

	return jb_set_channel_thumbnail($channel_post_id);

}


/**
 * Add a channel to our normalized channel table for easier searching
 *
 * @param object $channel The $post object for the channel in question
 * @param boolean $videos Do you also want to normalize this channels videos?
 * @return void
 */
function jb_add_normalized_channel($channel, $videos = false){
	global $wpdb;

	$channel_table = 'jb_channels';

	$c_fields = get_fields($channel->ID);
	$channel_img = jb_get_yt_channel_img($channel->ID);
	$channel_videos = jb_get_yt_channel_videos($c_fields['channel_id'], $channel->ID);

	$wpdb->insert(
		$channel_table,
		array(
			'youtube_id' => $c_fields['channel_id'],
			'title' => $channel->post_title,
			'description' => $channel->post_content,
			'img_url' => $channel_img,
			'facebook' => $c_fields['facebook'],
			'instagram' => $c_fields['instagram'],
			'patreon' => $c_fields['patreon'],
			'tiktok' => $c_fields['tiktok'],
			'twitter' => $c_fields['twitter'],
			'twitch' => $c_fields['twitch'],
			'website' => $c_fields['website'],
			//'tags' => '',
		)
	);

	if($wpdb->insert_id === 0){
		$wpdb->update(
			$channel_table,
			array(
				'title' => $channel->post_title,
				'description' => $channel->post_content,
				'img_url' => $channel_img,
				'facebook' => $c_fields['facebook'],
				'instagram' => $c_fields['instagram'],
				'patreon' => $c_fields['patreon'],
				'tiktok' => $c_fields['tiktok'],
				'twitter' => $c_fields['twitter'],
				'twitch' => $c_fields['twitch'],
				'website' => $c_fields['website'],
				//'tags' => '',
			),
			array(
				'youtube_id' => $c_fields['channel_id'],
			)
		);
	}else if($wpdb->insert_id === false){
		// Error
	}

	// Also normalize this channel's videos
	if($videos){
		$channel_id = $wpdb->get_var(
			$wpdb->prepare("SELECT channel_id FROM {$channel_table} WHERE youtube_id = %s", $c_fields['channel_id'])
		);

		if(! empty($channel_videos) && ! empty($channel_id)){
			foreach($channel_videos as $video){
				jb_add_normalized_video($video, $channel_id);
			}
		}
	}

}


/**
 * Add a video to our normalized tables for easier searching from front end
 *
 * @param object $video The video object from the cached_video_list meta_data
 * @param int $channel_id The channel_id of the normalized channel related to this video
 * @return void
 */
function jb_add_normalized_video($video, $channel_id){
	global $wpdb;

	if(empty($video->video_id)) return;

	$video_table = 'jb_videos';

	// This query works but the insert above does not. Weird
	$wpdb->query(
		$wpdb->prepare("INSERT INTO {$video_table} (`youtube_id`, `channel_id`, `title`, `tags`, `description`, `date`) 
						VALUES (%s, %d, %s, %s)
						ON DUPLICATE KEY UPDATE
						`youtube_id` = %s, 
						`channel_id` = %d,
						`title` = %s,
						`tags` = %s,
						`description` = %s,
						`date` = %s", 
						$video->video_id, 
						$channel_id, 
						$video->title, 
						$video->tags, 
						$video->description, 
						date('Y-m-d', strtotime($video->date)), 
						$video->video_id, 
						$channel_id,
						$video->title, 
						$video->tags, 
						$video->description, 
						date('Y-m-d', strtotime($video->date))
			
		)
	);

	//jb_print($wpdb->last_query);
	//jb_print($wpdb->last_error);

}


/**
 * Convert the returned channel items into video arrays for saving
 *
 * @param array $items An array of channel_obj->items returned from youtube API
 * @return array An array of videos
 */
function jb_channel_items_to_videos($items){
	
	$videos = array();

	if($items){
		foreach($items as $item){
			//jb_print($item);
			$videos[] = array(
				'video_id' => $item->id->videoId,
				'title' => $item->snippet->title,
				'description' => sanitize_text_field(addslashes($item->snippet->description)),
				//'tags' => '#'.implode(',#',$item->snippet->tags).',',
				'date' => date('F j, Y', strtotime($item->snippet->publishTime)),
			);
		}
	}

	return $videos;
}