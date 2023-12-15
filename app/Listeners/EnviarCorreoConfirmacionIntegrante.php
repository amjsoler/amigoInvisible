<?php

namespace App\Listeners;

use App\Events\NuevoIntegranteCreado;
use App\Notifications\EnviarCorreoConfirmacionIntegranteNotification;
use Illuminate\Support\Facades\Notification;

class EnviarCorreoConfirmacionIntegrante
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NuevoIntegranteCreado $event): void
    {
        Notification::route('mail', $event->integrante->correo)
            ->notify(new EnviarCorreoConfirmacionIntegranteNotification($event->grupo, $event->integrante));
    }
}
