<?php 
/**
 * Return simple / constent data or provide other "helper" type functionality
 */

/**
 * Display the last couple errors from WPDB
 */
function jb_wpdb_errors($wpdb){
	jb_print($wpdb->last_query);
	jb_print($wpdb->last_error);
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
			$videos[] = array(
				'video_id' => $item->id->videoId,
				'title' => $item->snippet->title,
				'description' => sanitize_text_field($item->snippet->description),
				'tags' => '#'.implode(',#',$item->snippet->tags).',',
				'date' => date('F j, Y', strtotime($item->snippet->publishTime)),
			);
		}
	}

	return $videos;
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