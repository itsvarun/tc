<?php

use Faker\Generator as Faker;

$autoIncrement = autoIncrement();

$factory->define(App\Task::class, function (Faker $faker) use ($autoIncrement) {
	$autoIncrement->next();
	
    return [
        'name' => $faker->sentence,
        'category_id' => App\Category::inRandomOrder()->first()->id, // $faker->numberBetween(min, max)
        'user_id' => App\User::inRandomOrder()->first()->id,
        'order' => $autoIncrement->current(),
    ];
});

function autoIncrement() {
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}
