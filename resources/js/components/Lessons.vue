<template>
	<div class="container">
		<h1 class="text-center">
			<button class="btn btn-primary" @click="createNewLesson">
				Create New Lesson
			</button>
		</h1>
		<ul class="list-group">
			<li class="list-group-item d-flex justify-content-between" v-for="lesson, key in lessons">
				<p class="text-dark">{{ lesson.title }}</p> 
				<p>
					<button class="btn btn-primary btn-xs" @click="editLesson(lesson)">
						Edit
					</button>
					<button class="btn btn-danger btn-xs" @click="deleteLesson(lesson.id, key)">
						Delete
					</button>
				</p>
			</li>
		</ul>
			<create-lesson></create-lesson>
	</div>
</template>

<script>
	
	import CreateLesson from './children/CreateLesson.vue';
	import Axios from 'axios';

	export default{
		props: ['default_lessons', 'series_id'],
		mounted(){
			this.$on('lesson_created', (lesson) =>{

				window.noty({
					message: 'Lesson created successfully',
					type: 'success'
				});

				this.lessons.push(lesson);
			});

			this.$on('lesson_updated', (lesson)=>{
				let lessonIndex = this.lessons.findIndex(l=> {
					return lesson.id == l.id;
				});

				this.lessons.splice(lessonIndex, 1, lesson);

				window.noty({
					message: 'Lesson updated successfully',
					type: 'success'
				})
			})
		},
		components: {
			"create-lesson": CreateLesson
		},
		data(){
			return{
				lessons: JSON.parse(this.default_lessons),
			}
		},

		computed: {
			// formattedLessons(){
			// 	return JSON.parse(this.lessons);
			// }
		},

		methods:{
			createNewLesson() {
				this.$emit('create_new_lesson', this.series_id);
			},

			deleteLesson(id, key) {
				if(confirm('Are you sure you wanna delete ?')) {
					Axios.delete(`/admin/${this.series_id}/lessons/${id}`)
						 .then(resp => {
						 	this.lessons.splice(key, 1)
						 	window.noty({
								message: 'Lesson deleted successfully',
								type: 'success'
							})
						 }).catch(error => {
						 	window.handleErrors(error)
						 })
				}
			},

			editLesson(lesson) {
				let seriesId = this.series_id
				this.$emit('edit_lesson', { lesson, seriesId })
			}                                                             
		}
	}
</script>