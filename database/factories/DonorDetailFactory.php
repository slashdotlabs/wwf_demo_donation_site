<?php

/** @var Factory $factory */

use App\Models\DonorDetail;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(DonorDetail::class, function (Faker $faker) {
    return [
        'phone_number' => $faker->phoneNumber,
        'city' => $faker->city,
        'country' => $faker->country,
        'postal_code' => $faker->postcode
    ];
});
