<?php 

require_once('api-setup.php');

$limit = ! empty($_POST['limit']) && is_numeric($_POST['limit'])?$_POST['limit']:10;
$offset = ! empty($_POST['offset']) && is_numeric($_POST['offset'])?$_POST['offset']:0;

$search_query = "SELECT * FROM {$wpdb->channels} WHERE 1=1 ";

if(! empty($_POST['s'])){
	$search_query .= $wpdb->prepare("AND title LIKE %s", $_POST['s'].'%');
}

$search_query .= $wpdb->prepare("LIMIT %d, %d", $offset, $limit);

$channels = $wpdb->get_results($search_query);

if(! empty($channels)){
	foreach($channels as $channel){
		$channels->videos = $wpdb->get_results("SELECT * FROM {$wpdb->channels} WHERE channel_id = {$channel->channel_id}");
	}
}

echo json_encode($channels);
exit;