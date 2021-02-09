<?php 
/**
 * GET some information
 */

/**
 * Get the img url of video
 *
 * @param int $video_id The id of the video
 */
function jb_get_video_img_url($video_id, $size = 'mqdefault'){
	//0,1,2,3,default,hqdefault,mqdefault,sddefault,maxresdefault
	$img_url = 'https://img.youtube.com/vi/'.$video_id.'/'.$size.'.jpg';

	@getimagesize($img_url, $img_size);

	// Sometimes we do not have access to the video thumbnail and a "missing" img is returned that is 90 px high
	if(empty($img_size) || $img_size[1] === 90){
		$img_url = 'https://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}

	return $img_url;
}


/**
 * Get X terms
 *
 * @param int $video_id The id of the video
 */
function jb_get_taxonomy_terms($taxonomy, $count = 6, $random = false){

	$args = array(
		'taxonomy' => $taxonomy,
		'hide_empty' => true,
	);

	if(! $random){
		$args['number'] = $count;
	}
	
	$terms = get_terms( $args );

	if(empty( $terms )) return [];

	if($random){
		// Randomize Term Array
		shuffle( $terms );

		// Grab Indices 0 - 5, 6 in total
		return array_slice( $terms, 0, $count );
	}else{
		return $terms;
	}


}

// function jb_get_yt_video_info($video_id){
// 	$yt_id = jb_get('yt-api-key');

// 	// Should we use the cached version of this channel's info?
// 	// $channel_cache = get_transient( 'channel_list_'.$channel_id );
// 	// if(! empty($channel_cache)) {
// 	// 	$channel_videos = get_field('cached_video_list', $channel_post_id);

// 	// 	if(! empty($channel_videos)){
// 	// 		return $channel_videos;
// 	// 	}
// 	// }

// 	$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id='.$video_id.'&key='.$yt_id;

// 	$result = file_get_contents($url);

// 	// TODO: setup check on what we return?
// 	return json_decode( $result );
// }


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
	//$channel_videos = get_post_meta($channel_post_id,'cached_video_list', true);

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