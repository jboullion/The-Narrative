<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$channel_videos = jb_get_yt_channel_videos($fields['channel_id'], $post->ID);

	if(empty($channel_videos)) return;
?>
<section id="channels" class="wrapper no-print">
	<div class="container-fluid">
		<div class="row">
		<?php 
			foreach($channel_videos as $vkey => $video){
				echo '<div class="col-sm-6 col-lg-4 col-xl-3">';
				echo jb_get_video_card($video);
				echo '</div>';
			}
		?>
		</div>
	</div>
</section>
