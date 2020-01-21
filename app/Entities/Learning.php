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

    /**
     * Get percentage completed for a series for a user
     *
     * @param [App\Series] $series
     * @return void
     */
    public function percentageCompletedForSeries($series) {
        $numberOfLessonsInSeries = $series->lessons->count();
        $numberOfCompletedLessons = $this->getNumberOfCompletedLessonsForASeries($series);

        return ($numberOfCompletedLessons / $numberOfLessonsInSeries) * 100;
    }

    /**
     * Get number of completed lessons for a series
     *
     * @param [App\Series] $series
     * @return void
     */
    public function getNumberOfCompletedLessonsForASeries($series) {
        return count($this->getCompletedLessonsForASeries($series));
    }

    /**
     * Check if a user has started a series
     *
     * @param [App\Series] $series
     * @return boolean
     */
    public function hasStartedSeries($series) {
        return $this->getNumberOfCompletedLessonsForASeries($series) > 0;
    }

    /**
     * Get array of completed lessons ids for a series
     *
     * @param [App\Series] $series
     * @return array
     */
    public function getCompletedLessonsForASeries($series) {
        return Redis::smembers("user:{$this->id}:series:{$series->id}");
    }

    /**
     * Get all completed lessons for a series
     *
     * @param [App\Series] $series
     * @return \Illuminate\Support\Collection(App\Lesson)
     */
    public function getCompletedLessons($series) {
        // 1, 2, 4
        return Lesson::whereIn('id', 
            $this->getCompletedLessonsForASeries($series)
        )->get();
    }

    /**
     * Check if user has completed a lesson
     *
     * @param [App\Lesson] $lesson
     * @return boolean
     */
    public function hasCompletedLesson($lesson) {
        return in_array(
            $lesson->id,
            $this->getCompletedLessonsForASeries($lesson->series)
        );
    }

    /**
     * Get all the series being watch ids
     *
     * @return array
     */
    public function seriesBeingWatchedIds() {
        $keys = Redis::keys("user:{$this->id}:series:*");
        $seriesIds = [];
        foreach($keys as $key):
            $seriedId = explode(':', $key)[3];
            array_push($seriesIds, $seriedId);
        endforeach;

        return $seriesIds;
    }

    /**
     * Get all the series a user is watching
     *
     * @return void
     */
    public function seriesBeingWatched() {
        return collect($this->seriesBeingWatchedIds())->map(function($id){
            return Series::find($id);
        })->filter();
    }

    /**
     * Get total number of lessons user has ever completed
     *
     * @return integer
     */
    public function getTotalNumberOfCompletedLessons() {
        $keys = Redis::keys("user:{$this->id}:series:*");

        $result = 0;

        //user:1:series:1 => [1,2,3]
        //user:1:series:2
        foreach($keys as $key):
            $result = $result + count(Redis::smembers($key));
        endforeach;

        return $result;
    }
}