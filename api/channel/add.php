<?php 

require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->youtube_id) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$channel_img = jb_get_channel_thumbnail($content->youtube_id);

$channel = array(
	'youtube_id' => $content->youtube_id,
	'title' => $content->title,
	'description' => $content->description,
	'img_url' => $channel_img,
	'facebook' => $content->facebook,
	'instagram' => $content->instagram,
	'patreon' => $content->patreon,
	'tiktok' => $content->tiktok,
	'twitter' => $content->twitter,
	'twitch' => $content->twitch,
	'website' => $content->website,
	'tags' => $content->tags
);

$wpdb->insert(
	$wpdb->channels,
	$channel
);

if($wpdb->insert_id === false){
	// Error
}

// if($wpdb->insert_id === 0){
// 	$wpdb->update(
// 		$wpdb->channels,
// 		$channel,
// 		array(
// 			'youtube_id' => $content->youtube_id,
// 		)
// 	);
// }else if($wpdb->insert_id === false){
// 	// Error
// }

echo json_encode(array('success' => true, 'channel_id' => $wpdb->insert_id));
exit;