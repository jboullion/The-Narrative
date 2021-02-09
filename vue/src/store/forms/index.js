const formModule = {

	state() {
		return {
			// TODO: De we want to load these dynamically? They won't change much
			// genres: [
			// 	{ id: 1, name: 'Science' },
			// 	{ id: 1, name: 'Futurism' },
			// 	{ id: 1, name: 'X' }, // Elon Musk Stuff
			// 	{ id: 2, name: 'Politics' },
			// 	{ id: 3, name: 'News' },
			// 	{ id: 4, name: 'Food' },
			// 	{ id: 5, name: 'Comedy' },
			// 	{ id: 6, name: 'Gaming' },
			// 	{ id: 1, name: 'Philosophy' },
			// 	{ id: 1, name: 'Movies' },
			// 	{ id: 1, name: 'Geekdom' },
			// 	{ id: 1, name: 'Anime' },
			// 	{ id: 1, name: 'Money' },
			// ],
			styles: [
			],
			topics: [
			]
		};
	},
	getters: {
		getStyles(state){
			return state.styles;
		},
		getTopics(state){
			return state.topics;
		}
	},
	actions: {
		setStylesAndTopics(context, payload) {
			context.commit('setStylesAndTopics', payload);
		},
	},
	mutations: {
		setStylesAndTopics(state, payload) {
			state.styles = payload.styles;
			state.topics = payload.topics;
		},
	}
}

export default formModule;