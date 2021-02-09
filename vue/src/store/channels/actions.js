export default {
	addChannels(context, payload) {
		context.commit('addChannels', payload);
	},
	updateChannels(context, payload) {
		context.commit('updateChannels', payload);
	}
}