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


// add_filter('acf/fields/google_map/api', 'jb_acf_google_map_api');
function jb_acf_google_map_api( $api ){
	$api['key'] = 'xxx';
	return $api;
}

// update email from address
//add_filter('wp_mail_from', function () { return ''; });
//add_filter('wp_mail_from_name', function() { return get_bloginfo('name'); });


add_action( 'init', 'jb_set_vars' );
function jb_set_vars() {
	$options = get_fields('options');
	jb_set('options', $options);
	
	// format a few address variables
	jb_set('single_line_street_address', str_replace('<br />', ' ', $options['street_address']));
	jb_set('single_line_full_address', jb_get('single_line_street_address').', '.$options['city'].', '.$options['state'].' '.$options['zip']);

	// format a few phone variables (and set a site wide phone format for consistency)
	jb_set('phone_formats', array('format-7'=>'$1-$2', 'format-10'=>"($1) $2-$3", 'format-11'=>"$1 ($2) $3-$4"));
	jb_set('phone_formatted', jb_format_phone($options['phone'], '', jb_get('phone_formats')));
	jb_set('fax_formatted', jb_format_phone($options['fax'], '', jb_get('phone_formats')));

	// enable customer login logo
	jb_set('pk-login-logo', 'images/logo.png');

	jb_set('yt-api-key', 'AIzaSyAiXvrjHqYkVxC4y1U1neEYGsTFQE2rvzY');// 'AIzaSyB2Tczkqj-yEx0_bAOZrDo6Exec7VMi970');

	// $self_study_slug_name = [
	// 	'cd-manual-package' => 'CD/Manual Package',
	// 	'downloadable-mp3-pdf' => 'Downloadable MP3+PDF',
	// 	'usb-mp3manual' => 'USB Mp3+Manual',
	// ];

}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (! jb_is_site_admin() ) {
		show_admin_bar(false);
	}
}

add_action('init', 'jb_register_cpts');
function jb_register_cpts() {

	jb_register_cpt(array('name' => 'channel', 'icon' => 'dashicons-format-video', 'position' => 30 ));
	jb_register_cpt(array('name' => 'voice', 'icon' => 'dashicons-megaphone', 'position' => 31 ));
	
	//jb_register_cpt(array('name' => 'video', 'icon' => 'dashicons-format-video', 'position' => 30 ));

	//jb_register_taxonomy('genre', array('channels', 'voices'), 'Genre');
	jb_register_taxonomy('focus', array('channels', 'voices'), 'Focus');

	// Woocommerce Taxonomies 
	// jb_register_taxonomy('channel', 'videos', 'Channel');
	// jb_register_taxonomy('genre', 'videos', 'Genre');
	// jb_register_taxonomy('topic', 'videos', 'Topic');

	//unregister_taxonomy_for_object_type('post_tag', 'post');
	//unregister_taxonomy_for_object_type('product_tag', 'product');
}

