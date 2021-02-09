<template>
	<input type="text" class="form-control" id="{{ input.name }}" name="{{ input.name }}" >
</template>


<script>
export default {
	props: {
		input: {
			type: Object,
			required: true
		},
		// value: {
		// 	required: true
		// }
		
	},
	data() {
		return {
		}
	}
}
</script>

<style scoped>
	

</style>