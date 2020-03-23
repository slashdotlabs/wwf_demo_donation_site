<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccoutSetup extends Mailable
{
    use Queueable, SerializesModels;

    public User $donor;

    /**
     * Create a new message instance.
     *
     * @param User $donor
     */
    public function __construct(User $donor)
    {
        $this->donor = $donor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = app('auth.password.broker')->createToken($this->donor);
        $setup_url = route('password.reset', ['token' => $token]);
        return $this->markdown('mail.account_setup')->with('setup_url', $setup_url);
    }
}
