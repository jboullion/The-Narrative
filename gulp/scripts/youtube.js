/**
 * Controls our YouTube player
 */
var isPlaying = false;
jQuery(function($){
	var $body = $('body');
	var ytTemplate = $('#yt-tempate').html();
	
	var player;

	// Close Player
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
			//history.pushState({}, '', 'playing');
		}else{
			var newYTPlayer = jbTemplateEngine(ytTemplate, {
				videoID: videoID,
			});
			
			$body.append(newYTPlayer);

			player = new YT.Player('yt-player', {
				videoId: videoID,
				events: {
					'onReady': onPlayerReady,
					//'onStateChange': onPlayerStateChange
				}
			});
			
		}
		
		isPlaying = true;
		
	});


	// Play the Loaded YouTube video onReady
	function onPlayerReady(event) {
		event.target.playVideo();
	}


	/*
	* this swallows backspace keys on any non-input element.
	* stops backspace -> back
	*/
	// var rx = /INPUT|SELECT|TEXTAREA/i;
	// $(document).bind("keydown keypress", function(e){
	// 	if( e.which == 8 ){ // 8 == backspace
	// 		if(!rx.test(e.target.tagName) || e.target.disabled || e.target.readOnly ){
	// 			e.preventDefault();
	// 			$('#yt-modal').remove();
	// 			isPlaying = false;
	// 		}
	// 	}
	// });
});
