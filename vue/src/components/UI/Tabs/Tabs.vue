
<template>
	<ul class="nav nav-pills nav-fill">
		<slot></slot>
	</ul>
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
	ul {
		margin: 15px 0;
	}
</style>