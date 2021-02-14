<?php 

require_once('../api-setup.php');

$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']:0;

// Average response time is about ~220 ms for standard WP functions. About ~30ms for custom query
$channel_args = array(
	'posts_per_page' => $limit,
	'paged' => $offset?$offset+1:1,
	'post_type' => 'channels',
	'tax_query' => array(
		'relation' => 'AND'
	)
);

if(! empty($_GET['s'])){
	$channel_args['s'] = $_GET['s'];
}

if(! empty($_GET['style'])){
	$channel_args['tax_query'][] = array(
									'taxonomy' => 'style',
									'field'    => 'term_id',
									'terms'    => array( $_GET['style'] ),
									);
}

if(! empty($_GET['topic'])){
	$channel_args['tax_query'][] = array(
									'taxonomy' => 'topic',
									'field'    => 'term_id',
									'terms'    => array( $_GET['topic'] ),
									);
}

if(! empty($_GET['rand'])){
	$channel_args['order'] = 'rand';
}

$channels = get_posts($channel_args);

if(! empty($channels)){
	foreach($channels as $key => $channel){

		$channel->img_url = get_the_post_thumbnail_url($channel->ID,'large'); 
		$channel->meta = get_fields($channel->ID); 

		$video_args = array(
			'posts_per_page' => $limit,
			'post_type' => 'videos',
			'orderby' => 'date',
			'order'   => 'DESC',
			'meta_key' => 'channel',
			'meta_value' => $channel->ID
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

		$channels[$key]->videos = $videos;
	}
}

echo json_encode($channels);
exit;





// $search_query = "SELECT * FROM {$wpdb->channels} AS C ";

// if(! empty($_GET['style'])){
// 	$search_query .= " LEFT JOIN {$wpdb->channel_styles} AS CS ON CS.channel_id = C.channel_id ";
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= " LEFT JOIN {$wpdb->channel_topics} AS CT ON CT.channel_id = C.channel_id ";
// }

// $search_query .= " WHERE 1=1 ";

// if(! empty($_GET['s'])){
// 	$search_query .= $wpdb->prepare("AND title LIKE %s ", '%'.$_GET['s'].'%');
// }

// if(! empty($_GET['style'])){
// 	$search_query .= $wpdb->prepare(" AND CS.style_id = %d ", $_GET['style']);
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= $wpdb->prepare(" AND CT.topic_id = %d ", $_GET['topic']);
// }

// if(! empty($_GET['rand'])){
// 	$search_query .= " ORDER BY RAND()";
// }

// $search_query .= $wpdb->prepare("LIMIT %d, %d", $offset, $limit);

// $channels = $wpdb->get_results($search_query);

// print_r($wpdb->last_error);
// print_r($wpdb->last_query);


// if(! empty($channels)){
// 	foreach($channels as $key => &$channel){
// 		$channels[$key]->videos = $wpdb->get_results("SELECT * FROM {$wpdb->videos} WHERE channel_id = {$channel->channel_id} LIMIT {$DEFAULT_VID_LIMIT}");
// 	}
// }

// echo json_encode($channels);
// exit;