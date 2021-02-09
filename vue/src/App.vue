<template>
	<Header />
	<main class="container-fluid wrapper">
		<router-view v-slot="{ Component }" >
			<transition name="route" mode="out-in" >
			<!-- <keep-alive> -->
				<component :is="Component" :key="$route.params.videoId" />
			<!-- </keep-alive> -->
			</transition>
		</router-view>
	</main>
</template>

<script>
import Header from './components/Header/Header';



export default {
	props: [],
	components: {
		Header,
	},
	mounted(){
		//this.setupUser();
	},
	methods: {
		// setupUser(){
		// 	let googleUser = this.$store.getters.getGoogleUser;
		// }
	}
}
</script>

<style>
	:root {
		--red: #c00;
		--white: #ffffff;
	}

	* {
		box-sizing: border-box;
	}

	html {
		font-family: "Open Sans", sans-serif;
		scroll-behavior: auto !important;
	}

	body {
		background-color: #f8f8f8;
		margin: 0;
		font-family: "Open Sans", sans-serif;
		transition: background-color 0.2s linear;
		overflow-y: scroll;
		scroll-behavior: auto !important;
	}

	h1,h2,h3,h4,h5,h6,p,a {
		color: #373737;
		text-decoration: none;
		transition: color 0.2s linear;
		margin-top: 0;
	}

	.wrapper {
		padding-bottom: 50px;
	}

	body.darkmode {
		background-color: #030303;
	}


	body.darkmode h1,
	body.darkmode h2,
	body.darkmode h3,
	body.darkmode h4,
	body.darkmode h5,
	body.darkmode h6,
	body.darkmode p {
		color: #f8f8f8;
	}


	body.darkmode .card h1,
	body.darkmode .card h2,
	body.darkmode .card h3,
	body.darkmode .card h4,
	body.darkmode .card h5,
	body.darkmode .card h6 {
		color: #373737;
	}


	.opacity-0 {
		opacity: 0 !important;
	}

	.container-fluid {
		max-width: 1750px;
	}

	.ellipsis {
		text-overflow: ellipsis;
		white-space: normal;
		overflow: hidden;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		display: -webkit-box;
	}

	.channel-social {
		display: inline-block;
		margin-right: 15px;
		padding: 5px 5px 5px 0;
	}

	.youtube i { color: var(--red); }
	.patreon i { color: #f96854; }
	.twitter i { color: #1DA1F2; }
	.website i { color: #55595c; }

	.website i,
	.delete-channel {
		transition: color 0.2s linear;
	}

	.darkmode .website i,
	.darkmode .delete-channel,
	.darkmode .channel-control i {
		color: #d7dadc;
	}

	header .abcRioButtonBlue,
	header .abcRioButtonIcon {
		border-radius: 50% !important;
	}

	/* 
	@media (max-width: 1199px) {
		.container-fluid {
			padding: 0;
		}
	} 
	*/

	.input-group {
		flex: 1;
		margin: 0;
	}

	.input-group-append {
		background-color: #272729;
		color: #818384;
		padding: 0 20px;
		line-height: 38px;
		cursor: pointer;
	}

	.form-flex {
		height: 100%;
		padding: 0 5px;
		flex: 1;
	}

	.form-flex-2 {
		flex: 0 1 35%;
		width: 35%;
	}

	/* .input-group .input-group-text {
		// background-color: white
	} */

	.mt-style {
		position: relative;
	}

	.mt-style:before { 
		content:'\f0dd';
		color: #dedede; 
		font-size: 16px; 
		font-weight: bold;
		line-height:1; 
		font-family: "Font Awesome 5 Free"; 
		pointer-events: none; 
		position: absolute; 
		right: 10px;
		top: 7px;
		z-index:1;
	}

	.input-group svg {
		width: 18px;
		color: black;
	}

	.form-control,
	.form-control:focus {
		background-color: #606060;
		border: 0;
		color: #fefefe;
	}
	

	input[type="search"]::-webkit-search-cancel-button {
		-webkit-appearance: none;
		height: 1em;
		width: 1em;
		border-radius: 50em;
		background: url(https://pro.fontawesome.com/releases/v5.10.0/svgs/solid/times-circle.svg) no-repeat 50% 50%;
		background-size: contain;
		opacity: 0;
		pointer-events: none;
	}

	input[type="search"]:focus::-webkit-search-cancel-button {
		opacity: .5;
		pointer-events: all;
	}

	.darkmode input[type="search"]::-webkit-search-cancel-button {
		filter: invert(1);
	}

	/* .darkmodeinput[type="search"]::-webkit-search-cancel-button {
		background: #fefefe;
	} */
	

	.form-control::placeholder {
		color: #dedede;
	}

	.input-group .form-control {
		height: auto;
	}


	.form-control {
		border-radius: 0;
	}

	.input-group span { 
		border-radius: 0;
	}

	
	


	.route-enter-active {
		animation: route 0.15s ease-out;
	}

	.route-leave-active {
		animation: route 0.15s ease-in reverse;
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