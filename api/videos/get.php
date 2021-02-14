<?php 

require_once('../api-setup.php');

// if(empty($_GET['channel_id']) 
// && empty($_GET['youtube_id'])) {
// 	echo json_encode(array('error'=> 'Missing Information'));
// 	exit;
// }

// $video_args = array(
// 	'posts_per_page' => 1,
// 	'post_type' => 'videos'
// );

// if(! empty($_GET['channel_id']) ) {
// 	$video_args['meta_key'] = 'channel';
// 	$video_args['meta_value'] = $_GET['channel_id'];
// }else if(! empty($_GET['youtube_id'])){
// 	$video_args['meta_key'] = 'youtube_id';
// 	$video_args['meta_value'] = $_GET['youtube_id'];
// }

// $videos = get_posts($video_args);

// if(! empty($videos)){
// 	$video = $videos[0];
// 	$video->post_title = html_entity_decode($video->post_title, ENT_QUOTES);
// 	$video->youtube_id = get_post_meta($video->ID, 'youtube_id', true);
// 	$video->channel_id = (int)get_post_meta($video->ID, 'channel', true);
	

// 	$video->content = displayTextWithLinks($video->post_content);
	
// 	$video->content = apply_filters('the_content', $video->content);
// }


// echo json_encode($video);
// exit;






if($_GET['token']){
	$user_id = jb_get_user_id($_GET['token']);

	if($user_id){
		$search_query = $wpdb->prepare("SELECT V.*, C.youtube_id AS channel_youtube, L.liked_id AS isLiked, WL.watch_id AS isSaved FROM {$wpdb->videos} AS V 
				LEFT JOIN {$wpdb->channels} AS C ON V.channel_id = C.channel_id
				LEFT JOIN {$wpdb->liked} AS L ON V.video_id = L.video_id AND L.user_id = %s
				LEFT JOIN {$wpdb->watch_later} AS WL ON V.video_id = WL.video_id AND WL.user_id = %s
				WHERE V.`youtube_id` = %s", $user_id, $user_id, $_GET['youtube_id']);
	}
}

if(empty($search_query)){
	
	$search_query = $wpdb->prepare("SELECT V.*, C.youtube_id AS channel_youtube FROM {$wpdb->videos} AS V 
		LEFT JOIN {$wpdb->channels} AS C ON V.channel_id = C.channel_id
		WHERE V.`youtube_id` = %s", $_GET['youtube_id']);

}


$video = $wpdb->get_row($search_query);

// echo $wpdb->last_error;
// echo $wpdb->last_query;

if($video){
	$video->title = html_entity_decode($video->title, ENT_QUOTES);
	$video->description = displayTextWithLinks($video->description);
	//$video->content = apply_filters('the_content', $video->content);
}


echo json_encode($video);
exit;