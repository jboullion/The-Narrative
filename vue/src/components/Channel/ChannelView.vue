<template>
	<div id="channels">
		<ChannelCard :channel="channel" />
	</div>
</template>


<script>
import ChannelCard from './ChannelCard';

export default {
	props: ['channel'],
	components: {
		ChannelCard
	},
	data() {
		return {

		};
	},
	provide(){
		return {
			channels: this.channels
		}
	},
}
</script>

<style scoped>
	#channels {
		padding: 50px 0;
	}
</style>