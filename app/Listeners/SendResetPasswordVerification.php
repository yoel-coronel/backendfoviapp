<?php

namespace App\Listeners;

use App\Events\SendCodeForEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SendResetPasswordVerification
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
        DB::delete("delete from password_resets where email = ?",[$event->user->email]);
        DB::table("password_resets")->insert(['email'=>$event->user->email,'token'=>bcrypt($event->token),'created_at'=>now()]);
    }
}
