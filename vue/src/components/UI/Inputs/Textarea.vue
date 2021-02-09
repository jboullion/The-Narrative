<template>
	<textarea class="form-control" id="{{ input.name }}" name="{{ input.name }}" ></textarea>
</template>


<script>
export default {
	props: {
		input: {
			type: Object,
			required: true
		},
	},
	data() {
		return {
		}
	}
}
</script>

<style scoped>
	

</style>