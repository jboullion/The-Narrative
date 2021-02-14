<template>
	<div v-if="video.youtube_id" class="card video yt-video">
		<router-link :to="'/video/'+ video.youtube_id" class="card-link" >
			<div class="card-img-back">
				<img loading="lazy" width="320" height="180" 
				:src="'https://img.youtube.com/vi/'+video.youtube_id+'/mqdefault.jpg'" 
				class="lazyload"
				:alt="video.post_title">
			<!-- <i class="fas fa-play-circle"></i> -->
			</div>
		</router-link>
		<div class="card-body">
			<p class="ellipsis">{{ video.post_title }}</p>
			<router-link :to="'/channel/'+video.channel_youtube" v-if="showChannel">
				<span class="channel">{{ video.channel_title }}</span>
			</router-link>
			<span class="date watched" v-if="watchedDate">Watched: {{ watchedDate }}</span>
			<span class="date watched" v-else-if="likedDate">Liked: {{ likedDate }}</span>
			<span class="date" v-else>{{ videoDate }}</span>
		</div>
	</div>
</template>

<script>
// 'https://www.youtube.com/channel/'+video.channel_youtube
// :src="'https://img.youtube.com/vi/'+ video.youtube_id+'/sddefault.jpg'"
import moment from 'moment'

export default {
	props: ['video', 'showChannel'],
	data() {
		return {
			videoDate: null,
			watchedDate: null,
			likedDate: null
		};
	},
	created(){
		//console.log(this.video.post_date);
		this.videoDate = moment(this.video.post_date).format('MMM D, YYYY');

		if(this.video.watchedDate){
			this.watchedDate = moment(this.video.watchedDate).format('MMM D, YYYY'); // h:mm a
		}

		if(this.video.likedDate){
			this.likedDate = moment(this.video.likedDate).format('MMM D, YYYY'); //  h:mm a
		}
	},
	computed: {
		
	},
	methods: {
		updateVideo(){
			this.$store.dispatch('updateCurrentVideo', this.video.youtube_id);
		}
	}
}
</script>

<style scoped>
	.card.video {
		border: 0;
		background-color: transparent;
		box-shadow: none;
		display: flex;
		transition: background-color 0.1s;
		height: 100%;
	}

	.card.video:hover {
		text-decoration: none;
	}

	.card.video:hover .card-img-back i {
		opacity: 1;
	}

	.card-img-back {
		background-color: #eceeef;
		position: relative;
	}

	.card-img-back img {
		position: absolute;
		top: 0;
		left: 0;
	}

	.card-img-back i {
		border-radius: 50%;
		color: rgba(255,255,255,0.85);
		opacity: 0;
		box-shadow: 0px 0px 5px 3px rgba(0,0,0,0.25);
		transition: opacity 0.1s linear;
		font-size: 74px;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}

	.card-img-back i.fa-primary {
		color: #373737;
	}

	.card-body {
		height: 96px;
		padding: 10px;
		position: relative;
		color: #55595c;
		transition: color 0.2s linear;
	}

	.card-body p {
		font-weight: bold;
		margin-bottom: 4px;
	}

	.card-body span.channel {
		margin-bottom: 0;
		font-size: 14px;
	}

	.card-body span.date {
		position: absolute;
		bottom: 10px;
		left: 10px;
		font-size: 14px;
		transition: color 0.2s linear;
	}

	.darkmode .card-body span {
		color: #aaa;
	}
</style>