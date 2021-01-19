<?php 

require_once('api-setup.php');

if(empty($_POST['channel_id']) 
|| empty($_POST['channel_post_id'])) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$channel_videos = $wpdb->get_var($wpdb->prepare("SELECT meta_value AS videos FROM {$wpdb->postmeta} WHERE meta_key = 'cached_video_list' AND post_id = %d", $_POST['channel_post_id']));

$channel_HTML = '';
if(! empty($channel_videos)){
	$channel_videos = json_decode($channel_videos);

	foreach($channel_videos as $vkey => $video){
		if(empty($video->id->videoId)) continue;

		//if($vkey > 4) break;

		$channel_HTML .= jb_get_video_card($video);

	}
}

return $channel_HTML;


/**
 * Display a video card found around the site
 * 
 * @param object $video The video post object
 */
function jb_get_video_card($video) { 
	$video_id = $video->id->videoId;
	$title = $video->snippet->title;
	$description = $video->snippet->description;
	$date = date('F j, Y', strtotime($video->snippet->publishTime));
	
	$video_img = jb_get_video_img_url($video_id);

	return '<a href="#" data-id="'.$video_id.'" class="card video h-100 yt-video">
			<div class="card-img-back" >
				<img src="'.$video_img.'" loading="lazy" width="320" height="180" />
				'.fa_play().'
			</div>
			<div class="card-body">
				<p class="ellipsis">'.$title.'</p>
				<span class="date">'.$date.'</span>
			</div>
		</a>';
}