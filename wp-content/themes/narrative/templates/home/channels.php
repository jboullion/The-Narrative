<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$channel_args = array(
		'posts_per_page' => 3,
		'post_type' => 'channels',
		'orderby' => 'rand',
		//'posts_per_page' => get_option( 'posts_per_page' ),
	);

	if(is_tax( 'genre' )){
		$genre_tax = get_queried_object();

		if(! empty($genre_tax)){
			$channel_args['tax_query'] = array(
				array(
					'taxonomy' => 'genre',
					'field'    => 'term_id',
					'terms'    => $genre_tax->term_id,
				)
			);
		}
	}

	$channels = get_posts($channel_args);

?>

<section id="channels" class="wrapper no-print">
	<div class="container-fluid">
		<?php 
			if(! empty($channels)){
				foreach($channels as $channel_key => $channel){
					// TODO: Make the "title card" a function
					$twitter = get_field('twitter', $channel->ID);
					$patreon = get_field('patreon', $channel->ID);
					$website = get_field('website', $channel->ID);
					$channel_id = get_field('channel_id', $channel->ID);
					$channel_info = jb_get_yt_channel_info($channel_id, $channel->ID);
					$channel_videos = jb_get_yt_channel_videos($channel_id, $channel->ID);

					// '.apply_filters('the_content', $channel->post_content).'
					if( ! empty($channel_info->items[0]) && ! empty($channel_videos->items)){
						echo '<div class="channel row">
							<div class="col-lg-3">
								<div class="title-card">
									<a href="https://www.youtube.com/channel/'.$channel_id.'" target="_blank"><img src="'.$channel_info->items[0]->snippet->thumbnails->default->url.'" /></a>
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
						
						echo '	</div>
								<a href="#" id="channel-'.$channel_key.'-prev" class="channel-control prev">'.fa_chevron_left().'</a>
								<a href="#" id="channel-'.$channel_key.'-next" class="channel-control next">'.fa_chevron_right().'</a>
							</div>
							<div class="col-lg-9">
								<div class="channel-'.$channel_key.' channel-overflow">
									<div class="channel-wrap" style="width: '.(count($channel_videos->items)*340).'px;">';
						
						foreach($channel_videos->items as $vkey => $video){
							// TODO: Should we move this information into the display video function?
							if(empty($video->id->videoId)) continue;

							//if($vkey > 4) break;

							$video_id = $video->id->videoId;
							$title = $video->snippet->title;
							$description = $video->snippet->description;
							$date = date('F j, Y', strtotime($video->snippet->publishTime));

							echo jb_display_video_card($video_id, $title, $date);

						}

						echo '		</div>
								</div>
							</div>
						</div>';

?>
<script>
	// sliderOptions.container = '.channel-<?php echo $channel_key; ?>';

	// var slider<?php echo $channel_key; ?> = tns(sliderOptions);

	// jQuery('#channel-<?php echo $channel_key; ?>-prev').click(function(e){
	// 	e.preventDefault();
	// 	slider<?php echo $channel_key; ?>.goTo('prev');
	// });
	
	// jQuery('#channel-<?php echo $channel_key; ?>-next').click(function(e){
	// 	e.preventDefault();
	// 	slider<?php echo $channel_key; ?>.goTo('next');
	// });
</script>
<?php 
					}

					//break;
				}
			}
		?>
	</div>
</section>
