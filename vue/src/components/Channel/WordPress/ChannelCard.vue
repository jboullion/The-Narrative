<template>
	<div v-if="videos && videos.length > 0" class="channel">
		<div class="title-card">
			<ChannelInfo :channel="channel" />
			<div class="channel-controls">
				<a class="channel-control prev" @click.prevent="moveChannel(false)">
					<i class="fas fa-chevron-left"></i>
				</a>
				<a class="channel-control next" @click.prevent="moveChannel(true)">
					<i class="fas fa-chevron-right"></i>
				</a>
			</div>
		</div>

		<!-- <VideoList  :videos="videos" /> -->
		<div class="video-list" ref="videoList">
			<div id="video-wrap" 
				
				:style="{ transform: 'translate3d('+moveTranslate+'px, 0px, 0px)', width: width + 'px' }"
				@touchmove="handleTouchMove"
				@touchstart="handleTouchStart"
				@touchend="handleTouchEnd" >
				<VideoCard v-for="video in videos" :key="video.video_id" :video="video" />
			</div>
		</div>
	</div>
</template>

<script>
import ChannelInfo from './ChannelInfo';
// import VideoList from '../Video/VideoList';
import VideoCard from '../Video/VideoCard';

export default {
	inject: [], // 'channels',
	props: ['channel'],
	components: {
		ChannelInfo,
		//VideoList,
		VideoCard
	},
	data() {
		return {
			videos: [],
			videoPage: 1,
			videosLoading: false,
			xDown: false,
			yDown: false,
			sliderSize: 340,
			moveLeft: false,
			moveRight: false,
			translate: 0,
			moveTranslate: 0,
			width: 6800,
			maxWidth: 6800,
			$videoWrap: null
		};
	},
	created(){
		//this.loadVideos();
		//console.log(this.channel);
		this.videos = this.channel.videos;
		this.width = this.videos?(this.videos.length * this.sliderSize):0;
	},
	methods: {
		// loadVideos(){
		// 	//var limit = 10;

		// 	this.videosLoading = true;

		// 	fetch(process.env.VUE_APP_URL+'api/channel/videoList.php?channel_id='+this.channel.channel_id+'&offset='+this.videoPage, {
		// 		//mode: 'no-cors',
		// 		method: 'GET',
		// 		headers: { 'Content-Type': 'application/json' }
		// 	})
		// 	.then(response => {
		// 		if(response.ok){
		// 			this.videoPage++;
		// 			return response.json();
		// 		}
		// 	})
		// 	.then(data => {
		// 		this.videosLoading = false;
				
		// 		this.videos = this.videos.concat(data);

		// 	})
		// 	.catch(error => {
		// 		//this.errorMessage = error;
		// 		this.videosLoading = false;
		// 		console.error('There was an error!', error);
		// 	});
		// },
		getTouches(evt) {
			return evt.touches || // browser API
				evt.originalEvent.touches; // jQuery
		},
		handleTouchStart(evt) {
			const firstTouch = this.getTouches(evt)[0];
			this.xDown = firstTouch.clientX;
			this.yDown = firstTouch.clientY;
		},
		handleTouchEnd() {
			// Direction
			if(this.moveLeft){
				this.moveChannel(true);
			}else if(this.moveRight){
				this.moveChannel(false);
			}

			this.xDown = null;
			this.yDown = null;
			this.moveLeft = false;
			this.moveRight = false;
		},
		handleTouchMove(evt) {
			if ( ! this.xDown || ! this.yDown ) {
				return;
			}

			var distance = 30;

			var xUp = evt.touches[0].clientX;
			var yUp = evt.touches[0].clientY;

			var xDiff = this.xDown - xUp;
			var yDiff = this.yDown - yUp;

			if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) { /*most significant*/

				if ( xDiff > distance ) {
					this.moveLeft = true;
					this.moveRight = false;
				} else if(xDiff < -distance){ 
					this.moveRight = true;
					this.moveLeft = false;
				}else{
					this.moveLeft = false;
					this.moveRight = false;
				}

			} else {
				this.moveLeft = false;
				this.moveRight = false;
			}

		},
		moveChannel(left) {

			let videosOnScreen = this.$refs.videoList.clientWidth / this.sliderSize;
			let videosToShow = Math.floor(videosOnScreen);
			let maxTranslate = this.maxWidth - this.sliderSize * videosToShow;

			// Figure out how big our slide holder needs to be to contain all videos.
			if(this.videos && this.videos.length){
				this.maxWidth = this.videos.length * this.sliderSize;
			}

			// Direction
			if(left){
				this.translate -= this.sliderSize;
			}else{
				this.translate += this.sliderSize;
			}

			if(this.translate > 0){
				this.translate = 0;
			}else if(Math.abs(this.translate) > maxTranslate ){
				this.translate = -maxTranslate;
			}

			this.moveTranslate = this.translate;

		}
	},
	watch: {
		channel: function() { 
			this.videos = this.channel.videos;
			this.width = this.videos?(this.videos.length * this.sliderSize):0;
		}
	}
}
</script>

<style>
	.channel {
		/* border-bottom: 1px solid #f7f7f9; */
		padding-bottom: 20px;
		margin-bottom: 20px;
		transition: border-color 0.2s;
	}

	.title-card {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.video-list .card.video {
		width: 320px;
	}

	.video-list .card-img-back {
		width: 320px;
		height: 180px;
	}

	.video-list {
		overflow: hidden;
		white-space: nowrap;
	}

	.video-list .card {
		margin-right: 20px;
	}

	.video-list .card:last-child {
		margin: 0;
	}

	#video-wrap {
		display: flex;
		transition: transform 0.2s ease-out;
	}

	.channel-control {
		cursor: pointer;
		display: inline-block;
		padding: 10px;
		margin: 0 10px;
		z-index: 1;
		width: 40px;
		top: 40%;
		text-align: center;
	}

	.channel-control.prev {
		left: 0;
	}

	.channel-control.next {
		right: 0;
	}

	.channel-control i {
		font-size: 24px;
		transition: all 0.2s linear;
		color: black;
	}


	@media (max-width: 768px) {
		.channel-control {
			display: none;
		}
	}
</style>