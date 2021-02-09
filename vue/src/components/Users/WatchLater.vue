<template>
	<div id="watch-later-videos" class="row vertical-list">
		<div class="d-flex justify-content-between">
			<h3>WatchLater</h3>
			<div class="mb-4">
				<form class="form-inline " method="get" action="" @submit.prevent="">
					<div class="input-group">
						<input type="search" class="form-control" placeholder="Search Watch Later" aria-label="search" name="s" v-model.trim="search" @change="searchWatchLater()" />
						<div class="input-group-append">
							<i class="fas fa-cog fa-spin" v-if="watchLaterLoading"></i>
							<i class="fas fa-search" @click="searchWatchLater()" v-else></i>
						</div>
					</div>
				</form>
			</div>
		</div>
		<VideoCard v-for="video in watchLaterVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4 col-lg-4 col-xl-3': true}" />
	</div>
</template>

<script>
import VideoCard from '../Video/VideoCard';

export default {
	props: ['videos'],
	components: {
		VideoCard
	},
	data() {
		return {
			watchLaterLoading: false,
			watchLaterPage: 0,
			watchLaterVideos: [],
			search: '',
			googleUser: null
		};
	},
	mounted(){
		this.googleUser = this.$store.getters.getGoogleUser;

		this.searchWatchLater();
	},
	methods: {
		searchWatchLater(){
			if(this.watchLaterLoading) return;

			this.watchLaterVideos = [];
			this.watchLaterLoading = true;
			
			let searchString = '?'; //'?offset='+this.watchLaterPage;

			if(this.search){
				searchString += '&s='+this.search.replace('#','');
			}

			if(this.googleUser && this.googleUser.Token){
				searchString += '&token='+this.googleUser.Token;
			}

			fetch(process.env.VUE_APP_URL+'api/user/get-watch-later.php'+searchString, {
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
				this.watchLaterLoading = false;
				if(data.length){
					this.watchLaterPage++;
					this.watchLaterVideos = this.watchLaterVideos.concat(data);
				}

			})
			.catch(error => {
				//this.errorMessage = error;
				this.watchLaterLoading = false;
				console.error('There was an error!', error);
			});
		},
	},
}
</script>

<style scoped>


</style>