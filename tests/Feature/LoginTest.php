<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    // use RefreshDatabase;

    public function test_correct_response_after_user_logs_in()
    {
        $user = factory(User::class)->create();

        // dd($user);
        $logged = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password'
        ], ['X-Requested-With' => 'XMLHttpRequest']);


        $logged->assertStatus(200);
        $logged->assertJson([
            'status' => 'ok'
        ]);
        $logged->assertSessionHas('success', 'Successfully logged in.');
    }

    public function test_a_user_receives_correct_message_when_passing_in_wrong_credentials()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ])->assertStatus(422)
        ->assertJson([
            'message' => 'These credentials do not match our records.'
        ]);
    }
}
