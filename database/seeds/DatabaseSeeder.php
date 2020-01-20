<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // 
        factory(\App\User::class)->create([
        	'name' => 'masud',
        	'email' => 'masud@gmail.com'
        ]);

        factory(\App\Lesson::class, 10)->create();

    }
}
