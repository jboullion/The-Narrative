<?php 

require_once('../api-setup.php');

$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;

$search_query = "SELECT * FROM {$wpdb->channels} AS C ";

if(! empty($_GET['style'])){
	$search_query .= " LEFT JOIN {$wpdb->channel_styles} AS CS ON CS.channel_id = C.channel_id ";
}

if(! empty($_GET['topic'])){
	$search_query .= " LEFT JOIN {$wpdb->channel_topics} AS CT ON CT.channel_id = C.channel_id ";
}

$search_query .= " WHERE 1=1 ";

if(! empty($_GET['s'])){
	$search_query .= $wpdb->prepare("AND title LIKE %s ", '%'.$_GET['s'].'%');
}

if(! empty($_GET['style'])){
	$search_query .= $wpdb->prepare(" AND CS.style_id = %d ", $_GET['style']);
}

if(! empty($_GET['topic'])){
	$search_query .= $wpdb->prepare(" AND CT.topic_id = %d ", $_GET['topic']);
}

if(! empty($_GET['rand'])){
	$search_query .= " ORDER BY RAND()";
}

$search_query .= $wpdb->prepare("LIMIT %d, %d", $offset, $limit);

$channels = $wpdb->get_results($search_query);

// print_r($wpdb->last_error);
// print_r($wpdb->last_query);

$channels->videos = [];
if(! empty($channels)){
	foreach($channels as $key => &$channel){
		$channels[$key]->videos = $wpdb->get_results("SELECT * FROM {$wpdb->videos} WHERE channel_id = {$channel->channel_id} LIMIT {$DEFAULT_VID_LIMIT}");
	}
}

echo json_encode($channels);
exit;