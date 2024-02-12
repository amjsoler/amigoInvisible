<?php

namespace App\Events;

use App\Models\Grupo;
use App\Models\Integrante;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevoIntegranteCreado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Grupo $grupo, public Integrante $integrante)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
