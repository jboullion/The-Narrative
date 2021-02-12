<template>
	<div class="full-video row">
		<div class="col-xl-8">
			<VideoFrame :video="fullVideo" />
			<VideoInfo :video="fullVideo" />
			<ChannelInfo :channel="videoChannel" />
			<ChannelList :channel="videoChannel" :channelSearch="true" />
		</div>
		<keep-alive>
			<RelatedVideos :video="fullVideo" />
		</keep-alive>
	</div>
</template>

<script>
import moment from 'moment';

import ChannelInfo from '../Channel/ChannelInfo';
import ChannelList from '../Channel/ChannelList';
import VideoFrame from './VideoFrame';
import RelatedVideos from './RelatedVideos';
import VideoInfo from './VideoInfo';

export default {
	inject: [],
	components: {
		ChannelInfo,
		ChannelList,
		VideoFrame,
		RelatedVideos,
		VideoInfo
	},
	data() {
		return {
			isPlaying: false,
			hasLoaded: false,
			player: null,
			youtube_id: null,
			selectedVideo: null,
			channelLoading: false,
			videoChannel: {},
			videoLoading: false,
			fullVideo: {},
			scrolledToBottom: false
		};
	},
	created(){
		this.youtube_id = this.$route.params.videoId;

		this.loadVideo();
	},
	mounted(){

	},
	methods: {
		loadVideo(){
			this.videoLoading = true;

			let tokenString = '';
			if(this.$store.getters.getGoogleUser && this.$store.getters.getGoogleUser.Token){
				tokenString += '&token='+this.$store.getters.getGoogleUser.Token;
			}

			fetch(process.env.VUE_APP_URL+'api/videos/get.php?youtube_id='+this.youtube_id+tokenString, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					return response.json();
				}
			})
			.then(data => {
				this.videoLoading = false;

				if(data){
					this.fullVideo = data;
					this.fullVideo.date = moment(this.fullVideo.date).format('MMM D, YYYY');
					this.loadRelatedChannel(this.fullVideo);
					this.addToHistory();
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.videoLoading = false;
				console.error('There was an error!', error);
			});

		},
		addToHistory(){
			this.$store.dispatch('addToHistory', { video: this.fullVideo });
		},
		loadRelatedChannel(video){

			this.channelLoading = true;

			fetch(process.env.VUE_APP_URL+'api/channel/get.php?channel_id='+video.channel_id, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					//this.relatedVideoPage++;
					return response.json();
				}
			})
			.then(data => {
				this.channelLoading = false;
				this.videoChannel = data;
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelLoading = false;
				console.error('There was an error!', error);
			});
		}
	},
	watch: {
		'$route.params': {
			handler(newValue) {
				if(this.hasLoaded){
					this.youtube_id = newValue.videoId;

					this.loadVideo();
				}

				// prevent firing on the first component load
				this.hasLoaded = true;
				setTimeout(() => {
					document.documentElement.scrollTop = 0;
				}, 150)
			},
			immediate: true,
		}
	}
}
</script>

<style>
	

	@media (max-width: 1199px) {

		.col-xl-8 {
			padding: 0;
		}
		
	}
</style>