<?php 
	$options = jb_get('options');

	// &origin=<?php echo home_url(); ?>
?>
<script id="yt-tempate" type="text/template">
	<div id="yt-modal" class="opened" role="dialog" aria-label="YouTube Player Window" tabindex="-1" aria-hidden="false">
		<div class="yt-wrap" role="document">
			<div class="yt-container">
				<div class="yt-content">
					<div class="yt-video-wrapper">
						<iframe id="yt-player" type="text/html" src="http://www.youtube.com/embed/<%videoID%>?enablejsapi=1" frameborder="0" allow="fullscreen"></iframe>
					</div>
				</div>
				<button id="yt-minimize" class="yt-control" type="button" aria-label="Minimize" ><?php echo fa_minimize(); ?></button>
				<button id="yt-maximize" class="yt-control" type="button" aria-label="Maximize" ><?php echo fa_expand(); ?></button>
				<button id="yt-close" class="yt-control" type="button" aria-label="Close" ><?php echo fa_close(); ?></button>
			</div>
		</div>
	</div>
</script>
<script>
	jQuery(function($){
		var $body = $('body');
		var ytTemplate = $('#yt-tempate').html();
		var isPlaying = false;
		var player;

		$body.on('click', '#yt-close, .yt-wrap', function(e){
			$('#yt-modal').remove();

			isPlaying = false;
		});

		$body.on('click', '#yt-minimize', function(e){
			e.stopPropagation();
			e.preventDefault();

			$(this).hide();
			$('#yt-maximize').show();
			$('#yt-modal').addClass('minimized');
		});

		$body.on('click', '#yt-maximize', function(e){
			e.stopPropagation();
			e.preventDefault();

			$(this).hide();
			$('#yt-minimize').show();
			$('#yt-modal').removeClass('minimized');
		});

		$('.yt-video').on('click', function(e){
			e.stopPropagation();
			e.preventDefault();

			var videoID = $(this).data('id');

			if(isPlaying){
				player.loadVideoById(videoID);
			}else{
				var newYTPlayer = jbTemplateEngine(ytTemplate, {
					videoID: videoID,
				});
				
				$body.append(newYTPlayer);

				player = new YT.Player('yt-player');
			}
			
			isPlaying = true;
			
		});
	});
</script>