<?php 
/**
 * Return the liked videos of a particular user
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

	$video_query = $wpdb->prepare("SELECT V.*, WL.created AS savedDate FROM {$wpdb->videos} AS V 
					LEFT JOIN {$wpdb->watch_later} AS WL USING(video_id) 
					WHERE `user_id` = %s ", $user_id);
		
	if(! empty($_GET['s'])){
		$video_query .= $wpdb->prepare(" AND ( title LIKE %s OR tags LIKE %s) ", '%'.$_GET['s'].'%', '%#'.$_GET['s'].',%');
	}


	$video_query .= $wpdb->prepare(" ORDER BY WL.watch_id DESC
					LIMIT %d, %d", $offset, $limit);


	$videos = $wpdb->get_results($video_query);

	// print_r($wpdb->last_error);
	// print_r($wpdb->last_query);

	echo json_encode($videos);
	exit;

} else {
	echo json_encode(array('error' => 'Invalid Token'));
	exit;
}