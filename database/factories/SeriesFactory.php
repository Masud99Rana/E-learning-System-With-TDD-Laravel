<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Series;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Series::class, function (Faker $faker) {
	$title = $faker->sentence(5);
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'image_url' => asset('assets/img/series.jpg'),
        'description' => $faker->paragraph()
    ];
});

// $faker->imageUrl();