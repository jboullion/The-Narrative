<?php 
/**
 * Get videos related to a partcular channel.
 * 
 * TODO: We may want a more sophisticated related functionality, but for now we just find similar channels and get random videos from them
 */
require_once('../api-setup.php');

if(empty($_GET['channel_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:20;

$user_id = $_GET['user_id']?:0;


$video_args = array(
	'posts_per_page' => $limit,
	'paged' => $offset?$offset+1:1,
	'post_type' => 'videos',
);


if(! empty($_GET['s'])){
	$video_args['s'] = $_GET['s'];
}

if(! empty($_GET['channel_id']) ) {
	$video_args['meta_key'] = 'channel';
	$video_args['meta_value'] = $_GET['channel_id'];
}else if(! empty($_GET['youtube_id'])){
	$video_args['meta_key'] = 'youtube_id';
	$video_args['meta_value'] = $_GET['youtube_id'];
}


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





// // What styles does this channel have?
// // TODO: Can we get these from channels laters?
// $styles = $wpdb->get_results(
// 				$wpdb->prepare("SELECT style_id FROM {$wpdb->channel_styles} 
// 								WHERE `channel_id` = %d", 
// 								$_GET['channel_id'])
// 							);


// $style_ids = array_column($styles, 'style_id');

// // What channels share these styles
// $channels = $wpdb->get_results(
// 				$wpdb->prepare("SELECT channel_id FROM {$wpdb->channel_styles} 
// 								WHERE `style_id` IN (".implode(',',$style_ids).")", 
// 								$_GET['channel_id'])
// 							);

// $channel_ids = array_column($channels, 'channel_id');


// if(! empty($channel_ids)){
// 	// NOTE: RAND() is not very efficient so when we update this script to return better results probably do something other than rand
// 	$search_query = $wpdb->prepare("SELECT V.*, C.youtube_id AS channel_youtube, C.title AS channel_title FROM {$wpdb->videos} AS V 
// 									LEFT JOIN {$wpdb->channels} AS C ON V.channel_id = C.channel_id
// 									WHERE V.`channel_id` IN (".implode(',',$channel_ids).")
// 									ORDER BY RAND()
// 									LIMIT %d", 
// 									$limit
// 								);

// 	$videos = $wpdb->get_results($search_query);

// 	// L.liked_id AS isLiked 
// 	//LEFT JOIN {$wpdb->liked} AS L ON V.video_id = L.video_id AND L.user_id = %d

// 	echo json_encode($videos);
// 	exit;
// }

// echo json_encode([]);
// exit;