<?php

namespace App\Providers\App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class DonorSubscribed
{
    use SerializesModels;

    public User $donor;

    /**
     * Create a new event instance.
     *
     * @param User $donor
     */
    public function __construct(User $donor)
    {
        $this->donor = $donor;
    }
}
