export default {
	getChannels(state){
		return state.channels;
	},
	cleanChannels(_, getters){
		return getters.getChannels;
	}
}