<template>
	<div id="channel-list" >
		<div v-if="channelSearch" class="channel-search mb-4">
			<form class="form-inline row justify-content-end" method="get" action="" @submit.prevent="searchChannels()">
				<div class="">
					<div class="input-group">
						<input type="search" class="form-control" placeholder="Search Channel" aria-label="search" name="s" v-model.trim="search" @change="searchChannels()" />
						<div class="input-group-append">
							<i class="fas fa-cog fa-spin" v-if="channelVideosLoading"></i>
							<i class="fas fa-search" @click="searchChannels()" v-else></i>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="row channel-videos vertical-list">
			<VideoCard 
			v-for="video in channelVideos" 
			:key="video.video_id" 
			:video="video" 
			:class="{'col-md-4': true}" />
			<LoadingIcon v-if="channelVideosLoading" />
		</div>
	</div>
</template>


<script>
import _debounce from 'lodash/debounce';
//import _throttle from 'lodash/throttle';

import VideoCard from '../Video/VideoCard';
import LoadingIcon from '../UI/LoadingIcon.vue';

export default {
	inject: [],
	props: ['channel', 'channelSearch'],
	components: {
		VideoCard,
		LoadingIcon
	},
	data() {
		return {
			channelVideosLoading: false,
			channelVideos: [],
			//visibleVideos: [],
			channelVideoPage: 0,
			xDown: false,
			yDown: false,
			sliderSize: 340,
			moveLeft: false,
			moveRight: false,
			search: '',
			channelEnd: false,
			//current_youtube_id: ''
		};
	},
	computed: {
		
	},
	mounted(){
		this.scroll();
		//this.current_youtube_id = this.$store.getters.getCurrentVideo;
	},
	methods: {
		// getVisibleVideos() {
		// 	let currentYouTubeID = this.$store.getters.getCurrentVideo;
		// 	return this.channelVideos.filter(video => video.youtube_id == currentYouTubeID);
		// },
		scroll() {
			//const scrollPadding = 400;
			const throttleSpeed = 300;

			let $channelList = document.getElementById('channel-list');

			// Ideally this should be a debounce but the lodash underscore wasn't working as I hoped
			window.addEventListener('scroll', _debounce(() => {
				if($channelList.scrollHeight - $channelList.scrollTop === $channelList.clientHeight){
					this.loadChannelVideos();
				}
			}, throttleSpeed));
		},
		searchChannels(){
			if(this.channelVideosLoading) return;

			this.channelVideos = [];
			this.channelVideosLoading = true;
			
			let searchString = '?channel_id='+this.channel.ID;

			if(this.order){
				searchString += '&offset='+this.channelsPage+'&order='+this.order;
			}else{
				searchString += '&orderby=title&order=asc';
			}

			if(this.search){
				searchString += '&s='+this.search.replace('#','');
			}

			fetch(process.env.VUE_APP_URL+'api/videos/search.php'+searchString, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.channelsPage++;
					return response.json();
				}
			})
			.then(data => { 
				this.channelVideosLoading = false;
				if(data.length){
					this.channelVideoPage++;
					this.channelVideos = this.channelVideos.concat(data);

					//this.getVisibleVideos();
				}

			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelVideosLoading = false;
				console.error('There was an error!', error);
			});
		},
		loadChannelVideos(){
			if(this.channelEnd) return;
			if(this.channelVideosLoading) return;
			this.channelVideosLoading = true;

			//console.log(this.channel);

			fetch(process.env.VUE_APP_URL+'api/channel/videoList.php?channel_id='+this.channel.ID+'&offset='+this.channelVideoPage, {
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
				this.channelVideosLoading = false;
				if(data.length){
					this.channelVideoPage++;
					this.channelVideos = this.channelVideos.concat(data);
					//this.getVisibleVideos();
				}else{
					this.channelEnd = true;
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelVideosLoading = false;
				console.error('There was an error!', error);
			});
		},
	},
	watch: {
		channel: function() { 
			this.channelVideos = [];
			this.channelVideoPage = 0;
			this.loadChannelVideos();
		}
	}

}
</script>

<style>

	.channel-search {
		position: absolute;
		bottom: 100%;
		right: 15px;
	}

	.channel-videos {
		min-height: 80vh
	}

	#channel-list {
		position: relative;
	}

	.vertical-list .card {
		margin-bottom: 15px;
	}
	
	.vertical-list .card-img-back {
		padding-top: 56.25%;
	}

	.vertical-list .card-img-back img {
		width: 100%;
		height: auto;
	}

	@media (max-width: 1199px) {

		#channel-list {
			padding: 0 15px;
		}


	}

	@media (max-width: 768px) {

		.channel-search {
			position: relative;
			bottom: auto;
			right: auto;
		}

	}
</style>