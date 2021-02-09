<template>
	<div class="modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ title }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<slot></slot>
				</div>
				<div class="modal-footer">
					<slot name="actions">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ close }}</button>
						<button type="button" class="btn btn-primary">{{ confirm }}</button>
					</slot>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		title: {
			type: String,
			required: false
		},
		confirm: {
			type: String,
			required: false,
			default: 'OK'
		},
		close: {
			type: String,
			required: false,
			default: 'Close'
		}
	}
}
</script>

<style scoped>

	
</style>