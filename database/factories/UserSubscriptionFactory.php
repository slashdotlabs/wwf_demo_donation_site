<?php

/** @var Factory $factory */

use App\Enums\BillingCycleEnum;
use App\Enums\SubscriptionTypeEnum;
use App\Models\UserSubscription;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(UserSubscription::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->state(UserSubscription::class, 'adoption', [
    'subscription_type' => SubscriptionTypeEnum::adoption(),
    'amount' => 500,
    'cycle' => BillingCycleEnum::monthly()
]);

$factory->state(UserSubscription::class, 'membership', function (Faker $faker) {
    return [
        'subscription_type' => SubscriptionTypeEnum::membership(),
        'amount' => $faker->randomElement([1000, 2500, 3000]),
        'cycle' => $faker->randomElement(BillingCycleEnum::getValues())
    ];
});
