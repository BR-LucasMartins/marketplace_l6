<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;



class StoreReiceveNewOrder extends Notification
{
    use Queueable;

    
    public function __construct()
    {
        //
    }

    
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

   
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Você recebeu um novo pedido!')
                    ->greeting('Olá vendedor , tudo bem?')
                    ->line('Você recebeu um novo pedido na loja!')
                    ->action('Ver pedido', route('admin.orders.my'));
                    
    }

   
    public function toArray($notifiable)
    {
        return [
            'message' => 'Você tem um novo pedido solicitado!'
        ];
    }



}
