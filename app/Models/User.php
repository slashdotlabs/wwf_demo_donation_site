<?php

namespace App\Models;

use App\Enums\UserTypeEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Enum\Laravel\HasEnums;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasEnums;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'user_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected array $enums = [
        'user_type' => UserTypeEnum::class
    ];

    public function donor_details()
    {
        return $this->hasOne(DonorDetail::class);
    }

    public function donor_subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
