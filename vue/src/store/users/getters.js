export default {
	// userIsAuthenticated(state){
	// 	return state.loggedIn;
	// },
	getGoogleUser(){
		return JSON.parse(sessionStorage.getItem('GoogleUser'));
	}
}