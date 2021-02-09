<template>
	<teleport to="body">
		<div @click="$emit('close')" v-if="open"></div>
		<transition name="dialog">
			<dialog open v-if="open">
				<header>
					<slot name="header">
						<span>{{ title }}</span>
					</slot>
				</header>
				<section>
					<slot></slot>
				</section>
				<menu>
					<slot name="actions">
						<base-button @click="$emit('close')" class="btn btn-primary">Close</base-button>
					</slot>
				</menu>
			</dialog>
		</transition>
	</teleport>
</template>

<script>
export default {
	props: {
		open: {
			type: Boolean,
			required: true
		},
		title: {
			type: String,
			required: false
		}
	},
	emits: ['close']
}
</script>

<style scoped>
	div {
		position: fixed;
		top: 0;
		left: 0;
		height: 100vh;
		width: 100%;
		background-color: rgba(0, 0, 0, 0.75);
		z-index: 10;
	}

	dialog {
		position: fixed;
		top: 20vh;
		left: 10%;
		width: 80%;
		z-index: 100;
		border: none;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
		padding: 0;
		margin: 0;
		overflow: hidden;
	}

	header {
		background-color: var(--bs-blue);
		color: white;
		width: 100%;
		padding: 1rem;
	}

	header h2 {
		margin: 0;
	}

	section {
		padding: 1rem;
	}

	menu {
		padding: 1rem;
		display: flex;
		justify-content: flex-end;
		margin: 0;
	}

	.dialog-enter-from {

	}

	.dialog-enter-active {
		animation: modal 0.15s ease-out;
	}

	.dialog-enter-to {
		
	}

	.dialog-leave-from {
		
	}

	.dialog-leave-active {
		animation: modal 0.15s ease-in reverse;
	}

	.dialog-leave-to {
		
	}

	@keyframes modal {
		from {
			opacity: 0;
			transform: translateY(-50px) scale(0.9);
		}

		to {
			opacity: 1;
			transform: translateY(0) scale(1);
		}
	}

	@media (min-width: 768px) {
		dialog {
			left: calc(50% - 20rem);
			width: 40rem;
		}
	}
</style>