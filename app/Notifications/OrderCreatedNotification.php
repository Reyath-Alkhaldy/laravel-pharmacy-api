<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
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
        return ['database','broadcast'];
        // return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pharmacy_id' => $this->order->pharmacy_id,
            'user_id' => $this->order->user_id,
            'number' => $this->order->number,
            'payment_status' => $this->order->payment_status,
            'payment_method' => $this->order->payment_method,
            'status' => $this->order->status,
            'discount' => $this->order->discount,
            'total' => $this->order->total,
            'tax' => $this->order->tax,
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'pharmacy_id' => $this->order->pharmacy_id,
            'user_id' => $this->order->user_id,
            'number' => $this->order->number,
            'payment_status' => $this->order->payment_status,
            'payment_method' => $this->order->payment_method,
            'status' => $this->order->status,
            'discount' => $this->order->discount,
            'total' => $this->order->total,
            'tax' => $this->order->tax,
        ];
    }
}
