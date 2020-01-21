<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use App\Lesson;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Redis;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_complete_a_lesson() {
    
    	//user
    	//series
    	//lesson
    	//$user-> completeLesson()
    	//redis-> user:12:series:12
    	
    	
        $this->flushRedis();
        
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();

        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $this->assertEquals(
            Redis::smembers('user:1:series:1'),
            [1, 2]
        );

        $this->assertEquals(
            $user->getNumberOfCompletedLessonsForASeries($lesson->series),
            2
        );
    }

    public function test_can_get_percentage_completed_for_series_for_a_user() {
        
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        factory(Lesson::class)->create(['series_id' => 1]);
        factory(Lesson::class)->create(['series_id' => 1]);
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $this->assertEquals(
            $user->percentageCompletedForSeries($lesson->series),
            50
        );
    }

    public function test_can_know_if_a_user_has_started_a_series() {
        //user, 2 series,
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3 = factory(Lesson::class)->create();

        //user watches a lesson in the 1st series
        $user->completeLesson($lesson2);

        // assert that returns true hasStartedseries(1)
        $this->assertTrue($user->hasStartedSeries($lesson->series));
        $this->assertFalse($user->hasStartedSeries($lesson3->series));
    }

    public function test_can_get_completed_lessons_for_a_series() {
        // user , series
        $this->flushRedis();

        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([ 'series_id' => 1 ]);
        $lesson3 = factory(Lesson::class)->create([ 'series_id' => 1 ]);

        //completes some lessons in the series
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        //get completed lessons method 
        $completedLessons = $user->getCompletedLessons($lesson->series);
        
        //assert that the lessons completed are in the return value 
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $completedLessons);
        $this->assertInstanceOf(Lesson::class, $completedLessons->random());

        $completedLessonsIds = $completedLessons->pluck('id')->all();

        $this->assertTrue(in_array($lesson->id, $completedLessonsIds));
        $this->assertTrue(in_array($lesson2->id, $completedLessonsIds ));
        $this->assertFalse(in_array($lesson3->id, $completedLessonsIds));
    }
}