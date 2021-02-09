<template>
	<div class="form-group">
		<label for="{{ name }}">{{ title }}</label>
		<input type="text" class="form-control" id="{{ input.name }}" name="{{ input.name }}" :value="value">
		<!-- <component :is="input.type" :input="input" :value="value"></component> -->
	</div>
</template>

<script>
// import Text from './Inputs/Text';
// import Textarea from './Inputs/Textarea';
// import Select from './Inputs/Select';

export default {
	components: {
		// Text,
		// Textarea,
		// Select
	},
	props: {
		title: {
			type: String,
			required: true
		},
		name: {
			type: String,
			required: true
		},
		type: {
			type: String,
			required: true
		},
		// input: {
		// 	type: Object,
		// 	required: true
		// },
		value: {
			required: true
		}
		
	},
	data() {
		return {
			inputType: 'text'
		}
	}
}
</script>

<style scoped>
	

</style>