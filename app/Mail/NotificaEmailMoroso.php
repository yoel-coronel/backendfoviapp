<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NotificaEmailMoroso extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Collection
     */
    private $collection;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

       $dato =  optional($this->collection);

        return $this->markdown(
            'mails.html.message',
            [
                'view' => 'mails.user.notificacion_moroso',
                'parameters' => ["dato" =>$dato]
            ]
        )
            //->to($this->user->email, $this->user->name)
            ->to($dato['email'], $dato['full_name'])
            ->subject('Notificación de Morosidad | FOVIPOL');
    }
}
