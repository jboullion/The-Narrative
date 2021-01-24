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
function jb_get_video_card($video) { 
	$video_img = jb_get_video_img_url($video->video_id);

	return '<a href="#" data-id="'.$video->video_id.'" class="card video h-100 yt-video">
			<div class="card-img-back" >
				<img data-src="'.$video_img.'" loading="lazy" class="lazy" width="320" height="180" />
				'.fa_play().'
			</div>
			<div class="card-body">
				<p class="ellipsis">'.$video->title.'</p>
				<span class="date">'.$video->date.'</span>
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
			echo jb_get_video_card($video);
			echo '</div>';
		}
	}

	echo '	</div>
		</div>
	</div>';
}



/**
 * Display a channel
 *
 * @param object $channel The Channel $post object for the channel to display
 * @param int $max_videos The maximum number of videos to show on the slider (Server Side)
 * @return void
 */
function pk_display_channel($channel, $max_videos = 8){
	// TODO: Make the "title card" a function
	$twitter = get_field('twitter', $channel->ID);
	$patreon = get_field('patreon', $channel->ID);
	$website = get_field('website', $channel->ID);
	$channel_id = get_field('channel_id', $channel->ID);
	$channel_img = jb_get_yt_channel_img($channel->ID);
	$channel_videos = jb_get_yt_channel_videos($channel_id, $channel->ID);

	// '.apply_filters('the_content', $channel->post_content).'
	if( ! empty($channel_img) 
	&& ! empty($channel_videos)){
		
		echo '<div class="channel" data-id="'.$channel_id.'">
				<div class="title-card">
					<a href="https://www.youtube.com/channel/'.$channel_id.'" target="_blank"><img src="'.$channel_img.'" /></a>
					<h4>'.$channel->post_title.'</h4>';

				if($patreon){
					echo '<a href="'.$patreon.'" class="channel-social patreon" target="_blank">'.fa_patreon_icon().'</a>';
				}
				if($twitter){
					echo '<a href="'.$twitter.'" class="channel-social twitter" target="_blank">'.fa_twitter_icon().'</a>';
				}
				if($website){
					echo '<a href="'.$website.'" class="channel-social website" target="_blank">'.fa_globe_icon().'</a>';
				}

		echo '		<a href="#" id="channel-'.$channel->ID.'-prev" class="channel-control prev">'.fa_chevron_left().'</a>
					<a href="#" id="channel-'.$channel->ID.'-next" class="channel-control next">'.fa_chevron_right().'</a>
				</div>
				<div class="channel-'.$channel->ID.' channel-overflow">
					<div class="channel-wrap" style="width: '.(count($channel_videos)*340).'px;">';
	
		foreach($channel_videos as $vkey => $video){
			if(empty($video->video_id)) continue;

			echo jb_get_video_card($video);

			if($vkey >= $max_videos){
				break;
			}
		}

		echo '		</div>
				</div>
			</div>';
	}
}

