<template>
	<div class="video-channel-info">
		<router-link :to="'/channel/'+channel.youtube_id">
			<img :src="channel.img_url" loading="lazy">
		</router-link>
		<div class="channel-info">
			<h4>{{ channel.title }}</h4>
			<a :href="'https://www.youtube.com/channel/'+channel.youtube_id" class="channel-social youtube" target="_blank">
				<i class="fab fa-youtube"></i>
			</a>
			<a v-if="channel.patreon" :href="channel.patreon" class="channel-social patreon" target="_blank">
				<i class="fab fa-patreon"></i>
			</a>
			<a v-if="channel.twitter" :href="channel.twitter" class="channel-social twitter" target="_blank">
				<i class="fab fa-twitter"></i>
			</a>
			<a v-if="channel.website" :href="channel.website" class="channel-social website" target="_blank">
				<i class="fas fa-globe"></i>
			</a>
			<!-- <div class="channel-social">
				<i class="fas fa-trash-alt delete-channel" @click="removeChannel(channel.id)"></i>
			</div> -->
			
		</div>

	</div>
</template>


<script>
export default {
	props: ['channel'],
	data() {
		return {
		};
	},
	mounted(){

	},
	methods: {
		
	}
	
}
</script>

<style scoped>

	.video-channel-info {
		margin-bottom: 15px;
		
		display: flex;
		align-items: center;
	}

	.video-channel-info img {
		border-radius: 50%;
		width: 62px;
		height: 62px;
	}

	.video-channel-info .channel-info {
		margin-left: 20px;
	}

	.video-channel-info h4 {
		margin: 0;
	}

	.channel-info {
		margin-left: 20px;
	}

	h4 {
		margin: 0;
	}

	.delete-channel {
		cursor: pointer;
	}

	@media (max-width: 1199px) {

		.video-channel-info {
			padding: 0 15px;
		}

		
	}
</style>