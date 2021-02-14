<?php 


/**
 * On Channel Save find videos and normalize
 *
 * @return object
 */
//add_action( 'save_post', 'jb_set_yt_channel_info', 100, 3 );
add_action( 'acf/save_post', 'jb_set_yt_channel_info', 100, 1 );
function jb_set_yt_channel_info($post_id){ // , $post, $update

	// Get this channel's image and most recent videos from YouTube

	//jb_set_channel_videos($post_id);
	jb_set_channel_thumbnail($post_id);

	// Add these channels to the normalized database
	jb_add_normalized_channel($post_id, true);
}




/**
 * Get the last X videos from a channel and store them for later
 *
 * @param int $post_id The post->ID of the channel in question
 * @return void
 */
// function jb_set_channel_videos($post_id){
// 	//$channel_videos = get_post_meta($post_id,'cached_video_list', true);
// 	$last_update = get_field( 'last_updated', $post_id);

// 	// Only update a channel if it hasn't been updated for a day
// 	if($last_update && (int)$last_update >= (int)date('Ymd')) return;

// 	update_field( 'field_60236ff01e466', date('Ymd'), $post_id );

// 	$channel_id = get_field('channel_id', $post_id);

// 	if(! empty($channel_id)){
// 		$yt_id = get_field('yt_api_key', 'option');

// 		$done = false;
// 		$max_videos = 120; // TODO: Increase this number? OR Setup some other "Full Import"
// 		$safety = 6;
// 		$videos = array();
// 		$channel_obj = null;

// 		$count = 0;
// 		while(! $done){
// 			$count++;

// 			$url = 'https://www.googleapis.com/youtube/v3/search?key='.$yt_id.'&channelId='.$channel_id.'&part=snippet&order=date&maxResults=20';

// 			if($channel_obj && ! empty($channel_obj->nextPageToken)){
// 				$url .= '&pageToken='.$channel_obj->nextPageToken;
// 			}

// 			$result = file_get_contents($url);

// 			if($result){

// 				$channel_obj = json_decode( $result );

// 				$videos = array_merge($videos, $channel_obj->items);

// 				jb_get_yt_video_info($video_id, $channel_id);

// 				//$videos = jb_channel_items_to_videos($channel_obj->items);

// 				if(count($videos) >= $max_videos
// 				|| $count > $safety){
// 					$done = true;
// 					break;
// 				}
// 			}else{
// 				$done = true;
// 				break;
// 			}
// 		}

// 		// If we have a result, cache the info for 1 day
// 		// if(! empty($videos)){

// 		// 	foreach($videos as $video){
// 		// 		$exists = get_posts(array(
// 		// 			'post_type' => 'videos',
// 		// 			'meta_key' => 'youtube_id',
// 		// 			'meta_value' => $video->id->videoId
// 		// 		));

// 		// 		// Don't create duplicate videos
// 		// 		if($exists) continue;


// 		// 		// Query YouTube to get full description / tags
// 		// 		// NOTE: This consumes a lot of our quota since it runs X times per channel
// 		// 		$video_info = jb_get_yt_video_info($video->id->videoId);

// 		// 		$video_post = array(
// 		// 			'post_title'    => html_entity_decode(wp_strip_all_tags( $video_info->title ), ENT_QUOTES),
// 		// 			'post_content'  => $video_info->description,
// 		// 			'post_status'   => 'publish',
// 		// 			'post_type' 	=> 'videos',
// 		// 			'post_date' 	=> $video_info->publishedAt // $video->snippet->publishTime
// 		// 		);

// 		// 		// Insert the post into the database
// 		// 		$video_id = wp_insert_post( $video_post );

// 		// 		if($video_id){
// 		// 			//update_post_meta($video_id, 'channel', $post_id);
// 		// 			//update_post_meta($video_id, 'youtube_id', $video->id->videoId);
// 		// 			update_field('field_60236c624d18c', $post_id, $video_id); // channel
// 		// 			update_field('field_60236de9dad65', $video->id->videoId, $video_id); // youtube id
// 		// 			if($video_info->tags){
// 		// 				update_field('field_6023ebabe2758', '#'.implode(',#',$video_info->tags).',', $video_id); // youtube id
// 		// 			}
// 		// 			//update_field('field_6025e6e39de27', date('Ymd', strtotime($video->snippet->publishTime)), $video_id); // publish date
// 		// 		}

// 		// 	}

// 		// 	//update_post_meta( $post_id, 'cached_video_list', json_encode($videos) );
// 		// 	// last_updated

// 		// }
// 	}
// }


/**
 * Undocumented function
 *
 * @param string $video_id AKA This Video's youtube ID
 * @return object Returns object if successfull or false on failure
 */
function jb_get_yt_video_info($video_id){
	$yt_id = get_field('yt_api_key', 'option');

	$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$video_id.'&key='.$yt_id;

	$result = file_get_contents($url);

	if($result){
		$result_obj = json_decode( $result );
		// TODO: setup check on what we return?
		return $result_obj->items[0]->snippet;
	}else{
		return false;
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