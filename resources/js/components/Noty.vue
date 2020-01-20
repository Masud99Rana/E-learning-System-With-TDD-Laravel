<template>
	<div class="alert alert-noty" :class="type" v-if="notification">
		<p class="text-center">
			{{ notification.message }}
		</p>
	</div>
</template>

<script>
	// import Swal from 'sweetalert';
	export default {
		created() {
			window.events.$on('notification', (payload) => {
				this.notification = payload;

				setTimeout(() =>{
					this.notification = null;
				}, 2500);
			})
		},
		data(){
			return {
				notification: null
			}
		},
		computed:{
			type(){
				return `alert-${this.notification.type}`;
			}
		}
	}
</script>

<style>
	.alert-noty{
		position: fixed;
		right: 20px;
		bottom: 40px;
		z-index: 999;
	}
</style>