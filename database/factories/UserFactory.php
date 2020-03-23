<?php

/** @var Factory $factory */

use App\Enums\UserTypeEnum;
use App\Models\DonorDetail;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'donor', [
    'user_type' => UserTypeEnum::donor()
]);

$factory->afterCreatingState(User::class, 'donor', function ($user, $faker) {
    $user->donor_details()->save(\factory(DonorDetail::class)->make());
});

$factory->state(User::class, 'admin', ['user_type' => UserTypeEnum::admin()]);
