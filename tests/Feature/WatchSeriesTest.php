<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Lesson;

class WatchSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_complete_a_series() {

        $this->flushRedis();

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([ 'series_id' => 1 ]);
         // post -> complete-lessons

         $response = $this->post("/series/complete-lesson/{$lesson->id}", []);
        // asert has 
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok'
        ]);
        $this->assertTrue(
            $user->hasCompletedLesson($lesson)
        );
        $this->assertFalse(
            $user->hasCompletedLesson($lesson2)
        );
    }
}

