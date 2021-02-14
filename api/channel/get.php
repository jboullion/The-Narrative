<?php 

require_once('../api-setup.php');

if(empty($_GET['channel_id']) 
&& empty($_GET['youtube_id'])) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

// $channel_args = array(
// 	'posts_per_page' => 1,
// 	'post_type' => 'channels'
// );

// if(! empty($_GET['channel_id']) ) {
// 	$channel_args['p'] = $_GET['channel_id'];
// }else if(! empty($_GET['youtube_id'])){
// 	$channel_args['meta_key'] = 'channel_id';
// 	$channel_args['meta_value'] = $_GET['youtube_id'];
// }

// $channels = get_posts($channel_args);

// if(! empty($channels)){
// 	$channel = $channels[0];
// 	$channel->img_url = get_the_post_thumbnail_url($channel->ID,'large'); 
// 	$channel->meta = get_fields($channel->ID); 
// }

// echo json_encode($channel);
// exit;



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