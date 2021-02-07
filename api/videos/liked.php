<?php 
/**
 * Save a video as liked by the user
 */
require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->user_id) 
|| empty($content->video_id) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}


$wpdb->insert(
	$wpdb->liked,
	array(
		'user_id' => $content->user_id,
		'video_id' => $content->video_id
	)
);

if($wpdb->insert_id === 0){
	$wpdb->delete(
		$wpdb->liked,
		array(
			'user_id' => $content->user_id,
			'video_id' => $content->video_id
		)
	);
}

echo json_encode($wpdb->insert_id);
exit;