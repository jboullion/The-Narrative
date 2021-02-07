<?php 

require_once('../api-setup.php');

if(empty($_GET['user_id']) || ! is_numeric($_GET['user_id'])){
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$initial_video_limit = 20;

$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$initial_video_limit;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;

$video_query = $wpdb->prepare("SELECT V.*, L.created AS likedDate FROM {$wpdb->videos} AS V 
				LEFT JOIN {$wpdb->liked} AS L USING(video_id) 
				WHERE `user_id` = %d 
				ORDER BY L.liked_id DESC
				LIMIT %d, %d", $_GET['user_id'], $offset, $limit);


$videos = $wpdb->get_results($video_query);

echo json_encode($videos);
exit;