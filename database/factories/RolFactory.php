<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Caffeinated\Shinobi\Models\Role; ;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->unique()->name,
    ];
});
