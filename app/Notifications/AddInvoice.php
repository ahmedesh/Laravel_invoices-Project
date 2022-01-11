<?php
// notification to e-mail
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoice extends Notification
{
    use Queueable;
    private $invoice_id;

    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = 'http://localhost:8000/invoicesDetails/'.$this->invoice_id;

        return (new MailMessage)
            ->subject('اضافة فاتورة جديدة')  // اللي بتظهر فالعنوان من برا فالايميل بتاعك
            ->line('اضافة فاتورة جديدة')  // اللي بتظهر فالصفحه فاللينك لما تفنحه
            ->action('عرض الفاتورة', $url) // action يعني هيعملك زرار يروح علي لينك
            ->line('شكرا لاستخدامك 3ds_Program لادارة الفواتير');
    }

    public function toArray($notifiable)
    {
        return [

        ];
    }
}
