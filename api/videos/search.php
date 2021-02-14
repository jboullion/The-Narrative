<?php 

require_once('../api-setup.php');

// $limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
// $offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']:0;


// $video_args = array(
// 	'posts_per_page' => $limit,
// 	'paged' => $offset?$offset+1:1,
// 	'post_type' => 'videos',
// );


// if(! empty($_GET['s'])){
// 	$video_args['s'] = $_GET['s'];
// }

// if(! empty($_GET['channel_id']) ) {
// 	$video_args['meta_key'] = 'channel';
// 	$video_args['meta_value'] = $_GET['channel_id'];
// }else if(! empty($_GET['youtube_id'])){
// 	$video_args['meta_key'] = 'youtube_id';
// 	$video_args['meta_value'] = $_GET['youtube_id'];
// }


// $videos = get_posts($video_args);

// if(! empty($videos)){
// 	foreach($videos as $vkey => $video){
// 		$videos[$vkey]->post_title = html_entity_decode($video->post_title, ENT_QUOTES);
// 		$videos[$vkey]->youtube_id = get_post_meta($video->ID, 'youtube_id', true);
// 		//$videos[$vkey]->date = get_post_meta($video->ID, 'date', true);
// 		$videos[$vkey]->channel_youtube = $channel->meta->channel_id;
// 		$videos[$vkey]->channel_title = $channel->post_title;
// 		$videos[$vkey]->channel_id = $channel->ID;
// 	}
	
// }

// echo json_encode($videos);
// exit;




$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;


$search_query = "SELECT * FROM {$wpdb->videos} AS V ";

// if(! empty($_GET['style'])){
// 	$search_query .= " LEFT JOIN {$wpdb->channel_styles} AS CS ON CS.channel_id = C.channel_id ";
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= " LEFT JOIN {$wpdb->channel_topics} AS CT ON CT.channel_id = C.channel_id ";
// }

$search_query .= " WHERE 1=1 ";

if(! empty($_GET['s'])){
	$search_query .= $wpdb->prepare("AND ( title LIKE %s OR tags LIKE %s) ", '%'.$_GET['s'].'%', '%#'.$_GET['s'].',%');
}

if(! empty($_GET['channel_id'])){
	$search_query .= $wpdb->prepare(" AND channel_id = %d ", $_GET['channel_id']);
}

// if(! empty($_GET['style'])){
// 	$search_query .= $wpdb->prepare(" AND CS.style_id = %d ", $_GET['style']);
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= $wpdb->prepare(" AND CT.topic_id = %d ", $_GET['topic']);
// }

if(! empty($_GET['rand'])){
	$search_query .= " ORDER BY RAND() ";
}

$search_query .= $wpdb->prepare(" LIMIT %d, %d", $offset, $limit);

$videos = $wpdb->get_results($search_query);

// print_r($wpdb->last_error);
// print_r($wpdb->last_query);


echo json_encode($videos);
exit;