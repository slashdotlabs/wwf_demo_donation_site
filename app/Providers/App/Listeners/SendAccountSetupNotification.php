<?php

namespace App\Providers\App\Listeners;

use App\Mail\AccoutSetup;
use App\Providers\App\Events\DonorSubscribed;
use Illuminate\Support\Facades\Mail;

class SendAccountSetupNotification
{

    public DonorSubscribed $event;

    /**
     * Create the event listener.
     *
     * @param DonorSubscribed $event
     */
    public function __construct(DonorSubscribed $event)
    {
        $this->event = $event;
    }

    /**
     * Handle the event.
     *
     * @param DonorSubscribed $event
     * @return void
     */
    public function handle(DonorSubscribed $event)
    {
        Mail::to($event->donor)
            ->send(new AccoutSetup($event->donor));
    }
}
