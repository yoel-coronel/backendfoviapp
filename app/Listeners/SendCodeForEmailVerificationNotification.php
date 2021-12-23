<?php

namespace App\Listeners;

use App\Events\SendCodeForEmail;
use App\Mail\ResetPassword;
use App\Mail\SendEmailWelcomeUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCodeForEmailVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendCodeForEmail  $event
     * @return void
     */
    public function handle(SendCodeForEmail $event)
    {
        Mail::send(new ResetPassword($event->user,$event->token));
    }
}
