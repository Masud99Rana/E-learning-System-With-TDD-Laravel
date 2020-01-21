<template>
	<div>
		<div :data-vimeo-id="lesson.video_id" v-if="lesson"  id="handstick"></div>
		<!-- 50884628 -->
	</div>
</template>

<script>
	import Axios from 'axios'
	import Player from '@vimeo/player'

	export default{
		props: ['default_lesson'],
		data(){
			return {
				lesson: JSON.parse(this.default_lesson)
			}
		},
		mounted() {
		    const player = new Player('handstick');// id of the div
		    
		    player.on('play', function() {
		        console.log('played the video!');
		    });

		    player.on('ended', function() {
		        console.log('ended the video!');
		    });
		}
	}
</script>