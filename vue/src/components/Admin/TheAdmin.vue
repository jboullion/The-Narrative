<template>
	<div id="admin">
		<div class="container">
		
			<tabs>
				<TabItem @click="setSelectedTab('add-channel')" :mode="addChannelMode">Add Channel</TabItem>
				<TabItem @click="setSelectedTab('edit-channel')" :mode="editChannelMode">Edit Channel</TabItem>
				<!-- <TabItem @click="setSelectedTab('channel-list')" :mode="viewChannelMode">View Channels</TabItem> -->
			</tabs>

			<keep-alive>
				<component :is="selectedTab"></component>
			</keep-alive>
			<!-- <base-button class="btn btn-primary" @click="loadChannels">Load Channels <i v-if="this.channelsLoading" class="fas fa-cog fa-fw fa-spin"></i><i v-if="!this.channelsLoading" class="fas fa-fw fa-cloud-upload-alt"></i></base-button> -->
			<!-- <div v-if="this.channelsLoading" class="alert alert-info">Loading </div> -->
			<!-- <ChannelCard  v-for="channel in storedChannels" :key="channel.id" :channel="channel" /> -->
		</div>
	</div>
</template>

<script>
import AddChannel from './AddChannel.vue';
import EditChannel from './EditChannel.vue';


// import ChannelList from '../Channel/ChannelList';
import BaseButton from '../UI/BaseButton.vue';
import TabItem from '../UI/Tabs/TabItem.vue';

export default {
	props: [],
	components: {
		AddChannel,
		EditChannel,
		//ChannelList,
		TabItem,
		BaseButton
	},
	data() {
		return {
			selectedTab: 'add-channel',
			storedChannels: [],
			page: 0,
			channelsLoading: false
		};
	},
	provide(){
		return {
			channels: this.storedChannels,
			addChannel: this.addChannel,
			removeChannel: this.removeChannel
		}
	},
	mounted(){
		//this.loadChannels();
		//window.scrollTo(0, 0);
	},
	computed: {
		addChannelMode(){
			return this.selectedTab === 'add-channel' ? 'btn-primary' : 'btn-outline-primary'
		},
		editChannelMode(){
			return this.selectedTab === 'edit-channel' ? 'btn-primary' : 'btn-outline-primary'
		},
		viewChannelMode(){
			return this.selectedTab === 'channel-list' ? 'btn-primary' : 'btn-outline-primary'
		}
	},
	methods: {
		setSelectedTab(tab){
			this.selectedTab = tab;
		},
		addChannel(title, channel_id){ // website
			const newChannel = {
				id: new Date().toISOString(),
				title: title,
				channel_id: channel_id,
				//website: website
			};

			this.storedChannels.unshift(newChannel);
			//this.selectedTab = 'add-channel';

		},
		removeChannel( id ){ // website
			// remove from props
			this.storedChannels = this.storedChannels.filter(channel => channel.id !== id);

			// Remove from provide
			//const channelIndex = this.storedChannels.findIndex(channel => channel.id !== id);
			//this.storedChannels.splice(channelIndex,1);
		},
		loadChannels(){
			//var limit = 10;

			this.channelsLoading = true;

			fetch(process.env.VUE_APP_URL+'api/channel/search.php?offset='+this.page, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.page++;
					return response.json();
				}
			})
			.then(data => {
				this.channelsLoading = false;
				this.storedChannels = this.storedChannels.concat(data);
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelsLoading = false;
				console.error('There was an error!', error);
			});
		}

	}
}
</script>

<style>
	.card {
		margin-bottom: 30px;
	}

	.card .form-group {
		margin-bottom: 20px;
	}

	.card label {
		font-weight: bold;
	}

	.card .card-footer {
		background-color: white;
		padding: 30px 15px;
	}
</style>