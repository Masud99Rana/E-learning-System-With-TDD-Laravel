<?php 

namespace App\Entities;

use Redis;
use App\Series;
use App\Lesson;

trait Learning {
    /**
     * Mark a lesson as completed for a user
     *
     * @param [App\Lesson] $lesson
     * @return void
     */
    public function completeLesson($lesson) {
        Redis::sadd("user:{$this->id}:series:{$lesson->series->id}", $lesson->id);
    }
}