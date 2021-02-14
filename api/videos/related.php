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

// $limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
// $offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']:0;

$user_id = $_GET['user_id']?:0;

// $styles = get_the_terms($_GET['channel_id'], 'style');
// $topics = get_the_terms($_GET['channel_id'], 'topic');

// $channel_args = array(
// 	'posts_per_page' => -1,
// 	'orderby' => 'rand',
// 	'post_type' => 'channels',
// 	'tax_query' => array(
// 		'relation' => 'AND'
// 	)
// );

// if(! empty($styles)){
// 	$style_ids = array_column($styles, 'term_id');
// 	$channel_args['tax_query'][] = array(
// 									'taxonomy' => 'style',
// 									'field'    => 'term_id',
// 									'terms'    => array( $style_ids ),
// 									);
// }

// if(! empty($topics)){
// 	$topic_ids = array_column($styles, 'term_id');

// 	$channel_args['tax_query'][] = array(
// 									'taxonomy' => 'topic',
// 									'field'    => 'term_id',
// 									'terms'    => array( $topic_ids ),
// 									);
// }


// $channels = get_posts($channel_args);


// $channel_ids = array_column($channels, 'ID');



// // TODO: Orderby 'date' always returns same order of related videos...is that good?
// $video_args = array(
// 	'posts_per_page' => $limit,
// 	'paged' => $offset?$offset+1:1,
// 	'post_type' => 'videos',
// 	//'orderby' => 'rand',
// 	'orderby' => 'date',
// 	'order' => 'DESC',
// 	'meta_query' => array(
// 		array(
// 			'key'		=> 'channel',
// 			'value'    	=> $channel_ids,
// 			'compare'   => 'IN',
// 		)
// 	)
// );

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


// What styles does this channel have?
// TODO: Can we get these from channels laters?
$styles = $wpdb->get_results(
				$wpdb->prepare("SELECT style_id FROM {$wpdb->channel_styles} 
								WHERE `channel_id` = %d", 
								$_GET['channel_id'])
							);


$style_ids = array_column($styles, 'style_id');

// What channels share these styles
$channels = $wpdb->get_results(
				$wpdb->prepare("SELECT channel_id FROM {$wpdb->channel_styles} 
								WHERE `style_id` IN (".implode(',',$style_ids).")", 
								$_GET['channel_id'])
							);

$channel_ids = array_column($channels, 'channel_id');


// print_r($wpdb->last_error);
// print_r($wpdb->last_query);

if(! empty($channel_ids)){
	// NOTE: RAND() is not very efficient so when we update this script to return better results probably do something other than rand
	$search_query = $wpdb->prepare("SELECT V.*, C.youtube_id AS channel_youtube, C.title AS channel_title FROM {$wpdb->videos} AS V 
									LEFT JOIN {$wpdb->channels} AS C ON V.channel_id = C.channel_id
									WHERE V.`channel_id` IN (".implode(',',$channel_ids).")
									ORDER BY RAND()
									LIMIT %d", 
									$limit
								);

	$videos = $wpdb->get_results($search_query);

	if($videos){
		foreach($videos as $vkey => $video){
			$videos[$vkey]->title = html_entity_decode($video->title, ENT_QUOTES);
			$videos[$vkey]->description = displayTextWithLinks($video->description);
			//$video->content = apply_filters('the_content', $video->content);
		}
	}

	// L.liked_id AS isLiked 
	//LEFT JOIN {$wpdb->liked} AS L ON V.video_id = L.video_id AND L.user_id = %d

	echo json_encode($videos);
	exit;
}


echo json_encode([]);
exit;