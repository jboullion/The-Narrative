import actions from './actions'; 
import getters from './getters'; 
import mutations from './mutations'; 

const channelModules = {
	// namespaced: true,
	state() {
		return {
			channels: []
		};
	},
	actions: actions,
	getters: getters,
	mutations: mutations
}

export default channelModules;