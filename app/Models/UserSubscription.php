<?php

namespace App\Models;

use App\Enums\BillingCycleEnum;
use App\Enums\SubscriptionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;

class UserSubscription extends Model
{
    use HasEnums;

    protected $guarded = [];

    protected array $enums = [
        'subscription_type' => SubscriptionTypeEnum::class,
        'cycle' => BillingCycleEnum::class,
    ];

}
