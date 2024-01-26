<?php

namespace App\Notifications;

// use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Otp;

class EmailVerificationNotificatin extends Notification
{
    use Queueable;

    public $message;
    public $subject;
    public $mailer;
    private $otp;


    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message = "Use the belw code to verificatin process";
        $this->subject = "Verification Needed";
        $this->mailer = "smtp";
        $this->otp = new Otp;
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
        $otp = $this->otp->generate($notifiable->email,'numeric',6,60);
        return (new MailMessage)
        ->mailer($this->mailer)
        ->subject($this->subject)
        ->greeting("Hello : {$notifiable->name}")
        ->line($this->message)
        ->line("code : " .$otp->token)
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
            //
        ];
    }
}
