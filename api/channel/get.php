<?php 

require_once('../api-setup.php');

if(empty($_GET['channel_id']) 
&& empty($_GET['youtube_id'])) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

if(! empty($_GET['channel_id']) ) {
	$channel = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->channels} WHERE channel_id = %d", $_GET['channel_id']));
}else if(! empty($_GET['youtube_id'])){
	$channel = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->channels} WHERE youtube_id = %s", $_GET['youtube_id']));
}
// if(! empty($channel)){
// 	$channel->videos = $wpdb->get_results("SELECT * FROM {$wpdb->channels} WHERE channel_id = {$channel->channel_id}");
// }

echo json_encode($channel);
exit;