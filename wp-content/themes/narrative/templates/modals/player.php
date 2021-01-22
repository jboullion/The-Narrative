<?php 
	$options = jb_get('options');

	// &origin=<?php echo home_url();
?>
<script id="yt-tempate" type="text/template">
	<div id="yt-modal" class="opened" role="dialog" aria-label="YouTube Player Window" tabindex="-1" aria-hidden="false">
		<div class="yt-wrap" role="document">
			<div class="yt-container">
				<div class="yt-content">
					<div class="yt-video-wrapper">
						<iframe id="yt-player" type="text/html" src="http://www.youtube.com/embed/<%videoID%>?enablejsapi=1" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>
				<button id="yt-minimize" class="yt-control" type="button" aria-label="Minimize" ><?php echo fa_minimize(); ?></button>
				<button id="yt-maximize" class="yt-control" type="button" aria-label="Maximize" ><?php echo fa_expand(); ?></button>
				<button id="yt-close" class="yt-control" type="button" aria-label="Close" ><?php echo fa_close(); ?></button>
			</div>
		</div>
	</div>
</script>