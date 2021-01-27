<?php 

require_once('api-setup.php');

$channel_img = jb_get_channel_thumbnail($_POST['youtube_id']);

$wpdb->insert(
	$channel_table,
	array(
		'youtube_id' => $_POST['youtube_id'],
		'title' => $_POST['title'],
		'description' => $_POST['description'],
		'img_url' => $channel_img,
		'facebook' => $_POST['facebook'],
		'instagram' => $_POST['instagram'],
		'patreon' => $_POST['patreon'],
		'tiktok' => $_POST['tiktok'],
		'twitter' => $_POST['twitter'],
		'twitch' => $_POST['twitch'],
		'website' => $_POST['website'],
		'tags' => $_POST['tags'],
	)
);

if($wpdb->insert_id === 0){
	$wpdb->update(
		$channel_table,
		array(
			'title' => $_POST['title'],
			'description' => $_POST['description'],
			'img_url' => $channel_img,
			'facebook' => $_POST['facebook'],
			'instagram' => $_POST['instagram'],
			'patreon' => $_POST['patreon'],
			'tiktok' => $_POST['tiktok'],
			'twitter' => $_POST['twitter'],
			'twitch' => $_POST['twitch'],
			'website' => $_POST['website'],
			'tags' => $_POST['tags'],
		),
		array(
			'youtube_id' => $_POST['youtube_id'],
		)
	);
}else if($wpdb->insert_id === false){
	// Error
}

echo json_encode($wpdb->insert_id);
exit;