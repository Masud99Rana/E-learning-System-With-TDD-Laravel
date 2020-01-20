<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
     return [
        'title' => $faker->sentence(3),
        'description' => $faker->paragraph(3),
        'series_id' => function() {
        	return factory(\App\Series::class)->create()->id;
        },
        'episode_number' => 100,
        'video_id' => '230485453'
    ];
});
