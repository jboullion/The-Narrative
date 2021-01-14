/**
 * Controls our YouTube player
 */
jQuery(function($){
	var $body = $('body');
	var ytTemplate = $('#yt-tempate').html();
	var isPlaying = false;
	var player;

	// Cllose Player
	$body.on('click', '#yt-close, .yt-wrap', function(e){
		$('#yt-modal').remove();

		isPlaying = false;
	});

	// Minimize Player
	$body.on('click', '#yt-minimize', function(e){
		e.stopPropagation();
		e.preventDefault();

		$(this).hide();
		$('#yt-maximize').show();
		$('#yt-modal').addClass('minimized');
	});

	// Maximize Player
	$body.on('click', '#yt-maximize', function(e){
		e.stopPropagation();
		e.preventDefault();

		$(this).hide();
		$('#yt-minimize').show();
		$('#yt-modal').removeClass('minimized');
	});

	// Play a video
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