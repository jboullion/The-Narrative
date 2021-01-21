/**
 * Controls the channel sliders
 */
jQuery(function($){
	var $channels = $('#channels');

	// Control Slider
	$channels.on('click', '.channel .channel-control', function(e){
		e.preventDefault();

		var $parentChannel = $(this).parents('.channel');
		var translate = $parentChannel.data('translate');
		var sliderSize = 320;

		if(! translate){
			translate = 0;
		}

		// Direction
		if($(this).hasClass('next')){
			translate -= sliderSize;
		}else{
			translate += sliderSize;
		}

		// This is not an infinite slider. Only move to the right, which means negative translate
		if(translate < sliderSize){
			$parentChannel.find('.channel-wrap').css('transform', 'translate3d('+translate+'px, 0px, 0px)');
			$parentChannel.data('translate', translate);
		}
	});


});
