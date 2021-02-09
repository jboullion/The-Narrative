<template>
	<base-dialog  title="Invalid Input" @close="confirmError()" :open="inputIsInvalid">
		<template #default>
			<p>An input value is invalid</p>
		</template>
		<!-- <template #actions>
			<base-button @click="confirmError()" class="btn btn-primary">OK</base-button>
		</template> -->
	</base-dialog>
	<div id="add-channel">
		<h2>Add Channel</h2>
		<form  class="card" @submit.prevent="submitChannel">
			<div class="card-body">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title" v-model.trim="title" >
				</div>

				<div class="form-group">
					<label for="youtube_id">Channel ID</label>
					<input type="text" class="form-control" id="youtube_id" name="youtube_id"  v-model.trim="youtube_id">
				</div>

				<div class="form-group">
					<label for="facebook">Facebook</label>
					<input type="text" class="form-control" id="facebook" name="facebook" ref="titleInput" >
				</div>

				<div class="form-group">
					<label for="instagram">Instagram</label>
					<input type="text" class="form-control" id="instagram" name="instagram" ref="instagramInput">
				</div>

				<div class="form-group">
					<label for="patreon">Patreon</label>
					<input type="text" class="form-control" id="patreon" name="patreon" ref="patreonInput">
				</div>

				<div class="form-group">
					<label for="tiktok">TikTok</label>
					<input type="text" class="form-control" id="tiktok" name="tiktok" ref="tiktokInput">
				</div>

				<div class="form-group">
					<label for="twitter">Twitter</label>
					<input type="text" class="form-control" id="twitter" name="twitter" ref="twitterInput">
				</div>

				<div class="form-group">
					<label for="twitch">Twitch</label>
					<input type="text" class="form-control" id="twitch" name="twitch" ref="twitchInput">
				</div>

				<div class="form-group">
					<label for="website">Website</label>
					<input type="text" class="form-control" id="website" name="website" ref="websiteInput">
				</div>

				<div class="form-group">
					<label for="type">Type</label>
					<select id="type" class="form-control" ref="typeInput">
						<option selected>Choose...</option>
						<option>Explainer</option>
						<option>Demonstration</option>
						<option>Interviews</option>
						<option>Podcast</option>
						<option>Professional</option>
						<option>Reviews</option>
						<option>Tutoirals</option>
						<option>Vlog</option>
					</select>
				</div>

				<div class="form-group">
					<label for="genre">Genre</label>
					<select id="genre" class="form-control" multiple ref="genreInput">
						<option selected>Choose...</option>
						<option>Art</option>
						<option>Comedy</option>
						<option>Food</option>
						<option>Gaming</option>
						<option>News</option>
						<option>Money</option>
						<option>Movies</option>
						<option>Science</option>
						<option>Philosophy</option>
						<option>Politics</option>
						<option>Technology</option>
					</select>
				</div>

				<div class="form-group">
					<label for="tags">Tags</label>
					<input type="text" class="form-control" id="tags" name="tags" ref="tagsInput"/>
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<textarea id="description" name="description" class="form-control" ref="descriptionInput">
					</textarea>
				</div>
			</div>
			<div class="card-footer">
				<div :class="{ error: errors.length }">
					<div class="input-errors" v-for="(error, index) of errors" :key="index">
						<div class="error-msg">{{ error }}</div>
					</div>
				</div>
				<base-button type="submit" class="btn btn-primary w-100">Add Channel</base-button>
			</div>
		</form>
		
	</div>
	<ChannelCard v-if="channel" :channel="channel" />
</template>

<script>
import BaseButton from '../UI/BaseButton.vue';
// import BaseInput from '../UI/BaseInput.vue';
//import BaseDialog from '../UI/BaseDialog.vue';

import ChannelCard from '../Channel/ChannelCard';

// import { required, maxLength  } from '@vuelidate/validators'

export default {
	inject: ['addChannel'], // 'channels',
	components: {
		BaseButton,
		ChannelCard
		//BaseInput
		//BaseDialog
	},
	data() {
		return {
			title: '',
			youtube_id: '',
			inputIsInvalid: false,
			channel: {},
			errors: [],
			styles: [],
			topics: [],
			focus: [],
		};
	},
	created(){
		this.styles = this.$store.getters.getStyles;
		this.topics = this.$store.getters.getTopics;
	},
	// validations () {
	// 	return {
	// 		title: { required }, // Matches this.title
	// 		//lastName: { required }, // Matches this.lastName
	// 		// contact: {
	// 		// 	email: { required, email } // Matches this.contact.email
	// 		// }
	// 	}
	// },
	methods: {
		submitChannel(){


			if(! this.title || this.title.length < 3){
				this.inputIsInvalid = true;
				return;
			}

			if(! this.youtube_id || this.youtube_id.length < 5){
				this.inputIsInvalid = true;
				return;
			}

			this.addChannel(this.title, this.youtube_id); // enteredWebsite

			fetch(process.env.VUE_APP_URL+'api/channel/add.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ title: this.title, youtube_id: this.youtube_id })
			})
			.then(response => response.json())
			.then(data => {
				if(data.channel_id){
					this.channel.channel_id = data.channel_id;
				}
			})
			.catch(error => {
				this.errorMessage = error;
				console.error('There was an error!', error);
			});
			// description: ['description'],
			// img_url => $channel_img,
			// facebook: ['facebook'],
			// instagram: ['instagram'],
			// patreon: ['patreon'],
			// tiktok: ['tiktok'],
			// twitter: ['twitter'],
			// twitch: ['twitch'],
			// website: ['website'],
			// tags: ['tags'],
		},
		confirmError(){
			this.inputIsInvalid = false;
		}
	}
}
</script>

<style scoped>

</style>