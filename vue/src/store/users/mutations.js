export default {
	setAuth(state, payload) {
		state.loggedIn = payload.isAuth;
	},
}