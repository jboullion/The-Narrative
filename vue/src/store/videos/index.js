// import actions from './actions'; 
// import getters from './getters'; 
// import mutations from './mutations'; 

const videoModules = {
	// namespaced: true,
	state() {
		return {
			currentVideo: ''
		};
	},
	getters: {
		getCurrentVideo(state){
			return state.currentVideo;
		}
	},
	mutations: {
		updateCurrentVideo(state, payload) {
			state.currentVideo = payload;
		}
	},
	actions: {
		updateCurrentVideo(context, payload) {
			context.commit('CurrentVideo', payload);
		}
	},
}

export default videoModules;