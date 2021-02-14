<template>
	<div class="video-info">
		<div v-if="tags" class="tags">
			<span v-for="tag in tags" :key="tag">{{ tag }}</span>
		</div>
		<h3>{{ video.post_title }}</h3>
		<p>{{ videoDate }}</p>
		<div class="video-actions">
			<i class="fas fa-clock" @click="toggleWatchLater" v-bind:class="{active: isSaved}"></i>
			<i class="fas fa-heart" @click="toggleLiked" v-bind:class="{active: isLiked}"></i>
		</div>
		<div class="video-description" v-html="video.content"></div>
	</div>
</template>


<script>
import moment from 'moment'

export default {
	props: ['video'],
	data() {
		return {
			isLiked: false,
			isSaved: false,
			tags: ''
			//videoDate: null
		};
	},
	created() {
		this.isLiked = this.video.isLiked?true:false;
		this.isSaved = this.video.isSaved?true:false;
		this.tags = this.video.tags?this.video.tags.split(','):'';
		
		this.videoDate = moment(this.video.post_date).format('MMM D, YYYY');
	},
	watch: {
		video: function(newVal) { 
			this.isLiked = newVal.isLiked?true:false;
			this.isSaved = newVal.isSaved?true:false;
		}
	},
	methods: {
		toggleLiked() {
			this.$store.dispatch('toggleLiked', { video: this.video });
			this.isLiked = !this.isLiked;
		},
		toggleWatchLater() {
			this.$store.dispatch('toggleWatchLater', { video: this.video });
			this.isSaved = !this.isSaved;
		},
	}
}
</script>


<style scoped>
	.video-info {
		border-bottom: 1px solid #ccc;
		margin: 15px 0;
		padding-bottom: 15px;
		position: relative;
		padding-right: 80px;
	}

	.video-actions {
		font-size: 24px;
		position: absolute;
		top: 0;
		right: 15px;
	}

	.video-actions i {
		color: #ccc;
		cursor: pointer;
		transition: color 0.2s linear;
		margin-left: 15px;
	}

	.video-actions i.fa-heart.active {
		color: var(--red);
	}

	.video-actions i.fa-clock.active {
		color: var(--bs-dark);
	}

	.darkmode .video-actions i.fa-clock.active {
		color: var(--bs-light);
	}

	.tags span {
		color: var(--bs-blue);
		margin-right: 10px;
	}

	@media (max-width: 1199px) {

		.video-info {
			padding: 0 90px 15px 15px;
		}
		
		.video-actions {
			line-height: 1;
		}
	}

</style>