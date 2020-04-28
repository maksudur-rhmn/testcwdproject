<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Faq;
use Faker\Generator as Faker;

$factory->define(Faq::class, function (Faker $faker) {
    return [
        'faq_question'  => $faker->sentence($nbWords = 2, $variableNbWords = true),
        'faq_answer'    => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'created_at'    =>  now(),
    ];
});
