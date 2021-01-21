/**
 * Controls the channel sliders
 * 
 * TODO: Possibly setup a resize event so videos / channel doesn't get lost
 * TODO: UI inform user has reached the end of the channel list
 */
jQuery(function($){
	var $channels = $('#channels');
	var sliderSize = 340;
	var xDown = null;
	var yDown = null;
	var moveLeft = false;
	var moveRight = false;

	// Control Slider
	$channels.on('click', '.channel .channel-control', function(e){
		e.preventDefault();

		var $parentChannel = $(this).parents('.channel');
		
		if($(this).hasClass('next')){
			moveChannel(true, $parentChannel);
		}else{
			moveChannel(false, $parentChannel);
		}
	});

	// Listen for touch events
	$channels.on('touchstart', '.channel-wrap', handleTouchStart);
	$channels.on('touchmove', '.channel-wrap', handleTouchMove);//handleTouchMove
	$channels.on('touchend', '.channel-wrap', handleTouchEnd);

	// Move a channel X pixels
	function moveChannel(next, $channel){

		var $videos = $channel.find('.video');
		var translate = $channel.data('translate');
		var videosOnScreen = $channel.width() / sliderSize;
		var videosToShow = Math.floor(videosOnScreen)-1;

		// Figure out how big our slide holder needs to be to contain all videos.
		// This may not be needed, depending on code used during video loading
		if($videos){
			var maxWidth = $videos.length * sliderSize;
		}else{
			var maxWidth = 0;
		}
		
		if(! translate){
			translate = 0;
		}

		// Direction
		if(next){
			translate -= sliderSize;
		}else{
			translate += sliderSize;
		}

		// This is not an infinite slider. Only move to the right, which means negative translate
		if( ( translate < sliderSize && Math.abs(translate) < maxWidth - sliderSize * videosToShow )
		|| (! next && Math.abs(translate) > sliderSize) ){

			// We are moving the channel wrap and updating the width in case a video has been added
			$channel.find('.channel-wrap')
			.css('transform', 'translate3d('+translate+'px, 0px, 0px)');
			//.css('width', maxWidth+'px');

			$channel.data('translate', translate);
		}

	}

	// Get the best source of touch events
	function getTouches(evt) {
		return evt.touches || // browser API
			evt.originalEvent.touches; // jQuery
	}

	// Detect the initial touch event
	function handleTouchStart(evt) {
		const firstTouch = getTouches(evt)[0];
		xDown = firstTouch.clientX;
		yDown = firstTouch.clientY;
	};

	// Move channel if touch end occured and a move made
	function handleTouchEnd(evt) {
		
		// Direction
		if(moveLeft){
			var $parentChannel = $(this).parents('.channel');
			moveChannel(true, $parentChannel);
		}else if(moveRight){
			var $parentChannel = $(this).parents('.channel');
			moveChannel(false, $parentChannel);
		}

		xDown = null;
		yDown = null;
		moveLeft = false;
		moveRight = false;
	};

	// Track a user as they move / drag their touch event accross a channel
	function handleTouchMove(evt) {
		if ( ! xDown || ! yDown ) {
			return;
		}

		var distance = 30;

		var xUp = evt.touches[0].clientX;
		var yUp = evt.touches[0].clientY;

		var xDiff = xDown - xUp;
		var yDiff = yDown - yUp;

		if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) { /*most significant*/
			
			if ( xDiff > distance ) {
				moveLeft = true;
				moveRight = false;
			} else if(xDiff < -distance){ 
				moveRight = true;
				moveLeft = false;
			}else{
				moveLeft = false;
				moveRight = false;
			}

			// var $parentChannel = $(this).parents('.channel');
			// var translate = $parentChannel.data('translate');
			// var moveSpeed = 10;

			// if(! translate){
			// 	translate = 0;
			// }

			// if ( xDiff > 0 ) {
			// 	translate -= moveSpeed;
			// } else {
			// 	translate += moveSpeed;
			// }

			// moveChannel(translate, $parentChannel);
		} else {
			if ( yDiff > 0 ) {
				/* up swipe */ 
			} else { 
				/* down swipe */
			}

			moveLeft = false;
			moveRight = false;
		}

		/* reset values */
		// xDown = null;
		// yDown = null;
	};

});
