<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$channel_args = array(
		'post_type' => 'channels',
		'orderby' => 'rand',
		'posts_per_page' => get_option( 'posts_per_page' ),
	);

	$channels = get_posts($channel_args);
?>
<script>
	var sliderOptions = {
		nav: false,
		loop: false,
		swipeAngle: false,
		gutter: 5,
		controlsText: ["&lsaquo;", "&rsaquo;"],
		responsive: {
			640: {
				items: 2
			},
			900: {
				items: 3
			},
			1200: {
				items: 4
			},
			1500: {
				items: 5
			},
			
		}
	};
</script>
<section id="channels" class="wrapper no-print">
	<div class="container-fluid">
		<?php 
			if(! empty($channels)){
				foreach($channels as $channel_key => $channel){
					// TODO: Make the "title card" a function
					$channel_id = get_field('channel_id', $channel->ID);
					$channel_info = jb_get_yt_channel_info($channel_id, $channel->ID);
					$channel_videos = jb_get_yt_channel_videos($channel_id, $channel->ID);
					
					// '.apply_filters('the_content', $channel->post_content).'
					if( ! empty($channel_info->items[0]) && ! empty($channel_videos->items)){
						echo '<div class="channel row">
							<div class="col-lg-3">
								<div class="title-card">
									<a href="https://www.youtube.com/channel/'.$channel_id.'" target="_blank"><img src="'.$channel_info->items[0]->snippet->thumbnails->default->url.'" /></a>
									<h4>'.$channel->post_title.'</h4>
								</div>
							</div>
							<div class="col-lg-9">
								<div class="channel-'.$channel_key.'">';
						
						foreach($channel_videos->items as $video){
							// TODO: Should we move this information into the display video function?
							if(empty($video->id->videoId)) continue;

							$video_id = $video->id->videoId;
							$title = $video->snippet->title;
							$description = $video->snippet->description;
							$date = date('F j, Y', strtotime($video->snippet->publishTime));

							echo jb_display_video_card($video_id, $title, $date);

						}

						echo '	</div>
							</div>
						</div>';

						?>
						<script>
							// TODO: May want to remove built in nav and use custom navs
							//slider.goTo('prev');
							//slider.goTo('next');

							sliderOptions.container = '.channel-<?php echo $channel_key; ?>';

							var slider<?php echo $channel_key; ?> = tns(sliderOptions);
						</script>
						<?php 
					}

					
					//break;
				}
			}
		?>
	</div>
</section>
