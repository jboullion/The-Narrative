<?php 
/**
 * Get all the videos this user has watched
 */

require_once('../api-setup.php');

if(empty($_GET['token'])){
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$user_id = jb_get_user_id($_GET['token']);

if ($user_id) {

	$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
	$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;


	$video_query = $wpdb->prepare("SELECT V.*, H.created AS watchedDate FROM {$wpdb->videos} AS V 
					LEFT JOIN {$wpdb->history} AS H USING(video_id) 
					WHERE `user_id` = %s ", $user_id);
		
	if(! empty($_GET['s'])){
		$video_query .= $wpdb->prepare(" AND ( title LIKE %s OR tags LIKE %s) ", '%'.$_GET['s'].'%', '%#'.$_GET['s'].',%');
	}


	$video_query .= $wpdb->prepare(" ORDER BY H.last_watched DESC
					LIMIT %d, %d", $offset, $limit);


	$videos = $wpdb->get_results($video_query);

	echo json_encode($videos);
	exit;
}else{
	echo json_encode(array('error' => 'Invalid Token'));
	exit;
}