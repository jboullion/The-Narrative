<?php 

require_once('../api-setup.php');

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