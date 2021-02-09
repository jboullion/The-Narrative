<template>
	<div id="liked-videos" class="row vertical-list">
		<div class="d-flex justify-content-between">
			<h3>Liked</h3>
			<div class="mb-4">
				<form class="form-inline " method="get" action="" @submit.prevent="">
					<div class="input-group">
						<input type="search" class="form-control" placeholder="Search Liked" aria-label="search" name="s" v-model.trim="search" @change="searchLiked()" />
						<div class="input-group-append">
							<i class="fas fa-cog fa-spin" v-if="likedLoading"></i>
							<i class="fas fa-search" @click="searchLiked()" v-else></i>
						</div>
					</div>
				</form>
			</div>
		</div>
		<VideoCard v-for="video in likedVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4 col-lg-4 col-xl-3': true}" />
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
			likedLoading: false,
			likedPage: 0,
			likedVideos: [],
			search: '',
			googleUser: null
		};
	},
	mounted(){
		this.googleUser = this.$store.getters.getGoogleUser;

		this.searchLiked();
	},
	methods: {
		searchLiked(){
			if(this.likedLoading) return;

			this.likedVideos = [];
			this.likedLoading = true;
			
			let searchString = '?'; //'?offset='+this.likedPage;

			// if(this.order){
			// 	searchString += '&offset='+this.likedPage+'&order='+this.order;
			// }else{
			// 	searchString += '&orderby=title&order=asc';
			// }

			if(this.search){
				searchString += '&s='+this.search.replace('#','');
			}

			if(this.googleUser && this.googleUser.Token){
				searchString += '&token='+this.googleUser.Token;
			}

			fetch(process.env.VUE_APP_URL+'api/user/get-liked.php'+searchString, {
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
				this.likedLoading = false;
				if(data.length){
					this.likedPage++;
					this.likedVideos = this.likedVideos.concat(data);
				}

			})
			.catch(error => {
				//this.errorMessage = error;
				this.likedLoading = false;
				console.error('There was an error!', error);
			});
		},
		// loadliked(){

		// 	this.likedLoading = true;

		// 	fetch(process.env.VUE_APP_URL+'api/user/get-liked.php?user_id=1&offset='+this.likedPage, {
		// 		//mode: 'no-cors',
		// 		method: 'GET',
		// 		headers: { 'Content-Type': 'application/json' }
		// 	})
		// 	.then(response => {
		// 		if(response.ok){
		// 			return response.json();
		// 		}
		// 	})
		// 	.then(data => {
		// 		this.likedLoading = false;
		// 		if(data.length){
		// 			this.likedPage++;
		// 			this.likedVideos = this.likedVideos.concat(data);
		// 		}
		// 	})
		// 	.catch(error => {
		// 		//this.errorMessage = error;
		// 		this.likedLoading = false;
		// 		console.error('There was an error!', error);
		// 	});
		// },
	},
}
</script>

<style scoped>


</style>