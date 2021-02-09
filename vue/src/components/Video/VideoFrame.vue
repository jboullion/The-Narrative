<template>
	<div class="yt-video-wrapper">
		<iframe id="yt-player" type="text/html" :src="'http://www.youtube.com/embed/'+video.youtube_id+'?enablejsapi=1'" frameborder="0" allowfullscreen></iframe>
	</div>
</template>


<script>
export default {
	props: ['video'],
	data() {
		return {
			// isPlaying: false,
			// player: null
		};
	},
	created(){

	},
	computed: {
		
	},
	methods: {
		// updatePlayer(){
		// 	if(this.isPlaying){
		// 		this.player.loadVideoById(video.youtube_id);
		// 		//history.pushState({}, '', 'playing');
		// 	}else{
		// 		// var newYTPlayer = jbTemplateEngine(ytTemplate, {
		// 		// 	videoID: videoID,
		// 		// });
				
		// 		//$body.append(newYTPlayer);

		// 		// script src="https://www.youtube.com/iframe_api" 
		// 		this.player = new YT.Player('yt-player', {
		// 			videoId: video.youtube_id,
		// 			events: {
		// 				'onReady': this.onPlayerReady,
		// 				//'onStateChange': onPlayerStateChange
		// 			}
		// 		});
				
		// 	}
			
		// 	isPlaying = true;
		// },
		// onPlayerReady(event) {
		// 	event.target.playVideo();
		// }

	}
}
</script>

<style scoped>
	.yt-video-wrapper {
		margin-top: 15px;
		width: 100%;
		padding-top: 56.25%;
		/* padding-top: 50%; */
		position: relative;
	}

	iframe {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
	}

	@media (max-width: 1199px) {
		.yt-video-wrapper {
			margin-top: 0;
		}
	}
</style>