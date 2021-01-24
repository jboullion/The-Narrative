<?php 

require_once('api-setup.php');

if(empty($_POST['channel_id']) 
|| empty($_POST['channel_post_id'])) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$channel_videos = $wpdb->get_var($wpdb->prepare("SELECT meta_value AS videos FROM {$wpdb->postmeta} WHERE meta_key = 'cached_video_list' AND post_id = %d", $_POST['channel_post_id']));

echo $channel_videos;
exit;

/*
$channel_HTML = '';
if(! empty($channel_videos)){
	$channel_videos = json_decode($channel_videos);

	foreach($channel_videos as $vkey => $video){
		if(empty($video->id->videoId)) continue;
		$channel_HTML .= jb_get_video_card($video);
	}
}

echo $channel_HTML;
exit;
*/