<?php 
/**
 * Return simple / constent data or provide other "helper" type functionality
 */

/**
 * Display the last couple errors from WPDB
 */
function jb_wpdb_errors($wpdb){
	jb_print($wpdb->last_query);
	jb_print($wpdb->last_error);
}

/**
 * Convert the returned channel items into video arrays for saving
 *
 * @param array $items An array of channel_obj->items returned from youtube API
 * @return array An array of videos
 */
function jb_channel_items_to_videos($items){
	$videos = array();

	if($items){
		foreach($items as $item){
			$videos[] = array(
				'video_id' => $item->id->videoId,
				'title' => $item->snippet->title,
				'date' => date('F j, Y', strtotime($item->snippet->publishTime)),
			);
		}
	}

	return $videos;
}