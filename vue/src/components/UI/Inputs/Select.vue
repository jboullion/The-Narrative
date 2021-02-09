<template>
	<select class="form-control" id="{{ input.name }}" name="{{ input.name }}" >
		<option>Option 1</option>
	</select>
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
