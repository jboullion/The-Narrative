<?php 
/**
 * Save a video as liked by the user
 */

require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));


if(empty($content->video_id) || ! is_numeric($content->video_id)
|| empty($content->channel_id) || ! is_numeric($content->channel_id) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

if(! empty($content->token)){
	$user_id = jb_get_user_id($content->token);

	if ($user_id) {

		$wpdb->insert(
			$wpdb->history,
			array(
				'user_id' => $user_id,
				'video_id' => $content->video_id,
				'last_watched' => date('Y-m-d H:i:s')
			),
			array(
				'%s',
				'%d',
				'%s'
			)
		);


		if($wpdb->insert_id === 0){
			$wpdb->update(
				$wpdb->history,
				array(
					'last_watched' => date('Y-m-d H:i:s')
				),
				array(
					'user_id' => $user_id,
					'video_id' => $content->video_id
				),
				array(
					'%s',
				),
				array(
					'%s',
					'%d',
				)
			);
		}
	}
}


$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->video_views} (`video_id`, `view_count`) VALUES (%d,1)
				ON DUPLICATE KEY UPDATE `view_count` = view_count+1", $content->video_id ));


$channel_obj = jb_get_video_info($content->video_id, 'channel_id');

if(! empty($channel_obj)){
	$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->channel_views} (`channel_id`, `view_count`) VALUES (%d,1)
				ON DUPLICATE KEY UPDATE `view_count` = view_count+1 ", $channel_obj->channel_id ));

}



echo json_encode($wpdb->insert_id);
exit;