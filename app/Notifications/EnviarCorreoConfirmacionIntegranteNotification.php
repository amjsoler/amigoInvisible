<?php

namespace App\Notifications;

use App\Models\Grupo;
use App\Models\Integrante;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class EnviarCorreoConfirmacionIntegranteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Grupo $grupo, public Integrante $integrante)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $precio = "";
        if(isset($this->grupo->precio_minimo) && isset($this->grupo->precio_maximo)){
            $precio = "Se podrá gastar entre " . $this->grupo->precio_minimo . "€ y " . $this->grupo->precio_maximo . "€";
        } elseif(!isset($this->grupo->precio_minimo) && !isset($this->grupo->precio_maximo)){
            $precio = "No habrá gasto mínimo ni máximo";
        }else{
            if(isset($this->grupo->precio_minimo)) {
                $precio = $this->grupo->precio_minimo . "€ como mínimo";
            }else{
                $precio = "No hay gasto mínimo";
            }

            if(isset($this->grupo->precio_maximo)) {
                $precio .= $this->grupo->precio_maximo . "€ como máximo";
            }else{
                $precio .= "No hay gasto máximo";
            }
        }

        $tematica = "";
        if(isset($this->grupo->tematica_regalos)){
            $tematica = "La temática de los regalos será: " . $this->grupo->tematica_regalos;
        }

        $fecha_autoasignacion = "";
        if(isset($this->grupo->fecha_autoasignacion)){
            $fecha_autoasignacion = "La asignación de participantes se hará de forma automática el día " . Carbon::parse($this->grupo->fecha_autoasignacion)->format("d/m/Y") . " a las " . Carbon::parse($this->grupo->fecha_autoasignacion)->format("H:i") . ". Si tu participación no está confirmada para entonces, el sistema te excluirá del reparto y no podrás participar en este grupo";
        }

        return (new MailMessage)
            ->subject('Te han invitado a un grupo de ' . env('APP_NAME'))
            ->line("Te han invitado a formar parte del grupo " . $this->grupo->nombre . " en " . env("APP_NAME"))
            ->lineIf(!empty($precio), $precio)
            ->lineIf(!empty($tematica), $tematica)
            ->lineIf(!empty($fecha_autoasignacion), $fecha_autoasignacion)
            ->line("Si quieres aceptar y entrar en este grupo, simplemente tienes que pulsar el botón que encontrarás a continuación:")
            ->action("Aceptar invitación", route("aceptarinvitacion", array("grupo" => $this->grupo->id, "integrante" => $this->integrante->id, "hash" => $this->integrante->hash_confirmacion)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
