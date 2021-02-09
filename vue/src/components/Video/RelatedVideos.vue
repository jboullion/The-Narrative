<template>
	<div id="side-list" class="col-xl-4">
		<VideoCard v-for="video in relatedVideos" :key="video.video_id" :video="video" :showChannel="true" />
		<LoadingIcon v-if="relatedVideosLoading" />
	</div>
</template>


<script>
import _debounce from 'lodash/debounce';
//import _throttle from 'lodash/throttle';

import VideoCard from '../Video/VideoCard';
import LoadingIcon from '../UI/LoadingIcon.vue';

export default {
	inject: [],
	props: ['video'],
	components: {
		VideoCard,
		LoadingIcon,
	},
	data() {
		return {
			relatedVideosLoading: false,
			relatedVideoPage: 0,
			relatedVideos: [],
		};
	},
	created(){
	
	},
	mounted(){
		this.scroll();
	},
	methods: {
		scroll () {
			//const scrollPadding = 400;
			const throttleSpeed = 300;

			var $sideList = document.getElementById('side-list');

			// Ideally this should be a debounce but the lodash underscore wasn't working as I hoped
			window.addEventListener('scroll', _debounce(() => {
				if($sideList.scrollHeight - $sideList.scrollTop === $sideList.clientHeight){
					this.loadRelatedVideos();
				}
			}, throttleSpeed));
		},
		loadRelatedVideos(){

			this.relatedVideosLoading = true;

			fetch(process.env.VUE_APP_URL+'api/videos/related.php?channel_id='+this.video.channel_id, { // +'&offset='+this.relatedVideoPage
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
				this.relatedVideosLoading = false;
				if(data.length){
					this.relatedVideoPage++;
					this.relatedVideos = this.relatedVideos.concat(data);
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.relatedVideosLoading = false;
				console.error('There was an error!', error);
			});
		}
	},
	watch: {
		video: function() { 
			this.relatedVideoPage = 0;
			this.relatedVideos = [];
			this.loadRelatedVideos();
		}
	}

}
</script>

<style >
	#side-list .card.video {
		display: flex;
		flex-direction: row;
		margin-bottom: 0;
		margin-top: 15px;
		width: 100%;
	}
	
	#side-list .card.video .card-link {
		width: 45%;
	}

	#side-list .card.video .card-img-back {
		width: 100%;
		height: auto;
	}

	#side-list .card.video .card-img-back img {
		position: relative;
	}

	#side-list .card.video .card-img-back i {
		font-size: 50px;
	}

	#side-list .card.video .card-img-back img {
		width: 100%;
		height: auto;
	}

	#side-list .card.video .card-body {
		height: auto;
		width: 55%;
		padding: 0 10px;
	}

	#side-list .card.video .card-body p {
		font-size: 14px;
	}

	#side-list .card.video .card-body span.date {
		position: relative;
		display: block;
		left: 0;
		bottom: 0;
	}


	#side-list .card.video {
		width: 100%;
		height: auto;
	}

	@media (max-width: 1199px) {

		
	}
</style>