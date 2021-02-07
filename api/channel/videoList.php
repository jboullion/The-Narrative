<?php 

require_once('../api-setup.php');

if(empty($_GET['channel_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}


$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:10;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;

$search_query = $wpdb->prepare("SELECT V.*, C.youtube_id AS channel_youtube, C.title AS channel_title FROM {$wpdb->videos} AS V 
				LEFT JOIN {$wpdb->channels} AS C ON V.channel_id = C.channel_id
				WHERE V.channel_id = %d ", $_GET['channel_id']);

if(! empty($_GET['s'])){
	$search_query .= $wpdb->prepare("AND title LIKE %s", $_GET['s'].'%');
}

$search_query .= $wpdb->prepare(" LIMIT %d, %d", $offset, $limit);

$videos = $wpdb->get_results($search_query);

echo json_encode($videos);
exit;