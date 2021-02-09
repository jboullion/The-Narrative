<template>
	<form class="card mt-5" @submit.prevent="submitLogin">
		<div class="card-body">
			<h3>Login</h3>
			<div class="alert alert-danger" role="alert" v-if="errors.length">
				<b>Please correct the following error(s):</b>
				<ul>
					<li v-for="(error, index) in errors" :key="index">{{ error }}</li>
				</ul>
			</div>
			<div class="alert alert-success" role="alert" v-if="successLogin">
				<b>Login Success!</b>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" v-model.trim="email" >
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" v-model.trim="password" autocomplete="true">
			</div>

			<div class="d-flex justify-content-between">
				<button class="btn btn-primary">Login</button>
				<router-link to="/createaccount" class="btn btn-outline-primary">Create Account</router-link>
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
			//formIsValid: true,
			successLogin: false,
			errors: []
		};
	},
	// validations () {
	// 	return {

	// },
	mounted() {

	},
	methods: {
		validEmail(email) {
			var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		},
		validPassword(password) {
			if(! password
			|| password.length < 6){
				return false;
			}

			return true;
		}
	}
}
</script>

<style scoped>

</style>