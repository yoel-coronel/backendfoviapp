<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailWelcomeUser extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $clave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $clave)
    {
        $this->user = $user;
        $this->clave = $clave;
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
                'view' => 'mails.user.welcome',
                'parameters' => ['user' => $this->user,'clave'=>$this->clave]
            ]
        )
            ->to($this->user->email, $this->user->name)
            ->subject('Bienvenido al App FOVIPOL');
    }
}
