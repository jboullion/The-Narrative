<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	// Should we use the cached version of this channel's info?
	if(is_tax( 'genre' )){
		$genre_tax = get_queried_object();
		$featured_cache = get_transient( 'genre_'.$genre_tax->term_id );
	}else{
		$featured_cache = get_transient( 'featured_channels' );
	}
	
	if(! empty($featured_cache)) {
		$channels = $featured_cache;
	}else{
		$args = array(
			'posts_per_page' => 5,
			'post_type' => 'channels',
			'orderby' => 'rand'
		);

		if(! empty($genre_tax)){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'genre',
					'field'    => 'term_id',
					'terms'    => $genre_tax->term_id,
				)
			);
		}

		$channels = get_posts($args);

		if(! empty($genre_tax)){
			set_transient( 'genre_'.$genre_tax->term_id, $channels, DAY_IN_SECONDS );
		}else{
			set_transient( 'featured_channels', $channels, DAY_IN_SECONDS );
		}
		
	}

?>
<section id="featured" class="wrapper no-print">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<a href="#" class="featured-control prev"><?php echo fa_chevron_left(); ?></a>
				<a href="#" class="featured-control next"><?php echo fa_chevron_right(); ?></a>
				<div class="featured-slider">

				<?php 
					if(! empty($channels)){
						foreach($channels as $chkey => $channel){
							$twitter = get_field('twitter', $channel->ID);
							$patreon = get_field('patreon', $channel->ID);
							$website = get_field('website', $channel->ID);
							
							$channel_id = get_field('channel_id', $channel->ID);
							$channel_info = jb_get_yt_channel_info($channel_id, $channel->ID);
							$channel_videos = jb_get_yt_channel_videos($channel_id, $channel->ID);

							if(! empty($channel_videos->items)){
								$featured_video = $channel_videos->items[0];
								$video_title = $featured_video->snippet->title;
								$video_desc = $featured_video->snippet->description;
								$video_id = $featured_video->id->videoId;

								$video_img = jb_get_video_img_url($video_id, 'maxresdefault');

								if(empty($video_id)) continue;

								echo '<div class="featured-slide">
										<div class="row">
											<div class="col-lg-9 col-md-12">
												<a href="#" class="yt-video" data-id="'.$video_id.'">
													<img src="'.$video_img.'" class="card-img-top" '.($chkey>0?'loading="lazy"':'').' alt="'.$title.'">
												</a>
											</div>
											<div class="col-lg-3 col-md-12">
												<div class="title-card">
												<a href="https://www.youtube.com/channel/'.$channel_id.'" target="_blank"><img src="'.$channel_info->items[0]->snippet->thumbnails->default->url.'" /></a>
													<h4>'.$channel->post_title.'</h4>
													<p>'.$video_desc.'</p>';
								
								if($patreon){
									echo '<a href="'.$patreon.'" class="channel-social patreon" target="_blank">'.fa_patreon_icon().'</a>';
								}
								if($twitter){
									echo '<a href="'.$twitter.'" class="channel-social twitter" target="_blank">'.fa_twitter_icon().'</a>';
								}
								if($website){
									echo '<a href="'.$website.'" class="channel-social website" target="_blank">'.fa_globe_icon().'</a>';
								}

								echo '			</div>
											</div>
										</div>
									</div>';
							}
						}
					}
				?>
				</div>
			</div>
		</div>
	</div>
</section>