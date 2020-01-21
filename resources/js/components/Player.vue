<template>
	<div>
		<div :data-vimeo-id="lesson.video_id" v-if="lesson"  id="handstick"></div>
		<!-- 50884628 -->
	</div>
</template>

<script>
	import Axios from 'axios'
	import Player from '@vimeo/player'
	import Swal from 'sweetalert';

	export default {
	    props: ['default_lesson', 'next_lesson_url'],
	    data() {
	        return {
	            lesson: JSON.parse(this.default_lesson)
	        }
	    },
	    methods: {
	        displayVideoEndedAlert() {
	            if(this.next_lesson_url) {
	                Swal('Yaaay ! You completed this lesson !')
	                .then(() => {
	                    window.location = this.next_lesson_url
	                })
	            } else {
	                Swal('Yaaay ! You completed this series !')
	            }
	            
	        },
	        completeLesson() {
	            Axios.post(`/series/complete-lesson/${this.lesson.id}`, {})
	                 .then(resp => {
	                     this.displayVideoEndedAlert()
	                 })
	        }
	    },
	    mounted() {
	        const player = new Player('handstick')

	        player.on('ended', () => {
	            this.completeLesson()
	        })
	    }
	}
</script>