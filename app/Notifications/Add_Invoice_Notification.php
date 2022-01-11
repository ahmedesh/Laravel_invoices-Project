<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Add_Invoice_Notification extends Notification
{
    use Queueable;
    private $invoice_id;

    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }


    public function via($notifiable)
    {
//        return ['mail'];
        return ['database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toArray($notifiable)
    {
        return [

        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'id'   => $this->invoice_id,
            'title'=> 'تم اضافه فاتوره جديده بنجاح بواسطه',
            'user' => Auth::User()->name,
        ];
    }
}
