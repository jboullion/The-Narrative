<?php 
	$fields = sp_get('fields');
	$options = sp_get('options');

?>
<section id="channels" class="wrapper no-print">
	<div class="container-fluid">
		<div class="channel row">
			<div class="col-lg-3">
				<div class="title-card">
					<img src="https://yt3.ggpht.com/ytc/AAUvwniXNmPnZ3ngeNhVvkYCsugH81w4E1OxtTuX_A5nbg=s88-c-k-c0x00ffffff-no-rj" />
					<h4>Lex Friedman</h4>
					<p>Lex talks about life and stuff</p>
				</div>
			</div>
			<div class="col-lg-9">
				<div class="channel-1">
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
					<?php sp_display_video_card('8Kh9HoCsmrw', 'Consciousness may emerge from neural networks | Manolis Kellis and Lex Fridman'); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	var sliderOptions = {
		container: '.channel-1',
		nav: false,
		loop: false,
		swipeAngle: false,
		gutter: 15,
		controlsText: ["&lsaquo;", "&rsaquo;"],
		responsive: {
			640: {
				items: 2
			},
			900: {
				items: 3
			},
			1100: {
				items: 4
			},
			
		}
	};

	var slider1 = tns(sliderOptions);

	sliderOptions.container = '.channel-2';
	var slider2 = tns(sliderOptions);

	sliderOptions.container = '.channel-3';
	var slider3 = tns(sliderOptions);
</script>