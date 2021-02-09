export default {
	addChannels(state, payload) {
		state.channels = state.channels.concat(payload);
	},
	updateChannels(state, payload) {
		state.channels = payload;
	}
}