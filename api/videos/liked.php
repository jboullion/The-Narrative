<?php 
/**
 * Save a video as liked by the user
 */
require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->token)
|| empty($content->video_id) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$user_id = jb_get_user_id($content->token);

// print_r($user_id);
// print_r('user_id');

if ($user_id) {

	$wpdb->insert(
		$wpdb->liked,
		array(
			'user_id' => $user_id,
			'video_id' => $content->video_id
		),
		array(
			'%s',
			'%d'
		)
	);


	if($wpdb->insert_id === 0){
		$wpdb->delete(
			$wpdb->liked,
			array(
				'user_id' => $user_id,
				'video_id' => $content->video_id
			),
			array(
				'%s',
				'%d'
			)
		);
	}

	echo json_encode($wpdb->insert_id);
	exit;
}else{
	echo json_encode(array('error' => 'Invalid Token'));
	exit;
}