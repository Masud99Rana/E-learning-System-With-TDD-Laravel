<?php

namespace Tests;

use Config;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAdmin() {
    	$user = factory(User::class)->create();

        Config::push('mrcasts.administrators', $user->email);
        
        $this->actingAs($user);
    }
}
