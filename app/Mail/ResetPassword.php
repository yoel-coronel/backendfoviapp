<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'mails.html.message',
            [
                'view' => 'mails.user.reset_password',
                'parameters' => ['fullName' => $this->user->getFullName(), 'token' => $this->token]
            ]
        )
            ->to($this->user->email, $this->user->name)
            ->subject('Código de verificación | ' . config('app.name'));
    }
}
