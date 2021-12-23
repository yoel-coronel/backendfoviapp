<?php

namespace App\Providers;

use App\Events\ResolveRequestPassword;
use App\Events\SendCodeForEmail;
use App\Events\WelcomeNewUser;
use App\Listeners\ClearTokenResetPasswordVerification;
use App\Listeners\SendCodeForEmailVerificationNotification;
use App\Listeners\SendEmailWelcomeNewUserNotification;
use App\Listeners\SendResetPasswordVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        WelcomeNewUser::class =>[
            SendEmailWelcomeNewUserNotification::class,
        ],
        SendCodeForEmail::class =>[
            SendResetPasswordVerification::class,
            SendCodeForEmailVerificationNotification::class,
        ],
        ResolveRequestPassword::class =>[
            ClearTokenResetPasswordVerification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
