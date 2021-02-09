<template>
	<button>
		<slot></slot>
	</button>
</template>

<script>
export default {
	props: [],
	data() {
		return {
		}
	}
}
</script>

<style scoped>
	button {
		border-radius: 0;
	}
</style>