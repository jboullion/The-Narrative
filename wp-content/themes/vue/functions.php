<?php
// // includes all flags for certain theme support
// include('includes/theme-support.php');


// Include all our custom functionality
include('includes/setup.php');

// // Various functions which help with tasks around the site
// include('includes/helpers.php');

// // Get stuff
// include('includes/getters.php');

// // Modify queries
// include('includes/queries.php');


add_action('init', 'jb_register_cpts');
function jb_register_cpts() {

	jb_register_cpt(array('name' => 'channel', 'icon' => 'dashicons-id', 'position' => 30, 'public' => false )); // , 'show_in_rest' => true,
	//jb_register_cpt(array('name' => 'voice', 'icon' => 'dashicons-megaphone', 'position' => 31 ));
	
	jb_register_cpt(array('name' => 'video', 'icon' => 'dashicons-format-video', 'position' => 31, 'public' => false )); // , 'show_in_rest' => true,

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

	$cached_list = str_replace("\'","'",get_post_meta($post->ID,'cached_video_list', true));

	$channel_videos = json_decode($cached_list);

	echo '<table>
			<thead>
				<tr>
					<th>Title</th>
					<th>ID</th>
					<th>Date</th>
				</tr>
			</thead>';
	foreach($channel_videos as $vkey => $video){
		if(empty($video->video_id)) continue;

		echo '<tr>
				<td>'.$video->title.'</td>
				<td>'.$video->video_id.'</td>
				<td>'.$video->date.'</td>
			</tr>';
	}
	
	echo '</table>';

}



/**
 * On Channel Save find videos and normalize
 *
 * @return object
 */
//add_action( 'save_post', 'jb_set_yt_channel_info', 100, 3 );
add_action( 'acf/save_post', 'jb_set_yt_channel_info', 100, 3 );
function jb_set_yt_channel_info($post_id){ // , $post, $update

	// Get this channel's image and most recent videos from YouTube
	jb_set_channel_videos($post_id);
	jb_set_channel_thumbnail($post_id);

	// Add these channels to the normalized database
	// jb_add_normalized_channel($post, true);
}




/**
 * Get the last X videos from a channel and store them for later
 *
 * @param int $post_id The post->ID of the channel in question
 * @return void
 */
function jb_set_channel_videos($post_id){
	//$channel_videos = get_post_meta($post_id,'cached_video_list', true);
	$last_update = get_field( 'last_updated', $post_id);

	// Only update a channel if it hasn't been updated for a day
	if($last_update && (int)$last_update >= (int)date('Ymd')) return;

	update_field( 'field_60236ff01e466', date('Ymd'), $post_id );

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

				$videos = array_merge($videos, $channel_obj->items);

				//$videos = jb_channel_items_to_videos($channel_obj->items);

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

			foreach($videos as $video){
				$exists = get_posts(array(
					'post_type' => 'videos',
					'meta_key' => 'youtube_id',
					'meta_value' => $video->id->videoId
				));
				
				// Don't create duplicate videos
				if($exists) continue;
				/*
					'video_id' => $item->id->videoId,
					'title' => $item->snippet->title,
					'description' => sanitize_text_field(addslashes($item->snippet->description)),
					//'tags' => '#'.implode(',#',$item->snippet->tags).',',
					'date' => date('F j, Y', strtotime($item->snippet->publishTime)),
				*/

				$video_post = array(
					'post_title'    => wp_strip_all_tags( $video->snippet->title ),
					'post_content'  => $video->snippet->description,
					'post_status'   => 'publish',
					'post_type' 	=> 'videos'
				);
				
				// Insert the post into the database
				$video_id = wp_insert_post( $video_post );
				
				if($video_id){
					update_post_meta($video_id, 'channel', $post_id);
					update_post_meta($video_id, 'youtube_id', $video->id->videoId);
				}

			}

			//update_post_meta( $post_id, 'cached_video_list', json_encode($videos) );
			// last_updated
			
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
	if($channel_videos){
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
						VALUES (%s, %d, %s, %s, %s, %s)
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


/**
 * Get the next X videos from a specific channel
 *
 * @param string $channel_id The YT ID for this channel
 * @param int $channel_post_id The WP Post ID for this channel
 * @param int $max_results The max results to return
 * @param string $nextPageToken The nextPageToken returned from the last set of results (NOT IN USE)
 * @return object
 */
function jb_get_yt_channel_videos($channel_id, $channel_post_id, $max_results = 20, $nextPageToken = ''){

	$channel_videos = str_replace("\'","'",get_post_meta($channel_post_id,'cached_video_list', true));

	if(! empty($channel_videos)) {
		if(is_string($channel_videos)){
			return json_decode($channel_videos);
		}else{
			// If the channel videos were saved as something other than a string, just delete that meta for now and we will build it later
			delete_post_meta($channel_post_id,'cached_video_list');
		}
		
	}

	//return array();

	// $yt_id = jb_get('yt-api-key');

	// $url = 'https://www.googleapis.com/youtube/v3/search?key='.$yt_id.'&channelId='.$channel_id.'&part=snippet&order=date&maxResults='.$max_results;

	// // if(! empty($nextPageToken)){
	// // 	$url = '&pageToken='.$nextPageToken;
	// // }

	// $result = @file_get_contents($url);

	// // If we have a result, cache the info for 1 day
	// if(! empty($result)){
	// 	$channel_obj = json_decode( $result );
	// 	$videos = jb_channel_items_to_videos($channel_obj->items);

	// 	// If we have a result, cache the info for 1 day
	// 	if(! empty($videos)){
	// 		update_post_meta( $channel_post_id, 'cached_video_list', json_encode($videos) );
	// 		return $videos;
	// 	}

	// }

	// return array();
}


/**
 * Download an image from a URL and assign it as the featured image for a post
 *
 * @param string $image_url The url to find the image at
 * @param string $image_name The name to give this image
 * @param int $post_id the Post ID to assign this image to
 * @return void
 */
function jb_set_featured_image_from_url($image_url, $image_name, $post_id){
	// Add Featured Image to Post
	$upload_dir       = wp_upload_dir(); // Set upload folder
	$image_data       = file_get_contents($image_url); // Get image data
	$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
	$filename         = basename( $unique_file_name ).'.png'; // Create image file name

	// Check folder permission and define file location
	if( wp_mkdir_p( $upload_dir['path'] ) ) {
		$file = $upload_dir['path'] . '/' . $filename;
	} else {
		$file = $upload_dir['basedir'] . '/' . $filename;
	}

	// Create the image  file on the server
	file_put_contents( $file, $image_data );

	// Check image file type
	$wp_filetype = wp_check_filetype( $filename, null );

	// Set attachment data
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title'     => sanitize_file_name( $filename ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	// Create the attachment
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

	// Include image.php
	require_once(ABSPATH . 'wp-admin/includes/image.php');

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id, $attach_data );

	// And finally assign featured image to post
	set_post_thumbnail( $post_id, $attach_id );

	return wp_get_attachment_url( $attach_id );
}