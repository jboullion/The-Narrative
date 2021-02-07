<?php 
/**
 * Save a video as liked by the user
 */
require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->user_id) || ! is_numeric($content->user_id)
|| empty($content->video_id) || ! is_numeric($content->video_id) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$wpdb->insert(
	$wpdb->history,
	array(
		'user_id' => $content->user_id,
		'video_id' => $content->video_id,
		'last_watched' => date('Y-m-d H:i:s')
	)
);

if($wpdb->insert_id === 0){
	$wpdb->update(
		$wpdb->history,
		array(
			'last_watched' => date('Y-m-d H:i:s')
		),
		array(
			'user_id' => $content->user_id,
			'video_id' => $content->video_id
		)
	);
}

echo json_encode($wpdb->insert_id);
exit;