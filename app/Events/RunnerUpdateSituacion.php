<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RunnerUpdateSituacion
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $iden_plan_pla;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $iden_plan_pla)
    {
        $this->iden_plan_pla = $iden_plan_pla;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
