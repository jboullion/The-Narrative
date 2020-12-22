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

function jb_get_yt_video_info($video_id){
	$yt_id = jb_get('yt-api-key');

	// Should we use the cached version of this channel's info?
	// $channel_cache = get_transient( 'channel_list_'.$channel_id );
	// if(! empty($channel_cache)) {
	// 	$channel_videos = get_field('cached_video_list', $channel_post_id);

	// 	if(! empty($channel_videos)){
	// 		return $channel_videos;
	// 	}
	// }

	$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id='.$video_id.'&key='.$yt_id;

	$result = file_get_contents($url);

	// TODO: setup check on what we return?
	return json_decode( $result );
}


function jb_get_yt_channel_videos($channel_id, $channel_post_id){
	$yt_id = jb_get('yt-api-key');

	// Should we use the cached version of this channel's info?
	$channel_cache = get_transient( 'channel_list_'.$channel_id );
	if(! empty($channel_cache)) {
		$channel_videos = get_field('cached_video_list', $channel_post_id);

		if(! empty($channel_videos)){
			return $channel_videos;
		}
	}

	$url = 'https://www.googleapis.com/youtube/v3/search?key='.$yt_id.'&channelId='.$channel_id.'&part=snippet,id&order=date&maxResults=20';

	$result = file_get_contents($url);

	// If we have a result, cache the info for 1 day
	if(! empty($result)){
		set_transient( 'channel_list_'.$channel_id, 1, DAY_IN_SECONDS );
		update_field('field_5fc9b8844e129', json_decode( $result ), $channel_post_id);
	}

	return json_decode( $result );
}


function jb_get_yt_channel_info($channel_id, $channel_post_id){
	$yt_id = jb_get('yt-api-key');

	// Should we use the cached version of this channel's info?
	$channel_cache = get_transient( 'channel_'.$channel_id );
	if(! empty($channel_cache)) {
		$channel_info = get_field('cached_channel_info', $channel_post_id);

		if(! empty($channel_info)){
			return $channel_info;
		}
	}

	$url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id='.$channel_id.'&key='.$yt_id;

	$result = file_get_contents($url);

	// If we have a result, cache the info for 1 month.
	if(! empty($result)){
		// We don't need to update the channel info very often
		set_transient( 'channel_'.$channel_id, 1, MONTH_IN_SECONDS );
		update_field('field_5fc9d0948331a', json_decode( $result ), $channel_post_id);
	}

	return json_decode( $result );
}