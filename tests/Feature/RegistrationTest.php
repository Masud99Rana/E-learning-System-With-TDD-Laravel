<?php

namespace Tests\Feature;

use Mail;
use App\User;
use Tests\TestCase;
use App\Mail\ConfirmYourEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_user_has_a_default_username_after_registration()
    {
        Mail::fake();

        $this->withoutExceptionHandling();

        $this->post('/register', [
            'name' => 'Masud Rana',
            'email' => 'masud@gmail .com',
            'password' => 'password'
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'username' => Str::slug('Masud Rana')
        ]);
    }

    public function test_a_user_has_a_token_after_registration()
    {
        Mail::fake();

        $this->withoutExceptionHandling();

        $this->post('/register', [
            'name' => 'Masud Rana',
            'email' => 'masud@gmail .com',
            'password' => 'password'
        ])->assertRedirect();

        $user = User::find(1);
        
        $this->assertNotNull($user->confirm_token);
        $this->assertFalse($user->isConfirmed());
    }

    public function test_an_email_is_sent_to_newly_registered_users()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        // register new user
        $this->post('/register', [
            'name' => 'Masud Rana',
            'email' => 'masud@gmail.com',
            'password' => 'password'
        ])->assertRedirect();

        // Mail::assertSent(ConfirmYourEmail::class);
        //assert that a particular email was sent 
        Mail::assertQueued(ConfirmYourEmail::class);
    }

}
