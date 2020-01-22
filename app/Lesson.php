<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Series;

class Lesson extends Model
{
    protected $guarded = [];

    /**
     * A lesson belongs to a series
     *
     * @return void
     */
    public function series() {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get next lesson after $this 
     *
     * @return \App\Lesson
     */
    public function getNextLesson() {
        $nextLesson = $this->series->lessons()->where('episode_number', '>', $this->episode_number)
                    ->orderBy('episode_number', 'asc')
                    ->first();
        
        if($nextLesson) {
            return $nextLesson;
        }

        return $this; // if not exists current lesson
    }

    /**
     * Get previous lesson for $this
     *
     * @return \App\Lesson
     */
    public function getPrevLesson() {
        $prevLesson = $this->series->lessons()->where('episode_number', '<', $this->episode_number)
                    ->orderBy('episode_number', 'desc')
                    ->first();
        
        if($prevLesson) {
            return $prevLesson;
        }

        return $this; // if not exists current lesson
    }
}
