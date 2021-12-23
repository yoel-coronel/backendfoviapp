<?php

namespace App\Listeners;

use App\Events\ResolveRequestPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class ClearTokenResetPasswordVerification
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
     * @param  \App\Events\ResolveRequestPassword  $event
     * @return void
     */
    public function handle(ResolveRequestPassword $event)
    {
        DB::delete("delete from password_resets where email = ?",[$event->email]);
    }
}
