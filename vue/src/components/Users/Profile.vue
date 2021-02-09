<template>
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
		</div>
		<div class="card-footer">
			<!-- <div :class="{ error: v$.name.$errors.length }">
				<input v-model="name">
				<div class="input-errors" v-for="(error, index) of v$.name.$errors">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
			</div> -->
			<base-button type="submit" class="btn btn-primary w-100">Update Profile</base-button>
		</div>
	</form>
</template>

<script>
export default {
	
}
</script>

<style scoped>

</style>