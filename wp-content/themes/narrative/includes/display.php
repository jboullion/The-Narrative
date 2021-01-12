<?php 
/**
 * These functions are used for displaying components throughout the site.
 */

/**
 * Display a featured slide
 */
function jb_display_video_slide($video, $active = false){ //, $channel_id =''
	$video_id = get_field('youtube_id', $video->ID);
	$video_img = jb_get_video_img_url($video_id, 'maxresdefault');

	$channels = get_the_terms( $video->ID, 'channel' );
	if(! empty($channels)){
		$channel_name = $channels[0]->name;
		$channel_image = get_field('channel_image', 'channel_'.$channels[0]->term_id );
		$channel_img = '<img src="'.$channel_image['url'].'" class="mr-3" alt="'.$channel_name.'" width="50" height="50">';
	}else{
		$channel_name = '';
		$channel_img = '<div class="channel-default font-audiowide">S</div>';//  array('url' => 'https://via.placeholder.com/36/09f.png/fff');
	}

	echo '<div class="carousel-item '.($active?'active':'').'">
			<a href="//www.youtube.com/watch?v='.$video_id.'" class="card bg-dark text-white" data-lity>
				<img src="'.$video_img.'" class="card-img" alt="'.$video->post_title.'">
				<div class="card-img-overlay">
					<div class="media">
						'.$channel_img.'
						<div class="media-body">
							<h5 class="ellipsis">'.$video->post_title.'</h5>
							<h6 class="text-muted">'.$channel_name.'</h6>
						</div>
					</div>
				</div>
			</a>
		</div>';
}


/**
 * Display a video card found around the site
 * 
 * @param object $video The video post object
 */
function jb_display_video_card($video_id, $title, $date ){ 
	$video_img = jb_get_video_img_url($video_id);

	echo '<a href="#" data-id="'.$video_id.'" class="card video h-100 yt-video">
			<div class="card-img-back" >
				<img src="'.$video_img.'" loading="lazy" width="320" height="180" />
			</div>
			<div class="card-body">
				<p class="ellipsis">'.$title.'</p>
				<p class="small mb-0">'.$date.'</p>
			</div>
		</a>';
}


/**
 * Display a channel row
 */
function jb_display_channel_row($channel){
	$args = array(
		'post_type' => 'videos',
		'orderby' => 'date',
		'tax_query' => array(
			array(
				'taxonomy' => 'channel',
				'field'    => 'term_id',
				'terms'    => $channel->term_id,
			),
		),
	);

	$videos = get_posts($args);

	if(empty($videos)) return;

	echo '<div class="row channel">
			<div class="col-12">
				<legend>'.$channel->name.'</legend>
				<div class="row">';

	if(! empty($videos)){
		foreach($videos as $video){
			echo '<div class="col-sm-6 col-lg-3">';
			jb_display_video_card($video);
			echo '</div>';
		}
	}

	echo '	</div>
		</div>
	</div>';
}




