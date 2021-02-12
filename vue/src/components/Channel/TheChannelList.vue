<template>
	<div id="channel-page">
		<ChannelFilters />
		<div id="channels">
			<ChannelCard v-for="channel in getChannels" :key="channel.channel_id" :channel="channel" />
		</div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';

import ChannelFilters from './ChannelFilters';
import ChannelCard from './ChannelCard';

export default {
	inject: [],
	components: {
		ChannelFilters,
		ChannelCard
	},
	computed: {
		...mapGetters(['getChannels'])
	},
	data() {
		return {
			channelsLoading: false,
			channelsPage: 0,
			channels: [],
		};
	},
	mounted(){
		if(! this.$store.getters.getChannels.length){
			this.loadChannels();
		}
	},
	methods: {
		loadChannels(){

			this.channelsLoading = true;

			let searchString = '?rand=1';

			fetch(process.env.VUE_APP_URL+'api/channel/search.php'+searchString, {
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
				this.channelsLoading = false;

				//console.log(data);
				if(this.$store.getters.getChannels.length){
					this.$store.dispatch('updateChannels', data);
				}else{
					this.$store.dispatch('addChannels', data);
				}

			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelsLoading = false;
				console.error('There was an error!', error);
			});
		},

	}
	
}
</script>

<style scoped>
	#channels {
		padding: 50px 0;
	}
</style>