<?php 

require_once('../api-setup.php');

if(empty($_GET['channel_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}


$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']:0;



$video_args = array(
	'posts_per_page' => $limit,
	'paged' => $offset?$offset + 1:1,
	'post_type' => 'videos',
	'meta_key' => 'channel',
	'meta_value' => $_GET['channel_id']
);


$videos = get_posts($video_args);

if(! empty($videos)){
	foreach($videos as $vkey => $video){
		$videos[$vkey]->post_title = html_entity_decode($video->post_title, ENT_QUOTES);
		$videos[$vkey]->youtube_id = get_post_meta($video->ID, 'youtube_id', true);
		//$videos[$vkey]->date = get_post_meta($video->ID, 'date', true);
		$videos[$vkey]->channel_youtube = $channel->meta->channel_id;
		$videos[$vkey]->channel_title = $channel->post_title;
		$videos[$vkey]->channel_id = $channel->ID;
	}
}

echo json_encode($videos);
exit;


// $search_query = $wpdb->prepare("SELECT V.*, C.youtube_id AS channel_youtube, C.title AS channel_title FROM {$wpdb->videos} AS V 
// 				LEFT JOIN {$wpdb->channels} AS C ON V.channel_id = C.channel_id
// 				WHERE V.channel_id = %d ", $_GET['channel_id']);

// if(! empty($_GET['s'])){
// 	$search_query .= $wpdb->prepare("AND title LIKE %s", $_GET['s'].'%');
// }

// $search_query .= $wpdb->prepare(" LIMIT %d, %d", $offset, $limit);

// $videos = $wpdb->get_results($search_query);

// echo json_encode($videos);
// exit;