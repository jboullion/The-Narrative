<?php 

require_once('../api-setup.php');

if(empty($_POST['channel_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$wpdb->update(
	$channel_table,
	array(
		'title' => $_POST['title'],
		'description' => $_POST['description'],
		//'img_url' => $channel_img,
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
		'youtube_id' => $_POST['channel_id'],
	)
);

echo json_encode($channels);
exit;