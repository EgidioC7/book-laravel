<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'published_at' => $faker->dateTime(),
        'title' => $faker->sentence(),
        'description' => $faker->paragraph()
    ];
});
