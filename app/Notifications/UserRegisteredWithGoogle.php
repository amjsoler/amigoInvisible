<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegisteredWithGoogle extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $userPassword)
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
        $appname = env("APP_NAME");

        return (new MailMessage)
            ->line("Bienvenido a $appname")
            ->line('Tu cuenta ha sido creada correctamente con los datos de tu cuenta de Google.')
            ->line('Si quieres modificar algo, puedes hacerlo desde tu perfil.')
            ->line("Además, te hemos generado una contraseña para que puedas acceder a tu cuenta: $this->userPassword")
            ->line('Te recomendamos que la cambies lo antes posible para reforzar la seguridad');
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