add_action( 'after_setup_theme', 'jb_set_image_sizes' );
function jb_set_image_sizes() {
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
add_action('wp_enqueue_scripts', 'jb_theme_enqueue_scripts', 100);
function jb_theme_enqueue_scripts() {

	wp_enqueue_script( 'jquery' );

	//wp_enqueue_style('bootswatch', get_template_directory_uri() . '/styles/bootstrap.min.css', array(), filemtime(get_template_directory().'/styles/bootstrap.min.css'));

	// wp_enqueue_script('animejs', get_template_directory_uri() . '/lib/anime-master/lib/anime.min.js', '', '', true);

	//wp_enqueue_style('lity.css', 'https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.css', array(), '');
	//wp_enqueue_script( 'lity.js', 'https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js', array(), '', true);

	wp_register_script(
		'variables',
		get_template_directory_uri() . '/js/variables.js',
		array( ),
		1.0,
		true
	);

	wp_enqueue_script( 'variables' );

	$ajax_variables = array(
		/* examples */
		'user_id' => get_current_user_id()
	);

	wp_localize_script( 'variables', 'ajax_variables', $ajax_variables );
	
	if(ENVIRONMENT != 'dev') {
		wp_enqueue_style('custom', get_template_directory_uri() . '/styles/live.css', array(), filemtime(get_template_directory().'/styles/live.css'));
		wp_enqueue_script('jquery.site', get_template_directory_uri() . '/js/live.js', 'jquery', filemtime(get_template_directory().'/js/live.js'), true);
	} else {
		wp_enqueue_style('custom', get_template_directory_uri().'/styles/dev.css', array(), time());
		wp_enqueue_script('jquery.site', get_template_directory_uri().'/js/dev.js', 'jquery', time(), true);
	}

	



	// Try to recognize Darkmode on different sub sites
	// if(! empty($_COOKIE['darkmode'])){
	// 	// User recently set darkmode
	// 	update_user_meta(get_current_user_id(), 'darkmode', 1);
	// }

	// else{
	// 	$darkmode = get_user_meta(get_current_user_id(), 'darkmode', true);

	// 	if(! empty($darkmode)){
	// 		setcookie('darkmode', 1, YEAR_IN_SECONDS);
	// 	}
	// }

	// $darkmode = get_user_meta(get_current_user_id(), 'darkmode', true);
	// jb_print($darkmode);

}

//putting Googlt Fonts in the footer improves pagespeed rankings
add_action('get_footer', 'jb_theme_enqueue_fonts', 10);
//if you are noticing a brief delay before fonts loads (usually when loading multiple fonts) you can load in the header to prevent flash, but take a hit on pagespeed rankings
//add_action('get_header', 'jb_theme_enqueue_fonts', 10);
function jb_theme_enqueue_fonts() {
	// Import Google Web Fonts
	$fonts = array(
			'Open Sans' => '400,700',
		);

	jb_webfont($fonts);
}

//Change "posts" name to "Announcements"
//add_filter('jb_change_post_label','jb_return_post_label');
function jb_return_post_label(){
	return 'Video';
}

// filter to disable/enable block editor on a specific basis, full post object is passed with post type
add_filter('use_block_editor_for_post', 'jb_use_block_editor_for_post', 9999, 2);
function jb_use_block_editor_for_post($use_block_editor, $post) {
	return false;
}


add_filter( 'body_class', 'jb_body_classes' );
function jb_body_classes( $classes ) {
	$darkmode = get_user_meta( get_current_user_id(), 'darkmode', true );
	if ( ! empty($darkmode) ) {
		$classes[] = 'darkmode';
	}
	return $classes;
}


/**
 * On Channel Save get the next X videos from a specific channel
 *
//  * @param string $channel_id The YT ID for this channel
//  * @param int $channel_post_id The WP Post ID for this channel
//  * @param int $max_results The max results to return
//  * @param string $nextPageToken The nextPageToken returned from the last set of results (NOT IN USE)
 * @return object
 */
add_action( 'save_post_channels', 'jb_set_yt_channel_info', 100, 3 );
function jb_set_yt_channel_info($post_id, $post, $update){
	jb_set_channel_videos($post_id);
	jb_set_channel_thumbnail($post_id);

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

	if(empty($channel_videos) && ! empty($channel_id)){
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

			$result = @file_get_contents($url);

			if($result){

				$channel_obj = json_decode( $result );

				$videos = jb_channel_items_to_videos($channel_obj->items);

				// jb_print($videos);
				// die();
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
		$url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet%2Cstatistics&id='.$channel_id.'&key='.$yt_id;

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


/**
 * CRON JOB to update all the channel video lists
 * 
 * Run 1 - 3 times a day?
 * 
 * NOTE: We are running this function without looping to reduce the number of YT calls we make in a day
 */
add_action( 'jb_update_channel_list', 'jb_update_channel_list' );
function jb_update_channel_list(){
	$yt_id = jb_get('yt-api-key');
	
	$channel_args = array(
		'post_type' => 'channels',
		'posts_per_page' => -1,
	);

	$channels = get_posts($channel_args);
	
	// Loop through all channels to get the most recent
	if(! empty($channels)){
		foreach($channels as $channel){
			$channel_id = get_field('channel_id', $channel->ID);

			$videos = json_decode(get_post_meta( $channel->ID, 'cached_video_list', true ));

			$url = 'https://www.googleapis.com/youtube/v3/search?key='.$yt_id.'&channelId='.$channel_id.'&part=snippet,id&order=date&maxResults=5';

			$result = file_get_contents($url);

			$channel_obj = json_decode( $result );

			if($channel_obj->items){
				// No New Videos
				if($videos[0]->id->videoId === $channel_obj->items[0]->id->videoId) continue;
				
				// Add Latest Video!
				// TODO: We may want to check for multiple videos? It is possible for a channel to upload 2 videos in one day, although rare
				array_unshift($videos , $channel_obj->items[0]);
				update_post_meta( $channel->ID, 'cached_video_list', wp_json_encode($videos) );
			}

			// normalize this channel
			jb_add_normalized_channel($channel, true);
			
			// Sleep for a bit to prevent spamming youtube. Runs slower, but with better results.
			//sleep(1);
			usleep(500);
			
		}
	}

}


/**
 * CRON JOB used to normalize all channels into an easier to search format from the front end
 */
add_action( 'jb_normalize_channels', 'jb_normalize_channels' );
function jb_normalize_channels(){
	global $wpdb;

	$channel_args = array(
		'post_type' => 'channels',
		'posts_per_page' => -1,
	);

	$channels = get_posts($channel_args);
	
	// Loop through all channels to get the most recent
	if(! empty($channels)){
		foreach($channels as $channel){
			jb_add_normalized_channel($channel, true);
		}
	}

	//jb_print($wpdb->queries);
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
			'tags' => '',
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
				'tags' => '',
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
	
	//if($channel_id != 2) return;
	
	//jb_print($video);

	if(empty($video->video_id)) return;

	$video_table = 'jb_videos';

	// This insert is not working and I am not sure why
	// $wpdb->insert(
	// 	$video_table,
	// 	array(
	// 		'youtube_id' => $video->video_id,
	// 		'channel_id' => $channel_id,
	// 		'title' => $video->title,
	// 		//'description' => $video->video_id,
	// 		'date' => date('Y-m-d', strtotime($video->date)),
	// 	),
	// 	array(
	// 		'%s',
	// 		'%d',
	// 		'%s',
	// 		'%s'
	// 	)
	// );

	// This query works but the insert above does not. Weird
	$wpdb->query(
		$wpdb->prepare("INSERT INTO {$video_table} (`youtube_id`, `channel_id`, `title`, `description`, `date`) 
						VALUES (%s, %d, %s, %s)
						ON DUPLICATE KEY UPDATE
						`youtube_id` = %s, 
						`channel_id` = %d,
						`title` = %s,
						`description` = %s,
						`date` = %s", 
						$video->video_id, 
						$channel_id, 
						$video->title, 
						$video->description, 
						date('Y-m-d', strtotime($video->date)), 
						$video->video_id, 
						$channel_id,
						$video->title, 
						$video->description, 
						date('Y-m-d', strtotime($video->date))
			
		)
	);

	//jb_print($wpdb->last_query);
	//jb_print($wpdb->last_error);

	// if($wpdb->insert_id === 0){
	// 	$wpdb->update(
	// 		$video_table,
	// 		array(
	// 			'channel_id' => $channel_id,
	// 			'title' => $video->title,
	// 			'description' => $video->video_id,
	// 			'date' => date('Y-m-d', strtotime($video->date)),
	// 		),
	// 		array(
	// 			'youtube_id' => $video->video_id
	// 		)
	// 	);
	// }else if($wpdb->insert_id === false){
	// 	// Error
	// }

}