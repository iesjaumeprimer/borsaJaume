<?php

namespace App\Notifications;

use App\Entities\Oferta;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidateOffer extends Notification
{
    use Queueable;
    protected $offer;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = '/ofertas';
        $oferta = Oferta::find($this->offer);
        return (new MailMessage)
                    ->line("Ha arribat una oferta de treball de l'empresa ".$oferta->Empresa->nombre.":")
                    ->line($oferta->descripcion)
                    ->line($oferta->puesto)
                    ->line($oferta->tipo_contrato)
                    ->line($oferta->contacto)
                    ->line($oferta->telefono)
                    ->line($oferta->email)
                    ->action('Validar Oferta', url('/ofertas'))
                    ->line('!Adeu!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
