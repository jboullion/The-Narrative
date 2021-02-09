<template>
	<div id="history-videos" class="row vertical-list">
		<div class="d-flex justify-content-between">
			<h3>History</h3>
			<div class="mb-4">
				<form class="form-inline " method="get" action="" @submit.prevent="">
					<div class="input-group">
						<input type="search" class="form-control" placeholder="Search History" aria-label="search" name="s" v-model.trim="search" @change="searchHistory()" />
						<div class="input-group-append">
							<i class="fas fa-cog fa-spin" v-if="historyLoading"></i>
							<i class="fas fa-search" @click="searchHistory()" v-else></i>
						</div>
					</div>
				</form>
			</div>
		</div>
		<VideoCard v-for="video in historyVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4 col-lg-4 col-xl-3': true}" />
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
			historyLoading: false,
			historyPage: 0,
			historyVideos: [],
			search: '',
			googleUser: null
		};
	},
	mounted(){
		this.googleUser = this.$store.getters.getGoogleUser;

		this.searchHistory();
	},
	methods: {
		searchHistory(){
			if(this.historyLoading) return;
			
			this.historyVideos = [];
			this.historyLoading = true;
			
			let searchString = '?';// '?offset='+this.historyPage;

			// if(this.order){
			// 	searchString += '&orderby=date&order='+this.order;
			// }else{
			// 	searchString += '&orderby=date&order=asc';
			// }

			if(this.search){
				searchString += '&s='+this.search.replace('#','');
			}

			if(this.googleUser && this.googleUser.Token){
				searchString += '&token='+this.googleUser.Token;
			}

			fetch(process.env.VUE_APP_URL+'api/user/get-history.php'+searchString, {
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
				this.historyLoading = false;
				if(data.length){
					this.historyPage++;
					this.historyVideos = this.historyVideos.concat(data);
				}

			})
			.catch(error => {
				//this.errorMessage = error;
				this.historyLoading = false;
				console.error('There was an error!', error);
			});
		

			
		},
		// loadHistory(){

		// 	this.historyLoading = true;

		// 	if(this.googleUser && this.googleUser.Token){
		// 		searchString += '&token='+googleUser.Token;
		// 	}

		// 	fetch(process.env.VUE_APP_URL+'api/user/get-history.php?user_id=1&offset='+this.historyPage, {
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
		// 		this.historyLoading = false;
		// 		if(data.length){
		// 			this.historyPage++;
		// 			this.historyVideos = this.historyVideos.concat(data);
		// 		}
		// 	})
		// 	.catch(error => {
		// 		//this.errorMessage = error;
		// 		this.historyLoading = false;
		// 		console.error('There was an error!', error);
		// 	});
		// },
	},
}
</script>

<style scoped>


</style>