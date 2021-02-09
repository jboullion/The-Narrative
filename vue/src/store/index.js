import { createStore } from 'vuex'; 

import channelModules from './channels/index';
import videoModules from './videos/index';
import userModules from './users/index';
import formModule from './forms/index';

const store = createStore({
	modules: {
		channels: channelModules,
		videoModules: videoModules,
		users: userModules,
		forms: formModule
	},
	state() {
		return {
		};
	},
	mutations: {

	},
	getters: {

	},
	actions: {

	}
});

export default store;