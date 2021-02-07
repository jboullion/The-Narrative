<?php 

require_once('../api-setup.php');

if(empty($_GET['youtube_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$user_id = $_GET['user_id']?:1;

$search_query = $wpdb->prepare("SELECT V.*, C.youtube_id AS channel_youtube, L.liked_id AS isLiked FROM {$wpdb->videos} AS V 
				LEFT JOIN {$wpdb->channels} AS C ON V.channel_id = C.channel_id
				LEFT JOIN {$wpdb->liked} AS L ON V.video_id = L.video_id AND L.user_id = %d
				WHERE V.`youtube_id` = %s", $user_id, $_GET['youtube_id']);


$video = $wpdb->get_row($search_query);

//echo $wpdb->last_error;
//echo $wpdb->last_query;

echo json_encode($video);
exit;