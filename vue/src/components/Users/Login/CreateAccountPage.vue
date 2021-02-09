<template>
	<form class="card mt-5" @submit.prevent="submitLogin">
		<div class="card-body">
			<h2>Create Account</h2>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" v-model.trim="email" required>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" v-model.trim="password" required>
			</div>

			<div class="d-flex justify-content-between">
				<button class="btn btn-primary">Create Account</button>
				<router-link to="/login" class="btn btn-outline-primary">Login</router-link>
			</div>
		</div>
	</form>
</template>


<script>
//import BaseButton from '../UI/BaseButton.vue';


export default {
	components: {

	},
	data() {
		return {
			email: '',
			password: '',
			formIsValid: true
		};
	},
	// validations () {
	// 	return {

	// },
	methods: {
		submitLogin(){
			
		},
	}
}
</script>

<style scoped>

</style>