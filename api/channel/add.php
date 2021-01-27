<?php 

require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->youtube_id) ) {
// || empty($content->title)
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$channel_img = jb_get_channel_thumbnail($content->youtube_id);

$wpdb->insert(
	$wpdb->channels,
	array(
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
		'tags' => $content->tags,
	)
);

if($wpdb->insert_id === 0){
	$wpdb->update(
		$wpdb->channels,
		array(
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
			'tags' => $content->tags,
		),
		array(
			'youtube_id' => $content->youtube_id,
		)
	);
}else if($wpdb->insert_id === false){
	// Error
}

echo json_encode($wpdb->insert_id);
exit;