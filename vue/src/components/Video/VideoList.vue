<template>
	<div class="video-list">
		<div id="video-wrap" 
			:style="{ transform: 'translate3d('+moveTranslate+'px, 0px, 0px)', width: width + 'px' }"
			@touchmove="handleTouchMove"
			@touchstart="handleTouchStart"
			@touchend="handleTouchEnd" >
			<VideoCard v-for="video in videos" :key="video.video_id" :video="video" />
		</div>
	</div>
</template>

<script>
import VideoCard from './VideoCard';

export default {
	props: ['videos'],
	components: {
		VideoCard
	},
	data() {
		return {
			xDown: false,
			yDown: false,
			sliderSize: 340,
			moveLeft: false,
			moveRight: false,
			translate: 0,
			moveTranslate: 0,
			width: 6800,
			$videoWrap: null
		};
	},
	mounted(){
		// this.$videoWrap = document.getElementById('video-wrap');
		// this.$videoWrap.addEventListener('touchmove', this.handleTouchMove, {passive: true})
		// this.$videoWrap.addEventListener('touchstart', this.handleTouchStart, {passive: true})
		// this.$videoWrap.addEventListener('touchend', this.handleTouchEnd, {passive: true})
		//this.$videoWrap.style.width = (this.videos.length * this.sliderSize)+"px";
		this.width = (this.videos.length * this.sliderSize);
	},
	methods: {
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
			// console.log('handleTouchMove');
			// console.log(evt);
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
		moveChannel(left){

			let videosOnScreen = this.width / this.sliderSize;
			let videosToShow = Math.floor(videosOnScreen)-1;
			let maxWidth = 0;

			// Figure out how big our slide holder needs to be to contain all videos.
			// This may not be needed, depending on code used during video loading
			if(this.videos.length){
				maxWidth = this.videos.length * this.sliderSize;
			}

			// Direction
			if(left){
				this.translate -= this.sliderSize;
			}else{
				this.translate += this.sliderSize;
			}

			// This is not an infinite slider. Only move to the right, which means negative translate
			if( ( this.translate < this.sliderSize && Math.abs(this.translate) <= maxWidth - this.sliderSize * videosToShow )
			|| (! left && Math.abs(this.translate) > this.sliderSize) ){
				this.moveTranslate = this.translate;
			}
		}

	},
}
</script>

<style scoped>
	.video-list {
		overflow: hidden;
		white-space: nowrap;
	}

	#video-wrap {
		display: flex;
		transition: transform 0.2s ease-out;
	}

	.card {
		margin-right: 20px;
	}

	.card:last-child {
		margin: 0;
	}
</style>