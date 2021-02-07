<?php 

require_once('../api-setup.php');

if(empty($_GET['user_id']) || ! is_numeric($_GET['user_id'])){
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$initial_video_limit = 20;

$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$initial_video_limit;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;

$video_query = $wpdb->prepare("SELECT V.*, H.created AS watchedDate FROM {$wpdb->videos} AS V 
				LEFT JOIN {$wpdb->history} AS H USING(video_id) 
				WHERE `user_id` = %d 
				ORDER BY H.last_watched DESC
				LIMIT %d, %d", $_GET['user_id'], $offset, $limit);


$videos = $wpdb->get_results($video_query);

echo json_encode($videos);
exit;