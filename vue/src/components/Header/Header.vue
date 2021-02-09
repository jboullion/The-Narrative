<template>
	<header>
		<h3><router-link to="/">{{ title }}</router-link></h3>

		<div class="toggle-darkmode">
			<transition name="darkmode" mode="out-in">
				<i class="fas fa-sun fa-fw" @click="toggleDarkmode" v-if="!darkmode"></i>
				<i class="fas fa-moon fa-fw" @click="toggleDarkmode" v-else></i>
			</transition>
		</div>

		<router-link to="/admin" class="admin-area"><i class="fas fa-fw fa-user-shield"></i></router-link>

		<div id="my-signin2" v-if="! googleUser"></div>
		<router-link to="/account" v-else><span class="account-image"><img :src="googleUser.Image" width="36" height="36" /></span></router-link>

		<!-- <a href="#" onclick="signOut();">Sign out</a> -->
	</header>
</template>

<script>
//import { mapGetters } from 'vuex';

export default {
  components: {  },
	props: [],
	data() {
		return {
			title: process.env.VUE_APP_TITLE,
			darkmode: false,
			googleUser: {}
		};
	},
	computed: {
		//...mapGetters(['getGoogleUser'])
	},
	mounted(){
		console.log(process.env.NODE_ENV)
		console.log(process.env.VUE_APP_TITLE)
		console.log(process.env.VUE_APP_URL)
	},
	created(){
		this.darkmode = localStorage.getItem('darkmode');
		if(this.darkmode){
			document.body.className = 'darkmode';
		}else{
			document.body.className = '';
		}

		this.googleUser = this.$store.getters.getGoogleUser;

	},
	methods: {
		toggleDarkmode(){
			this.darkmode = !this.darkmode;
			if(this.darkmode){
				document.body.className = 'darkmode';
				localStorage.setItem('darkmode', 1);
			}else{
				document.body.className = '';
				localStorage.removeItem('darkmode')
			}
		},

	}
}
</script>

<style scoped>
	header {
		align-items: center;
		background-color: #222222;
		color: #d7dadc;
		display: flex;
		padding: 10px 15px;
	}

	h3 {
		flex: 1;
		margin-bottom: 0;
	}

	h3 a {
		color: #d7dadc;
		text-decoration: none;
	}

	i {
		cursor: pointer;
		font-size: 26px;
	}
	
	.admin-area,
	.toggle-darkmode {
		margin-right:30px;
	}

	.fa-sun {
		color: #fafa60;
	}

	.fa-moon {
		color: #FDFD96;
		font-size: 22px;
	}

	span {
		position: relative;
	}

	span i {
		transition: opacity 0.2s linear;
		opacity: 1;
		position: absolute;
		top: 0;
		left: 0;
	}

	button {
		background-color: transparent;
		border: 0;
		color: #d7dadc;
	}

	button:active,
	button:focus {
		outline: 0;
	}

	.account-image img {
		border: 2px solid #818384;
		border-radius: 50%;
	}

	a {
		color: white;
	}

	/* a:hover, 
	a:active,
	a.router-link-active {
		color: var(--bs-blue);
	} */

	.darkmode-enter-from {

	}

	.darkmode-enter-active {
		animation: route 0.1s ease-out;
	}

	.darkmode-enter-to {
		
	}

	.darkmode-leave-from {
		
	}

	.darkmode-leave-active {
		animation: route 0.1s ease-in reverse;
	}

	.darkmode-leave-to {
		
	}

	@keyframes route {
		from {
			opacity: 0;
			/* transform: translateY(50px); */
		}

		to {
			opacity: 1;
			/* transform: translateY(0); */
		}
	}
</style>