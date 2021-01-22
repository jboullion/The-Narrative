<?php 
	$fields = jb_get('fields');
	// $twitter = get_field('twitter', $channel->ID);
	// $patreon = get_field('patreon', $channel->ID);
	// $website = get_field('website', $channel->ID);
	// $channel_id = get_field('channel_id', $channel->ID);
	$channel_img = jb_get_yt_channel_img($channel->ID);

/*
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

		echo '	</div>';