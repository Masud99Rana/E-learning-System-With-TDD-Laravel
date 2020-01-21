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
    	//$user->completeLesson()
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

        // $this->assertEquals(
        //     $user->getNumberOfCompletedLessonsForASeries($lesson->series),
        //     2
        // );
    }
}
