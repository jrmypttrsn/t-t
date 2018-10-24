<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 10/24/18
 * Time: 11:57 AM
 */

use Faker\Generator as Faker;

$factory->define(App\Models\Operation::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'is_complete' => $faker->boolean,
    ];
});
