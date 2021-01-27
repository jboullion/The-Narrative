<?php 

require_once('api-setup.php');

if(empty($_POST['channel_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$search_query = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->channels} WHERE channel_id = %d", $_POST['channel_id']));

$channel = $wpdb->get_results($search_query);

if(! empty($channel)){
	$channel->videos = $wpdb->get_results("SELECT * FROM {$wpdb->channels} WHERE channel_id = {$channel->channel_id}");
}

echo json_encode($channel);
exit;