
<template>
	<li class="nav-item">
		<base-button :class="'btn '+mode"><slot></slot></base-button>
	</li>
</template>

<script>
export default {
	props: ['mode'],
	data() {
		return {
		}
	},
	
}
</script>

<style scoped>
	li button {
		width: 100%;
	}
</style>