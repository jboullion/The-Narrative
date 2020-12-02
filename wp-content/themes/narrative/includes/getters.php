<?php 
/**
 * GET some information
 */

/**
 * Get the img url of video
 *
 * @param int $video_id The id of the video
 */
function sp_get_video_img_url($video_id, $size = 'mqdefault'){
	//0,1,2,3,default,hqdefault,mqdefault,sddefault,maxresdefault
	return 'https://img.youtube.com/vi/'.$video_id.'/'.$size.'.jpg';
}


/**
 * Get X terms
 *
 * @param int $video_id The id of the video
 */
function sp_get_taxonomy_terms($taxonomy, $count = 6, $random = false){

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

// function sp_get_yt_video_info($video_id){
// 	$yt_id = pk_get('yt-api-key');

// 	$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id='.$video_id.'&key='.$yt_id;

// 	$ch = curl_init();
// 	curl_setopt( $ch, CURLOPT_URL, $url );
// 	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

// 	// TODO: setup check on what we return?
// 	return json_decode( curl_exec( $ch ) );
// }


// function sp_get_yt_channel_info($channel_id){
// 	$yt_id = pk_get('yt-api-key');
	
// 	$url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id='.$channel_id.'&key='.$yt_id;

// 	$ch = curl_init();
// 	curl_setopt( $ch, CURLOPT_URL, $url );
// 	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

// 	// TODO: setup check on what we return?
// 	return json_decode( curl_exec( $ch ) );
// }