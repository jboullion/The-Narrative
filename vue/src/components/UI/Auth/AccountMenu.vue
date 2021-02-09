<template>
	<header>
		<router-link to="/admin"><i class="fas fa-fw fa-user-shield"></i></router-link>

		<router-link to="/account"><i class="fas fa-user-alt"></i></router-link>
		<div class="g-signin2" data-onsuccess="onSignIn"></div>

		<a href="#" onclick="signOut();">Sign out</a>
	</header>
</template>

<script>

export default {
  components: {  },
	props: [],
	data() {
		return {

		};
	},
	created(){
		
	},
	methods: {


	}
}
</script>

<style scoped>

</style>