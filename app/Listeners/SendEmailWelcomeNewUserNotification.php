<?php

namespace App\Listeners;

use App\Events\WelcomeNewUser;
use App\Mail\SendEmailWelcomeUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailWelcomeNewUserNotification
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
     * @param  \App\Events\WelcomeNewUser  $event
     * @return void
     */
    public function handle(WelcomeNewUser $event)
    {
        Mail::send(new SendEmailWelcomeUser($event->user,$event->clave));
    }
}
