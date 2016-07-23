<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt("qwerty")
    ];
});

$factory->define(App\Book::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'author' => $faker->firstName(),
        'year' => $faker->numberBetween($min = 1880, $max = 2016),
        'genre' => $faker->word,
    ];
});
