<?php 


function jb_setup_wpdb_tables(){
	global $wpdb;

	$wpdb->channels = $wpdb->prefix.'channels';
	$wpdb->videos = $wpdb->prefix.'videos';
	$wpdb->history = $wpdb->prefix.'history';
	$wpdb->liked = $wpdb->prefix.'liked';
	$wpdb->styles = $wpdb->prefix.'styles';
	$wpdb->topics = $wpdb->prefix.'topics';
	$wpdb->channel_styles = $wpdb->prefix.'channel_styles';
	$wpdb->channel_topics = $wpdb->prefix.'channel_topics';
	$wpdb->channel_views = $wpdb->prefix.'channel_views';
	$wpdb->video_views = $wpdb->prefix.'video_views';
	$wpdb->watch_later = $wpdb->prefix.'watch_later';
}

function jb_get_post_meta($post_id){
	global $wpdb;

	$all_meta = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = %d",$post_id));
	
	$meta_arr = array();
	if(! empty($all_meta) && ! empty($all_meta)){
		foreach($all_meta as $meta){
			$meta_arr[$meta->meta_key] = $meta->meta_value;
		}
		
		return $meta_arr;
	}

	return array();
}

// function jb_get_video_meta($video){
// 	if(! empty($video)){
// 		$video = $videos[0];
// 		$video->post_title = html_entity_decode($video->post_title, ENT_QUOTES);
// 		$video->youtube_id = get_post_meta($video->ID, 'youtube_id', true);
// 		//$video->date = get_post_meta($video->ID, 'date', true);
// 		$video->channel_youtube = $channel->meta->channel_id;
// 		$video->channel_title = $channel->post_title;
// 	}
// }

/**
 * Seach a text string and convert all urls with links
 *
 * @param string $s
 * @return string
 */
function displayTextWithLinks($s) {
	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $s);
}


/**
 * Return the Google User ID based on a token passed from the client
 *
 * @param [type] $token
 * @return void
 */
function jb_get_user_id($token){
	$LOGIN_CLIENT_ID = '310021421846-4atakhdcfm62jj95u4193fu2ri8h9q40.apps.googleusercontent.com';

	try{
		$client = new Google_Client(['client_id' => $LOGIN_CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend

		$payload = $client->verifyIdToken($token);
		
		if ($payload && $payload['sub']) {
			return $payload['sub'];
		}

		return false;
	}catch (exception $e) {
		return false;
		//print_r($e);
	}

	return false;
}


/**
 * Get a single video row
 * 
 * @param int $video_id The ID of the video in question
 * @param string $columns The columns in question
 * 
 * @return object Video row
 */
function jb_get_video_info($video_id, $columns = '*'){
	global $wpdb;

	$results = $wpdb->get_row($wpdb->prepare("SELECT {$columns} FROM {$wpdb->videos} WHERE video_id = %d", $video_id));

	return $results;
}

/**
 * Get this Channels thumbnail and set it
 * 
 * @param int $post_id The ID of the post to get the featured image for
 * @return string the URL of the post thumbnail
 */
function jb_get_channel_thumbnail($youtube_id){
	global $yt_key;

	if(empty($youtube_id )) return;

	$url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id='.$youtube_id.'&key='.$yt_key;

	$result = @file_get_contents($url);

	// If we have a result, cache the info for 1 month.
	if(! empty($result)){
		$channel_obj = json_decode( $result );
		return $channel_obj->items[0]->snippet->thumbnails->default->url;
	}

	return '';
}


/**
 * Display a video card found around the site
 * 
 * @param object $video The video post object
 */
function jb_get_video_card($video) { 
	$video_id = $video->id->videoId;
	$title = $video->snippet->title;
	$description = $video->snippet->description;
	$date = date('F j, Y', strtotime($video->snippet->publishTime));
	
	$video_img = jb_get_video_img_url($video_id);

	return '<a href="#" data-id="'.$video_id.'" class="card video h-100 yt-video">
			<div class="card-img-back" >
				<img src="'.$video_img.'" loading="lazy" width="320" height="180" />
				'.fa_play().'
			</div>
			<div class="card-body">
				<p class="ellipsis">'.$title.'</p>
				<span class="date">'.$date.'</span>
			</div>
		</a>';
}

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

function fa_play(){
	return '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="play-circle" class="svg-inline--fa fa-play-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.7 272l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z" opacity="0.8"></path><path class="fa-primary" fill="currentColor" d="M371.7 280l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z"></path></g></svg>';
}
